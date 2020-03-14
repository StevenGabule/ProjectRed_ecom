<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Dashboard Template · Vendors</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
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

                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Products</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">

                        <a href="{{ route('vendor.product.create') }}" class="btn btn-sm btn-outline-secondary">
                            <span data-feather="plus-circle"></span>
                            New Product
                        </a>
                    </div>
                </div>
                <h4>Section</h4>
                <table class="table table-bordered table-sm" id="prodTable" style="width: 100%;">
                    <thead>
                    <tr>
                        <th style="width: 5%; text-align: center;">Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th width="100px">Action</th>
                    </tr>
                    </thead>

                </table>
            </main>
        </div>
    </div>

</div>
<script src="{{ asset('js/app.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>

<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script>
    (function () {

        $('#prodTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('products.loadAll') }}",
            columns: [
                {
                    data: 'product_avatar',
                    name: 'product_avatar',
                    render: function(data) {
                        return `<img src="${data == "product_tmp.png" ? '/images/' + data : '/images/uploads/products/' + data}" alt="${data}" style="width: 35px;height: 35px;" />`
                    },
                    orderable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'qty',
                    name: 'qty',
                },
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        feather.replace();
    })()
</script>
</body>
</html>
