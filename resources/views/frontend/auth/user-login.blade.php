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

    .form-control[readonly] {
        background:none !important;
    }
.login-modal-content {
    background-color:#000;
    box-shadow: rgba(0, 0, 0, 0.22) 0px 13px 24px 0px;
    border-radius: 10px;
    animation: animation-ngigez 0.3s ease 0s 1 normal none;
    width: 80%;
    border: 1px solid rgba(255, 255, 255, 0.6);
    padding:25px;
}

.login-modal-content .input-group-text{
    background-color:#000000 !important;
    color:#fff !important;
}

.login-modal-content .form-control{
    border-radius: .25rem;
    font-size: 15px;
    color: #ffffff;
    height: 45px;
    background-color: #000000;
    border: 1px solid #ffffff;
}
.login-modal-content .btn-primary:hover{
    color: rgb(255, 255, 255) !important;
    background-color: rgb(110, 110, 110) !important;
    border-color: rgb(110, 110, 110) !important;
}

@keyframes animation-ngigez {
    0% {
        opacity: 0;
        transform: translate3d(0px, -10%, 0px);
    }
    100% {
        opacity: 1;
        transform: translate3d(0px, 0px, 0px);
    }
}
</style>
@php
    $favicon = Common::siteGeneralSettingsApi();
