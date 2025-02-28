@extends ('admin-sidebar.index')

@section('container')
    <div class="content">
        <h2>Add New Product</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="/admin/productlist/addnewproduct" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="product_name" class="form-control @error('product_name') is-invalid @enderror" value="{{ old('product_name') }}">
                @error('product_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Product Price</label>
                <input type="number" name="product_price" class="form-control @error('product_price') is-invalid @enderror" value="{{ old('product_price') }}">
                @error('product_price')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Product Stock</label>
                <input type="number" name="product_stock" class="form-control @error('product_stock') is-invalid @enderror" value="{{ old('product_stock') }}">
                @error('product_stock')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Product Image</label>
                <input type="file" name="product_image" class="form-control @error('product_image') is-invalid @enderror">
                @error('product_image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Product Description</label>
                <input type="text" name="product_description" class="form-control @error('product_description') is-invalid @enderror" value="{{ old('product_description') }}">
                @error('product_description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Product Slug</label>
                <input type="text" name="product_slug" class="form-control @error('product_slug') is-invalid @enderror" value="{{ old('product_slug') }}">
                @error('product_slug')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Brand Name</label>
                <select name="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                    <option value="">Select Brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->brand_id }}" 
                            {{ old('brand_id') == $brand->brand_id ? 'selected' : '' }}>
                            {{ $brand->brand_name }}
                        </option>
                    @endforeach
                </select>
                @error('brand_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            

            <div class="form-group">
                <label>Category Name</label>
                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->category_id }}" 
                            {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-success">Add</button>
        </form>
    </div>
    
@endsection