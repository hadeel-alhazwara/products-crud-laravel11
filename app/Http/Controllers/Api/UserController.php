<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // GET /api/v1/admin/users عرض جميع المستخدمين
    public function index()
    {
     
        $users = User::latest()->paginate(10); 

        return response()->json($users);
    }

    // PATCH /api/v1/admin/users/{id}/toggle  تفعيل / تعطيل مستخدم
    public function toggleStatus(User $user)
    {

        if ($user->email_verified_at) {
            $user->email_verified_at = null;
        } else {
            $user->email_verified_at = now();
        }
        
        $user->save();
    
        return response()->json([
            'message' => 'User status toggled successfully',
            'status'  => $user->email_verified_at ? 'active' : 'inactive',
        ]);
    }
}
