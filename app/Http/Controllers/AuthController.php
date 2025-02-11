<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AppUser;
use App\Models\CoachingPackageBooking;
use App\Models\Order;
use Session;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Common;

class AuthController extends Controller
{
    public function userLogin(Request $request){
        if(Common::isUserLogin()){
            return redirect('/');
        }
        $redirectUrl = session('redirect_url', '/'); ;
        return view('frontend.auth.user-login',compact('redirectUrl'));
    }

    public function organizerLogin(){
        if(\Auth::check()==true){
            return redirect('/dashboard');
        }
        return view('frontend.auth.organizer-login');
    }

    public function userRegister(){
        if(Common::isUserLogin()){
            return redirect('/');
        }
        return view('frontend.auth.user-register');
    }

    public function verifyUserData(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'mobile' => 'required|max:255',
            'email' => 'required|email|max:255',
            'ccode' => 'required|max:255',
            'referral_code' => 'nullable|max:255',
            'full_name' => 'required|max:255',
            'password' => 'required|max:255',
        ]);
        
        try {    
            // Get the input data
            $mobile = $request->mobile;
            $email = $request->email;
            $ccode = $request->ccode;
            $referral_code = $request->referral_code;
    
            // Instantiate the Guzzle client
            $client = new Client();
    
            // Prepare the data to send in the request body
            $data = [
                'mobile' => $mobile,
                'ccode' => $ccode,
                'email' => $email,
                'referral_code' => $referral_code,
            ];
    
            // Send POST request to the PHP admin panel API
            $baseUrl = env('BACKEND_BASE_URL'); // Make sure this is set in your .env file
            $response = $client->post("{$baseUrl}/web_api/valid_user_detail.php", [
                'json' => $data,  // Use the 'json' option to send data as JSON in the request body
            ]);
    
            // Decode the JSON response from the PHP API
            $responseData = json_decode($response->getBody(), true);
    
            // Check the response and handle accordingly
            if ($responseData['ResponseCode'] === '200') {

                // Call sendOTP function to send OTP
                $is_otpSend = $this->sendOTP($mobile);
                if ($is_otpSend) {

                    $userData = [
                        'mobile' => $request->mobile,
                        'email' => $request->email,
                        'ccode' => $request->ccode,
                        'referral_code' => $request->referral_code ?? null,
                        'name' => $request->full_name,
                        'password' => $request->password, // Hash the password for security
                    ];
                
                    // Save the data in session
                    session(['user_data' => $userData]);

                    // Success - New Number, OTP sent
                    return response()->json([
                        'status' => 'success',
                        'message' => $responseData['ResponseMsg']
                    ]);
                }
                
                // If OTP is not sent successfully, return error message
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to send OTP. Please try again later.'
                ], 500);

            } else {
                // Error - Mobile or Email already used
                return response()->json([
                    'status' => 'error',
                    'message' => $responseData['ResponseMsg'], // Error message from the PHP API
                ]);
            }
        } catch (\Throwable $th) {
            // Log the error for debugging purposes
            Log::error('Error verifying user data: ' . $th->getMessage());
    
            // Return a generic error message
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong! Please try again later. '.$th->getMessage(),
            ]);
        }
    }

    public function verifyMobileNumber(Request $request)
    {
        try {
            $request->validate([
                'mobile' => 'required|max:255',
                'ccode' => 'required|max:255',
            ]);

            // Get the input data
            $mobile = $request->mobile;
            $ccode = $request->ccode;

            // Instantiate the Guzzle client
            $client = new Client();

            // Prepare the data to send in the request body
            $data = [
                'number' => $mobile,
                'ccode' => $ccode,
            ];

            // Send POST request to the PHP admin panel API
            $baseUrl = env('BACKEND_BASE_URL'); // Ensure this is set in your .env file
            $response = $client->post("{$baseUrl}/web_api/verify-mobile.php", [
                'json' => $data,  // Use the 'json' option to send data as JSON in the request body
            ]);

            // Decode the JSON response from the PHP API
            $responseData = json_decode($response->getBody(), true);

            // Check the response and handle accordingly
            if ($responseData['ResponseCode'] === '200') {
                // Call sendOTP function to send OTP
                $isOtpSent = $this->sendOTP($mobile);
                if ($isOtpSent) {
                    \Session::put("user_temp_session",$responseData['user_info']);
                    // Store mobile number and country code in session
                    session(['user_mobile' => [
                        'mobile' => $request->mobile,
                        'ccode' => $request->ccode,
                    ]]);

                    // Success - New Number, OTP sent
                    return response()->json([
                        'status' => 'success',
                        'message' => "OTP Sent Successfully!"
                    ]);
                }

                // If OTP is not sent successfully, return error message
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to send OTP. Please try again later.'
                ], 500);

            } else {
                // Error - Mobile or Email already used
                return response()->json([
                    'status' => 'error',
                    'message' => $responseData['ResponseMsg'], // Error message from the PHP API
                ]);
            }
        } catch (\Throwable $th) {
            // Log the error for debugging purposes
            Log::error('Error verifying user data: ' . $th->getMessage());

            // Return a generic error message
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong! Please try again later. '.$th->getMessage(),
            ]);
        }
    }

    
    // public function verifyMobileNumber(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'mobile' => 'required|max:255',
    //             'ccode' => 'required|max:255',
    //         ]);

    //         $mobile = $request->mobile;
    //         $ccode = $request->ccode;
    //         $client = new Client();
    //         $baseUrl = env('BACKEND_BASE_URL');
    //         $response = $client->post("{$baseUrl}/web_api/verify-mobile.php", [
    //             'json' => ['number' => $mobile, 'ccode' => $ccode]
    //         ]);

    //         $responseData = json_decode($response->getBody(), true);

    //         if ($responseData['ResponseCode'] === '200') {
    //             return response()->json([
    //                 'status' => 'success',
    //                 'message' => "OTP Sent Successfully!"
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => "Invalid Number"
    //             ]);
    //         }
    //     } catch (\Throwable $th) {
    //         Log::error('Error verifying mobile: ' . $th->getMessage());
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Something went wrong! Try again later.'
    //         ]);
    //     }
    // }
    
    public function sendOTP($mobile)
    {
        try {
    
            // Instantiate the Guzzle client
            $client = new Client();
        
            // Prepare the data to send in the request body
            $data = [
                'mobile' => $mobile,
            ];
    
            // Send POST request to the PHP admin panel API
            $baseUrl = env('BACKEND_BASE_URL'); // Make sure this is set in your .env file
            $response = $client->post("{$baseUrl}/web_api/msg_otp.php", [
                'json' => $data,  // Use the 'json' option to send data as JSON in the request body
            ]);
        
            // Decode the JSON response from the PHP API
            $responseData = json_decode($response->getBody(), true);
        
            // Check if OTP was sent successfully
            if (isset($responseData['ResponseCode']) && $responseData['ResponseCode'] === '200') {
                // OTP was sent successfully, get the OTP from the response
                $otp = $responseData['otp'];
    
                // Store the OTP in the session
                Session::put('otp', $otp);
                
                // Return true if OTP sent successfully
                return true;
            } else {
                // Return false if OTP wasn't sent
                return false;
            }
        } catch (\Throwable $th) {
            // Log the error for debugging purposes
            Log::error('Error sending OTP: ' . $th->getMessage());
        
            // Return false if an error occurs while sending OTP
            return false;
        }
    }

    public function verifyLoginOTP(Request $request)
    {
        try {
            // Validate the incoming request to make sure OTP is provided
            $request->validate([
                'otp' => 'required|numeric|digits:4',  // Ensure the OTP is a 4-digit number
            ]);
            
            // Get the OTP entered by the user
            $enteredOtp = $request->input('otp');

            // Retrieve the OTP stored in the session
            $storedOtp = Session::get('otp');

            // Check if the OTP is valid and matches
            if ($enteredOtp == $storedOtp) {
                // Retrieve the temporary user session data
                $userData = Session::get('user_temp_session');
                // Check if user data exists in the session
                if (!$userData) {
                    // If no temporary session data exists, return an error
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Session time out. Please try again.',
                    ], 400);
                }else{
                    // Now, store the user login session if needed (e.g., for session persistence)
                    session(['user_login_session' => $userData]); // This can be adjusted based on your needs
                    Session::forget('user_temp_session');
                    Session::forget('user_mobile');
                    // Return success response
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Logged in successfully!',
                    ]);
                }

                // Handle failed registration or login
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to log in user. Please try again later.',
                ], 500);
            } else {
                // OTP is incorrect
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid OTP. Please try again.',
                ], 400);  // 400 is for client errors
            }
        } catch (\Throwable $th) {
            // Log the error for debugging purposes
            Log::error('Error verifying OTP: ' . $th->getMessage());

            // Return a generic error message
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. Please try again later.',
            ], 500);  // 500 is for server errors
        }
    }

    public function makeUserLogin($mobile,$ccode){
        try {
    
            // Instantiate the Guzzle client
            $client = new Client();
        
            // Prepare the data to send in the request body
            $data = [
                'number' => $mobile,
                'ccode'=> $ccode
            ];
    
            // Send POST request to the PHP admin panel API
            $baseUrl = env('BACKEND_BASE_URL'); // Make sure this is set in your .env file
            $response = $client->post("{$baseUrl}/web_api/user_data.php", [
                'json' => $data,  // Use the 'json' option to send data as JSON in the request body
            ]);
        
            // Decode the JSON response from the PHP API
            $responseData = json_decode($response->getBody(), true);
        
            // Check if OTP was sent successfully
            if (isset($responseData['ResponseCode']) && $responseData['ResponseCode'] === '200') {
                // OTP was sent successfully, get the OTP from the response
                $user_info = $responseData['user_info'];
                // Store the OTP in the session
                Session::put('user_info', $user_info);
                
                // Return true if OTP sent successfully
                return true;
            } else {
                // Return false if OTP wasn't sent
                return false;
            }
        } catch (\Throwable $th) {
            // Log the error for debugging purposes
            Log::error('Error sending OTP: ' . $th->getMessage());
        
            // Return false if an error occurs while sending OTP
            return false;
        }
    }

    public function verifyOTP(Request $request)
    {
        try {
            // Validate the incoming request to make sure OTP is provided
            $request->validate([
                'otp' => 'required|numeric|digits:4',  // Ensure the OTP is a 4-digit number
            ]);
            
            // Get the OTP entered by the user
            $enteredOtp = $request->input('otp');

            // Retrieve the OTP stored in the session
            $storedOtp = Session::get('otp');

            // Check if the OTP is valid and matches
            if ($enteredOtp == $storedOtp) {
                // HIT THE REGISTER USE API TO STORE DATA IN DB
                $isUserRegistered = $this->storeRegisterUserDetails();
                if ($isUserRegistered) {
                    Session::forget('user_data');
                    Session::forget('otp');
                    
                    // Return success response
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Sign Up Done Successfully!',
                    ]);
                }
                // Handle failed registration
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to register user. Please try again later.',
                ], 500);
            } else {
                // OTP is incorrect
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid OTP. Please try again.',
                ], 400);  // 400 is for client errors
            }
        } catch (\Throwable $th) {
            // Log the error for debugging purposes
            Log::error('Error verifying OTP: ' . $th->getMessage());

            // Return a generic error message
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. Please try again later.',
            ], 500);  // 500 is for server errors
        }
    }

    private function storeRegisterUserDetails()
    {
        // Retrieve stored user data from the session
        $storedOtp = \Session::get('user_data');
    
        if (!$storedOtp) {
            throw new \Exception("No user data found in session.");
        }
    
        // Instantiate the Guzzle client
        $client = new Client();
    
        // Prepare the data to send in the request body
        $data = [
            'mobile' => $storedOtp['mobile'],
            'ccode' => $storedOtp['ccode'],
            'email' => $storedOtp['email'],
            'referral_code' => $storedOtp['referral_code'],
            'name' => $storedOtp['name'],
            'password' => $storedOtp['password'],
        ];
    
        // Set the base URL from the environment variable
        $baseUrl = env('BACKEND_BASE_URL'); // Ensure this is set in your .env file
    
        try {
            // Send POST request to the PHP admin panel API
            $response = $client->post("{$baseUrl}/web_api/user_register.php", [
                'json' => $data,  // Send the data as JSON
            ]);
    
            // Decode the JSON response from the PHP API
            $responseData = json_decode($response->getBody(), true);
    
            // Check if the response indicates success
            if (isset($responseData['ResponseCode']) && $responseData['ResponseCode'] == "200") {
                // $userData = Session::put();
                session(['user_login_session' => $responseData['UserLogin']]);
                return true;
            }
    
            // If the API indicates an error, return false
            return false;
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error("Error registering user: " . $e->getMessage());
            // Rethrow the exception or handle it as needed
            return false;
        }
    }


    public function postUserRegister(Request $request){
        $request->validate([
            'full_name'=>'required|max:225',
            'email'=>'required|email',
            'mobile_number'=>'required|numeric',
            'password'=>'required|min:5',
            'referral_code'=>'nullable|max:225',
        ]);

        dd($request->all());

        $data = $request->all();
        $data['name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['password'] = \Hash::make($request->password);
        $data['address'] = $request->address_one;
        $data['address_two'] = $request->address_two;
        $data['image'] = "defaultuser.png";
        $data['status'] = 1;
        $data['provider'] = "LOCAL";
        $data['language'] = 'English';
        $data['phone'] = $request->mobile_number;
        $data['is_verify'] = 1;
        $data['logintype'] = $request->logintype;
        if ($data['logintype'] == 2) {
            $checkEmail = User::where('email',$request->email)->count();
            if($checkEmail){
                return redirect()->back()->with('warning','Email already exist or registered with us..Please login to continue');
            }
            $user = User::create($data);
            $user->assignRole('Organizer');
            return redirect()->back()->with('success','Congratulations! Your account registration was successful. You can log in to your account')->withInput($request->input());
        } else {
            $checkEmail = AppUser::where('email',$request->email)->count();
            if($checkEmail){
                return redirect()->back()->with('warning','Email already exist or registered with us..Please login to continue')->withInput($request->input());
            }
            $user = AppUser::create($data);
            \Auth::guard('appuser')->login($user);
            return redirect('/');
        }
    }

    // public function checkUserLogin(Request $request){
    //     $request->validate([
    //         'email' => 'bail|required|email',
    //         'password' => 'bail|required',
    //     ]);

    //     $userdata = array(
    //         'email' => $request->email,
    //         'password' => $request->password,
    //         'status'=>1
    //     );
    //     $remember = $request->get('remember_me');
    //     if ($request->logintype == '1') {
    //         if (\Auth::guard('appuser')->attempt($userdata, $remember)) {
    //             if(Session::has('LAST_URL_VISITED')){
    //                 $redirectLink = Session::get('LAST_URL_VISITED');
    //                 return redirect($redirectLink);
    //             }
    //             return redirect('/');
    //         } else {
    //             return \Redirect::back()->with('warning', 'Invalid Username or Password.');
    //         }
    //     }else{
    //         if (\Auth::attempt($userdata, $remember)) {
    //             return redirect('/dashboard');
    //         } else {
    //             return \Redirect::back()->with('warning', 'Invalid Username or Password.');
    //         }
    //     }
    // }

    public function checkUserLogin(Request $request){
        $request->validate([
            'phonenumber' => 'bail|required|number',
            'password' => 'bail|required',
        ]);
    }

    public function checkOrganizerLogin(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required',
        ]);
    
        $email = $request->email;
        $password = $request->password;
    
        $makeOrganiserLogin = $this->makeOrganizerLogin($email, $password);
    
        if ($makeOrganiserLogin['Result'] == 'true') {    
            return redirect()->to('https://app.playoffz.in/'); 
        }
    
        return redirect()->back()->with('warning', $makeOrganiserLogin['ResponseMsg']);
    }
    
    private function makeOrganizerLogin($email, $password)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $baseUrl = env('BACKEND_BASE_URL'); // Example: https://api.your-backend.com
    
            // Make a POST request to the backend API
            $response = $client->post("{$baseUrl}/web_api/organiser-login.php", [
                'json' => [
                    'email' => $email,
                    'password' => $password,
                    'type' => 'Orgnizer' // Add 'type' if required by your backend
                ]
            ]);
    
            $data = json_decode($response->getBody(), true);
    
            return $data; // Pass the entire response back
        } catch (\Throwable $th) {
            // Log the error for debugging
            \Log::error("Organizer Login Error: " . $th->getMessage());
    
            return [
                "ResponseCode" => "500",
                "Result" => "false",
                "ResponseMsg" => "Unable to connect to the backend server."
            ];
        }
    }

    public function logoutUser(){
        Session::forget('user_login_session');
        // \Auth::guard('appuser')->logout();
        // \Auth::logout();
        return redirect('/');
    }

    public function myTickets(){
        $userId = \Auth::guard('appuser')->user()->id;
        $ticketData = CoachingPackageBooking::whereHas('coachingPackage')->with(['coachingPackage' => function($query){
            $query->whereHas('coaching')->with('coaching');
        }])->where(['user_id' => $userId, 'is_active' => CoachingPackageBooking::STATUS_ACTIVE])->paginate(50);
        
        return view("frontend.auth.my-tickets",compact('ticketData'));
    }

    public function myProfile(){
        return view("frontend.auth.my-profile");
    }

    public function updateProfile(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'image' => 'nullable|mimes:jpg,jpeg,png,webp', // Make the image optional
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
            'email' => 'nullable|email',
            'confirm_password' => 'nullable|same:password', // Confirm password only if provided
        ]);

        $user = Common::userId();
        
        // Prepare data for the API
        $data = [
            'name' => $request->username,
            'uid' => $user,
            'email' => $request->email,
            'img' => $request->hasFile('image') ? base64_encode(file_get_contents($request->file('image')->path())) : null,
        ];

        // Include the password in the payload only if it is provided
        if (!empty($request->password)) {
            $data['password'] = $request->password;
        }

        // Call the API and update the profile
        $isUpdated = $this->updateProfileApi($data);

        // Redirect based on the API response
        if ($isUpdated) {
            $cacheKey = "user_profile_{$user}";
            if (Cache::has($cacheKey)) {
                Cache::forget($cacheKey);
            }
            return redirect()->back()->with('success', 'Profile updated successfully.');
        }

        return redirect()->back()->with('error', 'Something went wrong. Please try again.');
    }

    private function updateProfileApi(array $data)
    {
        try {
            // Instantiate the Guzzle client
            $client = new Client();

            // Get the base URL from the environment file
            $baseUrl = env('BACKEND_BASE_URL');

            // Send a POST request to the API endpoint
            $response = $client->post("{$baseUrl}/web_api/update_profile.php", [
                'json' => $data, // Send data as JSON
            ]);

            // Decode the JSON response
            $responseData = json_decode($response->getBody(), true);

            // Check the result in the response
            if (!empty($responseData['Result']) && ($responseData['Result'] === true || $responseData['Result'] === "true")) {
                return true;
            }

            return false;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function accountSettings(){
        return view("frontend.auth.account-settings");
    }

    public function updateUserPassword(Request $request){
        $request->validate([
            'password'=>'required',
            'confirm_password'=>'required',
        ]);
        $userId = \Auth::guard('appuser')->user()->id;
        AppUser::where('id',$userId)->update(['password'=>\Hash::make($request->password)]);
        return redirect()->back()->with('success','Password updated successfully!!');
    }

    public function organizerRegsiter(){
        if(\Auth::check()==true){
            return redirect('/');
        }
        return view('frontend.auth.organizer-register');
    }

    public function postOrganizerRegister(Request $request){
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'max:255',
            'email'=>'required|email',
            'mobile_number'=>'required|numeric',
            'password'=>'required|min:5',
            // 'address_one'=>'required'
        ]);

        // dd($request->all());
        $data = $request->all();
        $data['name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['password'] = \Hash::make($request->password);
        $data['address'] = null;
        $data['address_two'] = null;
        $data['image'] = "defaultuser.png";
        $data['status'] = 1;
        $data['provider'] = "LOCAL";
        $data['language'] = 'English';
        $data['phone'] = $request->mobile_number;
        $data['is_verify'] = 1;
        $data['logintype'] = 2;
        // if ($data['logintype'] == 2) {
            $checkEmail = User::where('email',$request->email)->count();
            if($checkEmail){
                return redirect()->back()->with('warning','Email already exist or registered with us..Please login to continue');
            }
            $user = User::create($data);
            $user->assignRole('Organizer');
            return redirect()->back()->with('success','Congratulations! Your account registration was successful. You can log in to your account')->withInput($request->input());
        // } else {
        //     $checkEmail = AppUser::where('email',$request->email)->count();
        //     if($checkEmail){
        //         return redirect()->back()->with('warning','Email already exist or registered with us..Please login to continue')->withInput($request->input());
        //     }
        //     $user = AppUser::create($data);
        //     \Auth::guard('appuser')->login($user);
        //     return redirect('/');
        // }
    }

  
}
