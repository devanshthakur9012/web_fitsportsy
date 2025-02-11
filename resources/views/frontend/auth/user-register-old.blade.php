@extends('frontend.master', ['activePage' => 'login'])
@section('title', __('Login'))
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css" integrity="sha512-DIW4FkYTOxjCqRt7oS9BFO+nVOwDL4bzukDyDtMO7crjUZhwpyrWBFroq+IqRe6VnJkTpRAS6nhDvf0w+wHmxg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    @media all and (display-mode: standalone) {
        #organizerLoginRadio {
            display: none;
        }
    }
</style>
<style>
    @media (max-width: 576px) {
        .imageHidden{
            display:none !important;
        }
        .col-lg-6{
            padding: 0px 15px !important;
        }
    }
</style>
<section class="section-area login-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="imageHidden col-lg-6 p-0 d-flex align-items-stretch">
                <img src="{{asset('/images/login_banner.png')}}" width="100%" alt="">
            </div>
            <div class="col-lg-6 p-0 d-flex align-items-stretch">
                <div class="card o-hidden shadow-sm border-0 w-100">
                   <div class="card-body p-0">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-12 d-flex justify-content-center align-items-center h-100">
                            <div class="p-lg-5 p-3 w-100">
                                <div class="text-center">
                                    <h1 class="h3 mb-4">Login to PlayOffz</h1>
                                </div>
                                @include('messages')
                                <form class="user" method="post" name="register_frm" id="register_frm">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label">Mobile Number</label>
                                        <input type="number" name="number" class="form-control form-control-user"
                                            id="number" placeholder="Enter Mobile Number..." required>
                                    </div>
                                    <div class="form-group otp-section" style="display:none;">
                                        <label for="otp">OTP</label>
                                        <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP">
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck"
                                                    name="remember_me">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="{{url('user/resetPassword')}}">Forgot Password?</a>
                                        </div>
                                    </div>
                                    <button type="button" id="verify_otp_btn" class="btn default-btn btn-user btn-block" style="display:none;">Verify OTP</button>
                                    <button type="submit" id="continue_btn"
                                        class="btn default-btn btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a href="{{url('user-register')}}">Create an Account!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script src="{{ url('frontend/js/jquery.validate.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function () {
        // Send OTP on mobile number submission
        $("#continue_btn").on('click', function (event) {
            event.preventDefault();
            const mobile = $('#number').val();
            const ccode = "+91"; // Assuming you have a country code field
            if (!mobile || mobile.length !== 10 || isNaN(mobile)) {
                iziToast.error({
                    title: 'Error',
                    position: 'topRight',
                    message: 'Please enter a valid 10-digit mobile number.'
                });
                return;
            }

            // Disable the button and change text
            $('#continue_btn').prop('disabled', true).text('Generating OTP...');

            $.ajax({
                url: "{{ route('verify-mobile-number') }}",
                type: 'POST',
                data: {
                    mobile: mobile,
                    ccode: ccode,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    // Re-enable the button and reset text
                    $('#continue_btn').prop('disabled', false).text('Continue');
                    if (response.status === 'success') {
                        iziToast.success({
                            title: 'Success',
                            position: 'topRight',
                            message: 'OTP sent successfully to your mobile number.'
                        });
                        // Show the OTP field
                        $('.otp-section').show();
                        $('#verify_otp_btn').show();
                        $('#continue_btn').hide();
                    } else {
                        iziToast.error({
                            title: 'Error',
                            position: 'topRight',
                            message: response.message
                        });
                    }
                },
                error: function () {
                    // Re-enable the button and reset text
                    $('#continue_btn').prop('disabled', false).text('Continue');
                    iziToast.error({
                        title: 'Error',
                        position: 'topRight',
                        message: 'Failed to send OTP. Please try again later.'
                    });
                }
            });
        });

        // Verify OTP and login the user
        $('#verify_otp_btn').on('click', function () {
            const otp = $('#otp').val();
            if (!otp || otp.length !== 4 || isNaN(otp)) {
                iziToast.error({
                    title: 'Error',
                    position: 'topRight',
                    message: 'Please enter a valid 4-digit OTP.'
                });
                return;
            }

            // Disable the OTP button and change text
            $('#verify_otp_btn').prop('disabled', true).text('Verifying OTP...');

            $.ajax({
                url: "{{ route('verify-login-otp') }}",
                type: 'POST',
                data: {
                    otp: otp,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    // Re-enable the button and reset text
                    $('#verify_otp_btn').prop('disabled', false).text('Verify OTP');
                    if (response.status === 'success') {
                        iziToast.success({
                            title: 'Success',
                            position: 'topRight',
                            message: response.message
                        });
                        setTimeout(() => {
                            window.location.href = "{{$redirectUrl}}";
                        }, 1000);
                    } else {
                        iziToast.error({
                            title: 'Error',
                            position: 'topRight',
                            message: response.message
                        });
                    }
                },
                error: function () {
                    // Re-enable the button and reset text
                    $('#verify_otp_btn').prop('disabled', false).text('Verify OTP');
                    iziToast.error({
                        title: 'Error',
                        position: 'topRight',
                        message: 'Failed to verify OTP. Please try again later.'
                    });
                }
            });
        });
    });
</script>
@endpush
{{-- NEW --}}
@extends('frontend.master', ['activePage' => 'login'])
@section('title', __('Login'))
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css"
    integrity="sha512-DIW4FkYTOxjCqRt7oS9BFO+nVOwDL4bzukDyDtMO7crjUZhwpyrWBFroq+IqRe6VnJkTpRAS6nhDvf0w+wHmxg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    @media all and (display-mode: standalone) {
        #organizerLoginRadio {
            display: none;
        }
    }
