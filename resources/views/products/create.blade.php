@extends('layout.app')

@section('content')
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Add Product</h1>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Product Info</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('products.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="inputName">Product Name</label>
                        <input type="text" class="form-control" id="inputName" name="name"
                               placeholder="Enter product name" required>
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label" for="inputPrice">Price</label>
                        <input type="text" class="form-control" id="inputPrice" name="price"
                        placeholder="Enter product Price" required>
                    </div>


                    <div class="mb-3">
                        <label class="form-label" for="inputDescription">Description</label>
                        <textarea rows="3" class="form-control" id="inputDescription" name="description"
                                  placeholder="Enter product description" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="inputStatus">Status</label>
                        <select class="form-control" id="inputStatus" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
