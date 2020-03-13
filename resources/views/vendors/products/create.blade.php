<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Dashboard Template · Vendors</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0 text-capitalize" href="#">{{ $vendor->title }}</a>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Sign out</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        @include('vendors.shared.__nav')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

            <div class="container" style="width: 750px">
                <div class="row">
                    <div class="col-lg-12">
                        <div
                            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                            <h1 class="h2">Add New Product</h1>
                        </div>

                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $error }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endforeach

                        <form action="{{ route('vendor.product.store', $vendor->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Product Category</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="category_id">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (int)old('category_id') === $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="inputProductName">Product Name</label>
                                <input type="text" class="form-control" id="inputProductName" placeholder=""
                                       name="name" value="{{ old('name') }}">
                            </div>


                            <div class="form-group">
                                <label for="exampleFormControlFile1">Product Image</label>
                                <input type="file" class="form-control-file mb-3" id="exampleFormControlFile1"
                                       name="product_avatar" value="{{ old('product_avatar') }}">
                                <img src="{{ asset('images/image-placeholder.jpg') }}" id="preview_img"
                                     class="img-fluid"
                                     style="width: 250px;height: 250px;" alt="default image">
                                <small id="emailHelp" class="form-text text-muted">Recommended size (300x300)</small>
                            </div>

                            <div class="form-group">
                                <label for="inputProductPrice">Product Price</label>
                                <input type="text" class="form-control" id="inputProductPrice" placeholder=""
                                       name="price" value="{{ old('price') }}">
                            </div>
                            <div class="form-group">
                                <label for="inputProductQty">Product Quantity</label>
                                <input type="text" class="form-control" id="inputProductQty" placeholder=""
                                       name="qty" value="{{ old('qty') }}">
                            </div>

                            <div class="form-group">
                                <label for="inputProductUnit">Product Unit</label>
                                <input type="text" class="form-control" id="inputProductUnit" placeholder=""
                                       name="unit" value="{{ old('unit') }}">
                            </div>

                            <div class="form-group">
                                <label for="inputShortDescription">Short Description</label>
                                <textarea class="form-control" id="inputShortDescription" rows="4"
                                          name="short_description">{{ old('short_description')  }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="inputFullDescription">Full Description</label>
                                <textarea class="form-control" id="inputFullDescription" rows="8"
                                          name="full_description">{{ old('full_description') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                        <br><br>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>
<script src="{{ asset('js/jquery-3.4.1.slim.min.js') }}"></script>
<script>window.jQuery || document.write('<script src="{{ asset('js/jquery.slim.min.js') }}"><\/script>')</script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script>
    (function () {
        feather.replace();

        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function (e) {
                    $('#preview_img').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#exampleFormControlFile1").change(function () {
            readURL(this);
        });

    })()
</script>
</body>
</html>
