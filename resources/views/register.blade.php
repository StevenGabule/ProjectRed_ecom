@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-10">

                <div class="card">

                    <div class="card-header">{{ __('Register Your Shop') }}</div>

                    <div class="card-body">

                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endforeach

                        <form method="POST" action="{{ route('vendor.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="vendor_avatar"
                                       class="col-md-3 col-form-label text-md-right">{{ __('Shop Logo') }}</label>

                                <div class="col-md-8">
                                    <input id="vendor_avatar" type="file" class="mb-2" name="vendor_avatar" required>
                                    <img src="{{ asset('images/image-placeholder.jpg') }}" id="preview_img"
                                         class="img-fluid" width="300" height="300" alt="">
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="title"
                                       class="col-md-3 col-form-label text-md-right">{{ __('Shop Name') }}</label>

                                <div class="col-md-8">
                                    <input id="title" type="text" class="form-control" name="title"
                                           value="{{ old('title', 'shop name') }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="short_description"
                                       class="col-md-3 col-form-label text-md-right">{{ __('Short Description') }}</label>

                                <div class="col-md-8">
                                    <textarea id="short_description" rows="3" class="form-control"
                                              name="short_description"
                                              required>{{ old('short_description', 'short description') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description"
                                       class="col-md-3 col-form-label text-md-right">{{ __('Full Description') }}</label>

                                <div class="col-md-8">
                                    <textarea id="description" rows="5" class="form-control" name="description"
                                              required>{{ old('description', 'long description ... . . . . .') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="street_address"
                                       class="col-md-3 col-form-label text-md-right">{{ __('Street Address') }}</label>

                                <div class="col-md-8">
                                    <input id="street_address" type="text"
                                           class="form-control" name="street_address"
                                           value="{{ old('street_address', 'P-4 poblacion lapu-lapu street address') }}"
                                           required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone_number"
                                       class="col-md-3 col-form-label text-md-right">{{ __('Phone Number') }}</label>

                                <div class="col-md-8">
                                    <input id="phone_number" type="text" class="form-control"
                                           name="phone_number" value="{{ old('phone_number', '092838833838') }}"
                                           required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="postal_code"
                                       class="col-md-3 col-form-label text-md-right">{{ __('Postal Code') }}</label>

                                <div class="col-md-8">
                                    <input id="postal_code" type="text" class="form-control"
                                           name="postal_code" value="{{ old('postal_code', '02939') }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="owner"
                                       class="col-md-3 col-form-label text-md-right">{{ __('Owner of Store') }}</label>

                                <div class="col-md-8">
                                    <input id="owner" type="text" class="form-control"
                                           name="owner" value="{{ old('owner', Auth::user()->name) }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="date_established"
                                       class="col-md-3 col-form-label text-md-right">{{ __('Date Established') }}</label>

                                <div class="col-md-8">
                                    <input id="date_established" type="text" class="form-control"
                                           name="date_established" value="{{ old('date_established', '03/12/2020') }}"
                                           required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-3">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                    <a href="/home" class="btn btn-link">Cancel</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function (e) {
                    $('#preview_img').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(document).ready(function () {

            $("#vendor_avatar").change(function () {
                readURL(this);
            });
        })

    </script>
@endsection
