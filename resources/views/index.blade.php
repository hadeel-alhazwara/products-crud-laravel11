@extends("layout.app")

@section('title','Welcome')

@section("content")
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3"><strong>Welcome</strong> </h1>
        <div class="alert alert-success">
            أهلاً بك في لوحة التحكم الخاصة بالمنتجات 
        </div>
        

        <a href="{{ route('products.create') }}" class="btn btn-primary"> إضافة منتج جديد</a>
        <a href="{{ route('products.index') }}" class="btn btn-secondary"> عرض جميع المنتجات</a>
    </div>
</main>
@endsection