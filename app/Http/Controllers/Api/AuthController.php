<?php


namespace App\Http\Controllers\Api;

use Illuminate\Auth\Notifications\VerifyEmail;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed', 
        ]);

        $user = User::create([
            'name' => $request->name, 
            'email' => $request->email,
            'password' => Hash::make($request->password), 
        ]);

        
        $user->notify(new VerifyEmail());
        
   
        return response()->json([
            'message' => 'تم إنشاء الحساب بنجاح. تحقق من بريدك لتفعيل الحساب.'
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email', 
            'password' => 'required|string', 
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['البريد أو كلمة المرور غير صحيحة.'],
            ]);
        }

        if (! $user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'يجب تأكيد البريد الإلكتروني أولاً.'
            ], 403);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'access_token' => $token, 
            'token_type' => 'Bearer', 
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}