</style>
<style>
    @media (max-width: 576px) {
        .imageHidden {
            display: none !important;
        }

        .col-lg-6 {
            padding: 0px 15px !important;
        }
    }
</style>
<section class="section-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="imageHidden col-lg-6 p-0 d-flex align-items-stretch">
                <img src="{{asset('/images/login_banner.png')}}" width="100%" alt="">
            </div>
            <div class="col-lg-6 p-0 d-flex align-items-stretch login-section">
                <div class="card o-hidden shadow-sm border-0 w-100">
                    <div class="card-body p-0">
                        <div
                            class="col-xl-12 col-lg-12 col-md-12 col-12 d-flex justify-content-center align-items-center h-100">
                            <div class="p-lg-5 p-3 w-100">
                                <div class="text-center">
                                    <h1 class="h3 mb-4">Login to PlayOffz</h1>
                                </div>
                                @include('messages')
                                <form class="user" method="post" name="register_frm" id="register_frm">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label">Mobile Number</label>
                                        <input type="number" name="number" class="form-control form-control-user"
                                            id="number" placeholder="Enter Mobile Number..." required>
                                    </div>
                                    <div class="form-group otp-section" style="display:none;">
                                        <label for="otp">OTP</label>
                                        <input type="text" class="form-control" id="otp" name="otp"
                                            placeholder="Enter OTP">
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck"
                                                    name="remember_me">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="{{url('user/resetPassword')}}">Forgot Password?</a>
                                        </div>
                                    </div>
                                    <button type="button" id="verify_otp_btn" class="btn default-btn btn-user btn-block"
                                        style="display:none;">Verify OTP</button>
                                    <button type="submit" id="continue_btn" class="btn default-btn btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a href="{{url('user-register')}}">Create an Account!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 p-0 d-none register-section justify-content-center align-items-stretch">
                <div class="card o-hidden shadow-sm border-0 w-100 h-100">
                    <div class="card-body p-0">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-12 d-flex justify-content-center align-items-center h-100">
                            @if(!Session::has('success'))
                                <div class="p-lg-5 p-3 w-100">
                                    <div class="text-center">
                                        <h1 class="h3 mb-4">Create An Account</h1>
                                        <p class="ot_err text-danger text-left"></p>
                                    </div>
                                    <form class="user" method="post" name="register_register_frm" id="register_register_frm">
                                        @csrf
                                        <div class="form-group">
                                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" name="full_name" class="form-control form-control-user"
                                                value="{{old('full_name')}}" id="register_full_name" placeholder="Enter Name">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control form-control-user"
                                                value="{{old('email')}}" name="email" id="register_email"
                                                placeholder="Enter Email Adress">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Mobile Number <span class="text-danger">*</span> <span
                                                    style="font-size:10px;" class="text-muted">10 digit mobile
                                                    number</span></label>
                                            <input type="number" class="form-control form-control-user"
                                                value="{{old('mobile_number')}}" id="register_mobile_number" name="mobile_number"
                                                placeholder="Enter Mobile number">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control form-control-user" id="register_password"
                                                autocomplete="new-password" name="password" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <div id="recaptcha-container" class="mb-3"></div>
                                        </div>
                                        <button type="submit" id="register_continue_btn" class="btn default-btn btn-user btn-block">
                                            Register
                                        </button>
                                    </form>
                                    <div class="mt-4" id="register_otp_frm" style="display: none;">
                                        <p>Enter OTP sent to your mobile number</p>
                                        <div class="form-group">
                                            <label class="form-label">OTP (One Time Password) <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" min="4" max="4" class="form-control form-control-user"
                                                id="register_otp_password" placeholder="OTP" required>
                                        </div>
                                        <button type="button" onclick="verify()" id="register_verify_btn"
                                            class="btn default-btn btn-user btn-block">
                                            Continue
                                        </button>
                                    </div>
                                    <hr>
                                    <div class="text-center">
                                        <a href="{{url('user-login')}}">Already have an account, <b>Login</b> here</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
    <script src="{{ url('frontend/js/jquery.validate.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"
        integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function () {
            // Send OTP on mobile number submission
            $("#continue_btn").on('click', function (event) {
                event.preventDefault();

                const mobile = $('#number').val();
                const ccode = "+91"; // Assuming the country code is fixed

                if (!mobile || mobile.length !== 10 || isNaN(mobile)) {
                    iziToast.error({
                        title: 'Error',
                        position: 'topRight',
                        message: 'Please enter a valid 10-digit mobile number.'
                    });
                    return;
                }

                // Disable the button and show loading text
                $('#continue_btn').prop('disabled', true).text('Generating OTP...');

                $.ajax({
                    url: "{{ route('verify-mobile-number') }}",
                    type: 'POST',
                    data: {
                        mobile: mobile,
                        ccode: ccode,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#continue_btn').prop('disabled', false).text('Continue');

                        if (response.status === 'success') {
                            iziToast.success({
                                title: 'Success',
                                position: 'topRight',
                                message: 'OTP sent successfully to your mobile number.'
                            });

                            // Show OTP field and Verify OTP button, hide Continue button
                            $('.otp-section').show();
                            $('#verify_otp_btn').show();
                            $('#continue_btn').hide();
                        } else {
                            iziToast.warning({
                                title: 'New User',
                                position: 'topRight',
                                message: 'Mobile number not registered. Please enter your details to proceed.'
                            });

                            $('#register_mobile_number').val(mobile);
                            // Show registration form
                            $('.register-section').removeClass('d-none');
                            $('.register-section').addClass('d-flex');
                            $('.login-section').remove();
                        }
                    },
                    error: function () {
                        $('#continue_btn').prop('disabled', false).text('Continue');
                        iziToast.error({
                            title: 'Error',
                            position: 'topRight',
                            message: 'Failed to send OTP. Please try again later.'
                        });
                    }
                });
            });

            // Verify OTP and log in the user
            $('#verify_otp_btn').on('click', function () {
                const otp = $('#otp').val();

                if (!otp || otp.length !== 4 || isNaN(otp)) {
                    iziToast.error({
                        title: 'Error',
                        position: 'topRight',
                        message: 'Please enter a valid 4-digit OTP.'
                    });
                    return;
                }

                // Disable the Verify OTP button and show loading text
                $('#verify_otp_btn').prop('disabled', true).text('Verifying OTP...');

                $.ajax({
                    url: "{{ route('verify-login-otp') }}",
                    type: 'POST',
                    data: {
                        otp: otp,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#verify_otp_btn').prop('disabled', false).text('Verify OTP');

                        if (response.status === 'success') {
                            iziToast.success({
                                title: 'Success',
                                position: 'topRight',
                                message: 'Login successful! Redirecting...'
                            });

                            setTimeout(() => {
                                window.location.href = "{{ url('/') }}"; // Redirect to home or dashboard
                            }, 1000);
                        } else {
                            iziToast.error({
                                title: 'Error',
                                position: 'topRight',
                                message: response.message
                            });
                        }
                    },
                    error: function () {
                        $('#verify_otp_btn').prop('disabled', false).text('Verify OTP');
                        iziToast.error({
                            title: 'Error',
                            position: 'topRight',
                            message: 'Failed to verify OTP. Please try again later.'
                        });
                    }
                });
            });
        });
    </script>

    {{-- FOR REGISETRTAION --}}
    <script>
        // Validation and submission handler
        $("#register_register_frm").validate({
            rules: {
                register_full_name: { required: true, maxlength: 225 },
                register_email: { required: true, email: true },
                register_mobile_number: { required: true, minlength: 10, maxlength: 10 },
                register_password: { required: true, minlength: 5 }
            },
            messages: {
                register_mobile_number: { minlength: 'Enter valid 10-digit mobile number', maxlength: 'Enter valid 10-digit mobile number' },
                register_email: { required: 'Email is required', email: 'Enter a valid email address' },
                register_full_name: { required: 'Full Name is required' },
                register_password: { required: 'Password is required' }
            },
            errorElement: 'div',
            highlight: function(element, errorClass) {
                $(element).css({ border: '1px solid #f00' });
            },
            unhighlight: function(element, errorClass) {
                $(element).css({ border: '1px solid #c1c1c1' });
            },
            submitHandler: function(form, event) {
                event.preventDefault(); // Prevent form submission until API check
    
                var mobile_number = $('#register_mobile_number').val();
                var email = $('#register_email').val();
                var referral_code = $('#register_referral_code').val();
                var full_name = $('#register_full_name').val();
                var password = $('#register_password').val();
    
                $("#register_continue_btn").attr('disabled', 'disabled').text('Generating OTP...');
    
                // Send request to verify user data and send OTP
                $.ajax({
                    url: "{{route('verify-details')}}",
                    type: 'POST',
                    data: {
                        mobile: mobile_number,
                        email: email,
                        referral_code: referral_code,
                        ccode: '+91',
                        full_name:full_name,
                        password:password,
                        _token: "{{ csrf_token() }}"  // CSRF token for security
                    },
                    success: function(response) {
                        if (response.status === 'error') {
                            // alert(response.message); // Show error message
                            iziToast.error({
                                title: 'Error',
                                position: 'topRight',
                                message: response.message,
                            });
                            $("#register_continue_btn").removeAttr('disabled').text('Continue');
                        } else if (response.status === 'success') {
                            iziToast.success({
                                title: 'Success',
                                position: 'topRight',
                                message: "OTP sent successfully!",
                            });
                            $("#register_continue_btn").text('Generating OTP...');
                            // Hide registration form and show OTP form
                            $("#register_register_frm").hide();
                            $("#register_otp_frm").show();
                        }
                    },
                    error: function(xhr, status, error) {
                        iziToast.error({
                            title: 'Error',
                            position: 'topRight',
                            message: 'There was an error while processing your request. Please try again. : '.error,
                        });
                        $("#register_continue_btn").removeAttr('disabled').text('Continue');
                    }
                });
            }
        });
    
        // Function to verify the OTP
        function verify() {
            var otp = $('#register_otp_password').val();
            var mobile_number = $('#register_mobile_number').val();
    
            if (!otp || otp.length !== 4) {
                iziToast.error({
                    title: 'Error',
                    position: 'topRight',
                    message: 'Please enter a valid 4-digit OTP.'
                });
                return;
            }
    
            $("#register_verify_btn").attr('disabled', 'disabled').text('Verifying...');
    
            $.ajax({
                url: "{{route('verify-otp')}}", // Update this to your OTP verification endpoint
                type: 'POST',
                data: {
                    otp: otp,
                    mobile: mobile_number,
                    _token: "{{ csrf_token() }}" // CSRF token for security
                },
                success: function(response) {
                    if (response.status === 'error') {
                        // alert(response.message); // Show error message
                        iziToast.error({
                            title: 'Error',
                            position: 'topRight',
                            message: response.message
                        });
                        $("#register_verify_btn").removeAttr('disabled').text('Continue');
                    } else if (response.status === 'success') {
                        // alert(response.message);
                        iziToast.success({
                            title: 'Success',
                            position: 'topRight',
                            message: response.message
                        });
                        // Redirect to the login page after 1 second
                        setTimeout(function() {
                            window.location.href = "{{ route('userLogin') }}";
                        }, 1000);
                    }
                },
                error: function(xhr, status, error) {
                    iziToast.error({
                        title: 'Error',
                        position: 'topRight',
                        message: "There was an error while verifying OTP. Please try again."
                    });
                    $("#register_verify_btn").removeAttr('disabled').text('Continue');
                }
            });
        }
    </script>
    <script>
        $(document).ready(function () {
            $("form").on("keypress", function (e) {
                if (e.which === 13) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endpush