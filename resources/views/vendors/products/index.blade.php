<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Dashboard Template · Vendors</title>
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <style>
        .table th, .table td {
            vertical-align: middle !important;
        }

        .custom-img {
            width: 35px;
            height: 35px;
            border-radius: 4px;
            margin: auto;
        }
        .table-bg {
            background-color: #F5F7F7 !important;
        }
    </style>
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
                            <i class="fas fa-plus"></i>
                            Create
                        </a>
                    </div>
                </div>
                <table class="table table-sm table-bg" id="prodTable" style="width: 100%;">
                    <thead>
                    <tr>
                        <th class="no-sort" style="width: 3%"></th>
                        <th class="no-sort" style="width: 5%;">Image</th>
                        <th class="no-sort">Name</th>
                        <th class="no-sort">Price</th>
                        <th class="no-sort">Quantity</th>
                        <th>Category</th>
                        <th style="width:30px">Action</th>
                    </tr>
                    </thead>
                </table>
                <button type="button" name="checkAll" id="select_all" class="btn btn-dark btn-xs check">Select All</button>
                <button type="button" name="checkAll" id="deselect_all" class="btn btn-dark btn-xs uncheck">Deselect All</button>
                <button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-danger btn-xs">Delete</button>
            </main>
        </div>
    </div>

</div>

<div id="productDeleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 font-weight-bold">
                <h3 class="modal-title font-weight-bold text-dark-color">Confirmation</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <h5 class="font-weight-bold text-dark-color m-0 mb-3">Are you sure to proceed this?</h5>
                <p class="text-dark-color">
                    Caution: Removing of product information will also delete or remove the associate information in
                    customers, orders and reports information via connecting to this product!
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" name="ok_button" id="ok_button" class="btn btn-sm btn-dark">Yes, I understand
                </button>
                <button type="button" class="btn btn-link btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- end of model content -->
    </div><!-- end of modal dialog  -->
</div><!-- end of confirm modal -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script>
    (function () {

        $('#prodTable').DataTable({
            processing: true,
            serverSide: true,

            columnDefs: [{
                orderable: false,
                targets: 'no-sort',
                order: [],
            }],
            ajax: "{{ route('products.loadAll') }}",
            columns: [
                {
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'product_avatar',
                    name: 'product_avatar',
                    render: function (data) {
                        return `<div class="w-100 d-flex">
                                    <img src="${data === "product_tmp.png" ? `/images/${data}` : `/images/uploads/products/${data}`}" class="custom-img"  />
                                </div>`
                    }
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'price',
                    name: 'price',
                    searchable: false
                },
                {
                    data: 'qty',
                    name: 'qty',
                    searchable: false
                },
                {
                    data: 'catname',
                    name: 'catname',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        let vendId, prodId, arr;
        $(document).on('click', '.productDelete', function () {
            arr = $(this).attr('id').split('-');
            vendId = arr[1];
            prodId = arr[0];
            $(".modal-title").text("Confirmation");
            $('#ok_button').text('Yes, I understand');
            $('#productDeleteModal').modal('show');
        });

        $('#ok_button').click(function () {
            $.ajax({
                url: `/vendor/product/delete/${vendId}/${prodId}`,
                beforeSend: function () {
                    $('#ok_button').text('Deleting...');
                },
                success: function (data) {
                    $('#productDeleteModal').modal('hide');
                    $('#prodTable').DataTable().ajax.reload();
                }
            });
        });

        $(document).on('click', '#bulk_delete', function () {
            let id = [];
            if (confirm("Are you sure you want to Delete this data?")) {
                $('.product_checkbox:checked').each(function () {
                    id.push($(this).val());
                });

                if (id.length > 0) {
                    $.ajax({
                        url: "{{ route('vendor.products.multiples.destroy')}}",
                        method: "GET",
                        data: {id: id},
                        success: function (data) {
                            $('#prodTable').DataTable().ajax.reload();
                        }
                    });
                } else {
                    alert("Please select atleast one checkbox");
                }
            }
        });

        $(document).on('change', 'input[type=checkbox]', function () {
            if ($(this).prop('checked')) {
                $(this).parent().parent().parent().css({
                    'background': '#C2DBFF',
                    'transition': 'all 180ms'
                })
            } else {
                $(this).parent().parent().parent().css({
                    'background': 'none',
                    'color': 'black',
                })
            }
        });

        $(document).on('click', '#select_all', function () {
            $("tr.odd, tr.even").css({
                'background': '#C2DBFF'
            });
            $("input:checkbox").prop("checked", true);

        });

        $(document).on('click', '#deselect_all', function () {
            $("tr.odd, tr.even").css({
                'background': 'none'
            });
            $("input:checkbox").prop("checked", false);
        })

    })()
</script>
</body>
</html>