@endphp
<section class="section-area login-section">
    <!-- <div class="container">
        <div class="row justify-content-center">
            <div class="imageHidden col-lg-6 p-0 d-flex align-items-stretch">
                <img src="{{asset('/images/fit-login.png')}}" width="100%" alt="">
            </div>
            <div class="col-lg-6 p-0 d-flex align-items-stretch">
                <div class="card o-hidden shadow-sm border-0 w-100">
                   <div class="card-body p-0">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-12 d-flex justify-content-center align-items-center h-100">
                            <div class="p-lg-5 p-3 w-100">
                                <div class="text-center">
                                    <h1 class="h3 mb-4">Login to Fitsportsy</h1>
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
    </div> -->

    <button class="btn btn-outline-primary" data-toggle="modal" data-target="#loginOtpModal">Login</button>

    <!-- Login Modal -->
    <div class="modal fade" id="loginOtpModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered justify-content-center" role="document">
            <div class="modal-content login-modal-content shadow">
            <div class="modal-header border-0 p-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="loginOtpForm">
                        @csrf
                       <div class="text-center mb-4">
                           <a href="/"><img src="{{ $favicon['favicon'] ? env('BACKEND_BASE_URL') . "/" . $favicon['logo'] : "https://app.fitsportsy.in/images/website/1733339125.png" }}"
                                   class="img-fluid" style="width:200px;" alt="fitsportsy"></a>
                       </div>
                        
                        <div id="mobileInputSection">
                            <div class="form-group">
                                <label class="mb-1">Mobile Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">+91</span>
                                    </div>
                                    <input type="tel" maxlength="10" class="form-control" id="loginMobileInput" name="number" placeholder="Enter your mobile number" required>
                                </div>
                                <small class="form-text text-muted">We'll send an OTP to this number</small>
                            </div>
                            
                            <button type="button" id="sendOtpBtn" class="btn btn-primary btn-block mt-3">
                                Continue
                            </button>
                        </div>
                        
                        <div id="otpInputSection" class="d-none">
                            <div class="text-center mb-3">
                                <p>Enter the 4-digit OTP sent to <span id="displayMobileNumber" class="font-weight-bold">+91 XXXXXXXXXX</span></p>
                            </div>
                            
                            <div class="form-group">
                                <div class="d-flex justify-content-between otp-input-group">
                                    <input type="text" class="form-control otp-box" maxlength="1" pattern="\d*" inputmode="numeric" />
                                    <input type="text" class="form-control otp-box" maxlength="1" pattern="\d*" inputmode="numeric" />
                                    <input type="text" class="form-control otp-box" maxlength="1" pattern="\d*" inputmode="numeric" />
                                    <input type="text" class="form-control otp-box" maxlength="1" pattern="\d*" inputmode="numeric" />
                                </div>
                                <input type="hidden" id="combinedOtp" name="otp">
                            </div>
                            
                            <button type="button" id="verifyOtpBtn" class="btn btn-primary btn-block mt-2">
                                Verify OTP
                            </button>
                            
                            <div class="resend-otp mt-3">
                                Didn't receive OTP? <a id="resendOtpBtn">Resend OTP</a>
                            </div>
                        </div>
                        
                        <div class="footer-links text-right mt-2">
                            <a href="{{url('user-register')}}" class="text-muted">Create Account</a> | 
                            <a href="{{url('user/resetPassword')}}" class="text-muted">Forgot Password?</a>
                        </div>
                    </form>
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
        // Initialize modal
        $('#loginOtpModal').modal('show');
        
        // Handle OTP input boxes
        $('.otp-box').on('input', function() {
            $(this).next('.otp-box').focus();
            updateCombinedOtp();
        });
        
        // Handle backspace in OTP boxes
        $('.otp-box').on('keydown', function(e) {
            if(e.key === "Backspace" && $(this).val() === '') {
                $(this).prev('.otp-box').focus();
            }
            updateCombinedOtp();
        });
        
        function updateCombinedOtp() {
            let otp = '';
            $('.otp-box').each(function() {
                otp += $(this).val();
            });
            $('#combinedOtp').val(otp);
        }
        
        // Send OTP
        $('#sendOtpBtn').on('click', function() {
            const mobile = $('#loginMobileInput').val();
            const ccode = "+91";
            
            if (!mobile || mobile.length !== 10 || isNaN(mobile)) {
                iziToast.error({
                    title: 'Error',
                    position: 'topRight',
                    message: 'Please enter a valid 10-digit mobile number.'
                });
                return;
            }
            
            // Show loading state
            $(this).addClass('btn-loading').prop('disabled', true).html('Sending OTP...');
            
            $.ajax({
                url: "{{ route('verify-mobile-number') }}",
                type: 'POST',
                data: {
                    mobile: mobile,
                    ccode: ccode,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#sendOtpBtn').removeClass('btn-loading').prop('disabled', false).html('Continue');
                    
                    if (response.status === 'success') {
                        // Show OTP section
                        $('#mobileInputSection').addClass('d-none');
                        $('#otpInputSection').removeClass('d-none').addClass('otp-section-animate');
                        $('#displayMobileNumber').text('+91 ' + mobile);
                        
                        // Focus first OTP box
                        $('.otp-box').first().focus();
                        
                        iziToast.success({
                            title: 'Success',
                            position: 'topRight',
                            message: 'OTP sent successfully!'
                        });
                    } else {
                        iziToast.error({
                            title: 'Error',
                            position: 'topRight',
                            message: response.message
                        });
                    }
                },
                error: function() {
                    $('#sendOtpBtn').removeClass('btn-loading').prop('disabled', false).html('Continue');
                    iziToast.error({
                        title: 'Error',
                        position: 'topRight',
                        message: 'Failed to send OTP. Please try again.'
                    });
                }
            });
        });
        
        // Verify OTP
        $('#verifyOtpBtn').on('click', function() {
            const otp = $('#combinedOtp').val();
            
            if (!otp || otp.length !== 4 || isNaN(otp)) {
                iziToast.error({
                    title: 'Error',
                    position: 'topRight',
                    message: 'Please enter a valid 4-digit OTP.'
                });
                return;
            }
            
            // Show loading state
            $(this).addClass('btn-loading').prop('disabled', true).html('Verifying...');
            
            $.ajax({
                url: "{{ route('verify-login-otp') }}",
                type: 'POST',
                data: {
                    otp: otp,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#verifyOtpBtn').removeClass('btn-loading').prop('disabled', false).html('Verify OTP');
                    
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
                error: function() {
                    $('#verifyOtpBtn').removeClass('btn-loading').prop('disabled', false).html('Verify OTP');
                    iziToast.error({
                        title: 'Error',
                        position: 'topRight',
                        message: 'Failed to verify OTP. Please try again.'
                    });
                }
            });
        });
        
        // Resend OTP
        $('#resendOtpBtn').on('click', function() {
            const mobile = $('#loginMobileInput').val();
            const ccode = "+91";
            
            // Show loading state
            $(this).html('Sending...');
            
            $.ajax({
                url: "{{ route('verify-mobile-number') }}",
                type: 'POST',
                data: {
                    mobile: mobile,
                    ccode: ccode,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#resendOtpBtn').html('Resend OTP');
                    
                    if (response.status === 'success') {
                        iziToast.success({
                            title: 'Success',
                            position: 'topRight',
                            message: 'New OTP sent successfully!'
                        });
                    } else {
                        iziToast.error({
                            title: 'Error',
                            position: 'topRight',
                            message: response.message
                        });
                    }
                },
                error: function() {
                    $('#resendOtpBtn').html('Resend OTP');
                    iziToast.error({
                        title: 'Error',
                        position: 'topRight',
                        message: 'Failed to resend OTP. Please try again.'
                    });
                }
            });
        });
    });
</script>
@endpush