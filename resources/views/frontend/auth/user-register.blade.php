@extends('frontend.master', ['activePage' => 'register'])
@section('title', __('Register'))
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css" integrity="sha512-DIW4FkYTOxjCqRt7oS9BFO+nVOwDL4bzukDyDtMO7crjUZhwpyrWBFroq+IqRe6VnJkTpRAS6nhDvf0w+wHmxg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<section class="section-area login-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card o-hidden  shadow-sm border-0  ">
                    <div class="card-body p-0">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                            @include('messages')
                            @if(!Session::has('success'))
                                <div class="p-lg-5 p-3">
                                    <div class="text-center">
                                    </div>
                                    <div class="text-center">
                                        <h1 class="h3 mb-4">Create An Account</h1>
                                        <p class="ot_err text-danger text-left"></p>
                                    </div>
                                    <form class="user" method="post" name="register_frm" id="register_frm"> 
                                        @csrf
                                        <div class="form-group">
                                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" name="full_name" class="form-control form-control-user" value="{{old('full_name')}}" id="full_name" placeholder="Enter Name">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control form-control-user" value="{{old('email')}}" name="email" id="email" placeholder="Enter Email Adress">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Mobile Number <span class="text-danger">*</span> <span style="font-size:10px;" class="text-muted">10 digit mobile number</span></label>
                                            <input type="number" class="form-control form-control-user" value="{{old('mobile_number')}}" id="mobile_number" name="mobile_number" placeholder="Enter Mobile number">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control form-control-user" id="password" autocomplete="new-password" name="password" placeholder="Password">
                                        </div>
                                        {{-- <div class="form-group">
                                            <label class="form-label">Referral Code (Optional)</label>
                                            <input type="text" class="form-control form-control-user" value="{{old('referral_code')}}" name="referral_code" id="referral_code" placeholder="Enter Referral Code">
                                        </div> --}}
                                        <div class="form-group">
                                            <div id="recaptcha-container" class="mb-3"></div>
                                        </div>
                                        <button type="submit" id="continue_btn" class="btn default-btn btn-user btn-block">
                                            Register
                                        </button>
                                    </form>
                                    <div class="mt-4" id="otp_frm" style="display: none;">
                                        <p>Enter OTP sent to your mobile number</p>
                                        <div class="form-group">
                                            <label class="form-label">OTP (One Time Password) <span class="text-danger">*</span></label>
                                            <input type="text" min="4" max="4" class="form-control form-control-user" id="otp_password" placeholder="OTP" required>
                                        </div>
                                        <button type="button" onclick="verify()" id="verify_btn" class="btn default-btn btn-user btn-block">
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
{{-- <script> 
    $("#register_frm").validate({
        rules: {
            first_name:{required:true,maxlength:225},
            referral_code:{maxlength:225},
            email:{required:true,email:true},
            password:{required:true,minlength:5},
        },
        messages: {
            mobile_number:{minlength:'Enter valid 10 digit mobile number', maxlength:'Enter valid 10 digit mobile number'}
        },
        errorElement: 'div',
        highlight: function(element, errorClass) {
            $(element).css({ border: '1px solid #f00' });
        },
        unhighlight: function(element, errorClass) {
            $(element).css({ border: '1px solid #c1c1c1' });
        },
        submitHandler: function(form,event) {
            event.preventDefault();
            $("#continue_btn").attr('disabled','disabled').text('Generating OTP...');
            sendOtpToMobile();
        }
    });
</script> --}}

{{-- <script>
    // Your validation rules and messages
    $("#register_frm").validate({
        rules: {
            full_name: { required: true, maxlength: 225 },
            email: { required: true, email: true },
            mobile_number: { required: true, minlength: 10, maxlength: 10 },
            password: { required: true, minlength: 5 }
        },
        messages: {
            mobile_number: { minlength: 'Enter valid 10 digit mobile number', maxlength: 'Enter valid 10 digit mobile number' },
            email: { required: 'Email is required', email: 'Enter a valid email address' },
            full_name: { required: 'Full Name is required' },
            password: { required: 'Password is required' }
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

            // Get the mobile number and email values from the form
            var mobile_number = $('#mobile_number').val();
            var email = $('#email').val();
            var referral_code = $('#referral_code').val();

            // Check mobile and email via AJAX
            $.ajax({
                url: "{{route('verify-details')}}", 
                type: 'POST',
                data: {
                    mobile: mobile_number,
                    email: email,
                    referral_code: referral_code,
                    ccode: '+91',
                    _token: "{{ csrf_token() }}"  // Pass CSRF token directly
                },
                success: function(response) {
                    if (response.status === 'error') {
                        // Show the error message from the server response
                        alert(response.message);
                        // Re-enable the button if needed
                        $("#continue_btn").removeAttr('disabled').text('Continue');
                    } else if (response.status === 'success') {
                        // If no issue, proceed with form submission
                        $("#continue_btn").attr('disabled', 'disabled').text('Generating OTP...');
                        // You can trigger OTP sending or any further logic here
                        // sendOtpToMobile();
                    }
                },
                error: function(xhr, status, error) {
                    // Handle generic AJAX error
                    alert('There was an error while checking. Please try again.');
                    $("#continue_btn").removeAttr('disabled').text('Continue');
                }
            });
        }
    });
</script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    // Validation and submission handler
    $("#register_frm").validate({
        rules: {
            full_name: { required: true, maxlength: 225 },
            email: { required: true, email: true },
            mobile_number: { required: true, minlength: 10, maxlength: 10 },
            password: { required: true, minlength: 5 }
        },
        messages: {
            mobile_number: { minlength: 'Enter valid 10-digit mobile number', maxlength: 'Enter valid 10-digit mobile number' },
            email: { required: 'Email is required', email: 'Enter a valid email address' },
            full_name: { required: 'Full Name is required' },
            password: { required: 'Password is required' }
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

            var mobile_number = $('#mobile_number').val();
            var email = $('#email').val();
            var referral_code = $('#referral_code').val();
            var full_name = $('#full_name').val();
            var password = $('#password').val();

            $("#continue_btn").attr('disabled', 'disabled').text('Generating OTP...');

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
                        $("#continue_btn").removeAttr('disabled').text('Continue');
                    } else if (response.status === 'success') {
                        iziToast.success({
                            title: 'Success',
                            position: 'topRight',
                            message: "OTP sent successfully!",
                        });
                        $("#continue_btn").text('Generating OTP...');
                        // Hide registration form and show OTP form
                        $("#register_frm").hide();
                        $("#otp_frm").show();
                    }
                },
                error: function(xhr, status, error) {
                    iziToast.error({
                        title: 'Error',
                        position: 'topRight',
                        message: 'There was an error while processing your request. Please try again. : '.error,
                    });
                    $("#continue_btn").removeAttr('disabled').text('Continue');
                }
            });
        }
    });

    // Function to verify the OTP
    function verify() {
        var otp = $('#otp_password').val();
        var mobile_number = $('#mobile_number').val();

        if (!otp || otp.length !== 4) {
            iziToast.error({
                title: 'Error',
                position: 'topRight',
                message: 'Please enter a valid 4-digit OTP.'
            });
            return;
        }

        $("#verify_btn").attr('disabled', 'disabled').text('Verifying...');

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
                    $("#verify_btn").removeAttr('disabled').text('Continue');
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
                $("#verify_btn").removeAttr('disabled').text('Continue');
            }
        });
    }
</script>
@endpush