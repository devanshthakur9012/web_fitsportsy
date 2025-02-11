@extends('frontend.master', ['activePage' => 'My Profile'])
@section('title', __('My Profile'))
@push('styles')
    <style>
        label{
            color: #ffffff;
        }
        .cardBorder{
            border: 1px solid #fff;
        }
        .form-control:disabled, .form-control[readonly]{
            color: #5e5e5e !important;
        }
    </style>
@endpush
@section('content')
    <section class="profile-area section-area">
        <div class="container list-bp">
            <div class="row justify-content-center">
                <div class="col-xl-9 col-lg-8">
                    @include('messages')
                    <div class="cardBorder p-3 widget shadow-sm rounded mb-4">
                        <div>
                            <div class="mb-3 overflow-hidden">
                                <h1 class="h4 mb-0 float-left ">My Profile </h1>
                            </div>
                            <hr>
                            @php
                                $userData = Common::fetchUserDetails();
                            @endphp
                           <form name="register_frm" id="register_frm" action="{{ url('user/update-profile') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <div class="row">
                                @isset($userData['pro_pic'])
                                    <div class="col-lg-12 col-md-12 col-12 mb-3">
                                        <img src="{{env('BACKEND_BASE_URL')}}/{{$userData['pro_pic']}}" alt="Profile Picture" style="max-width: 100px; max-height: 100px;">
                                    </div>
                                @endisset
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input id="image" type="file" class="form-control" name="image">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="username">Username <span class="text-danger">*</span></label>
                                        <input id="username" type="text" class="form-control" placeholder="Username" name="username" value="{{ $userData['name'] }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="password">Password <span class="text-danger">*</span></label>
                                        <input id="password" type="password" class="form-control" placeholder="Password" name="password">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                                        <input id="confirm_password" type="password" class="form-control" placeholder="Confirm Password" name="confirm_password">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="email">Email Address <span class="text-danger">*</span></label>
                                        <input id="email" type="email" class="form-control" placeholder="Enter Email" name="email" value="{{ $userData['email'] }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="phone">Contact No. <span class="text-danger">*</span></label>
                                        <input id="phone" type="text" class="form-control" placeholder="Enter Mobile Number" name="phone" value="{{ $userData['mobile'] }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-right">
                                    <button type="submit" id="continue_btn" class="btn btn-primary">Update Details</button>
                                </div>
                            </div>
                        </form>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ url('frontend/js/jquery.validate.min.js') }}"></script>
    <script>
        $("#register_frm").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                name:{
                    required:true,
                    maxlength:40
                },
                last_name:{
                    required:true,
                    maxlength:40
                },
                phone:{
                    required:true,
                    number:true
                },
                address:{
                    required:true,
                    maxlength:250
                }
            },
            messages: {},
            errorElement: 'div',
            highlight: function(element, errorClass) {
                $(element).css({
                    border: '1px solid #f00'
                });
            },
            unhighlight: function(element, errorClass) {
                $(element).css({
                    border: '1px solid #c1c1c1'
                });
            },
            submitHandler: function(form) {
                document.register_frm.submit();
                $("#continue_btn").attr('disabled', 'disabled').text('Processing...');
            }
        });
    </script>
@endpush
