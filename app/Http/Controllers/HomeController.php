<?php

namespace App\Http\Controllers;

use App\Helpers\Common;
use App\Models\AppUser;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\CoachingPackage;
use App\Models\CoachingPackageBooking;
use App\Models\Popups;
use App\Models\User;
use App\Models\WhatsappSubscriber;
use App\Services\HomeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use stdClass;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    public function index()
    {
        $selectedCity = Session::has('CURR_CITY') ? Session::get('CURR_CITY') : 'All';
        if($selectedCity != 'All'){
            $data['popup'] = Popups::Where('city', $selectedCity)->orderBy('id','DESC')->first();
        }else{
            $data['popup'] = "";
        }
        
        $data['blog'] = HomeService::allBlogs();
        $data['banner'] = HomeService::allHomeBanners();
        $data['products'] = HomeService::allProducts();
        $categories = Category::whereHas('coachings', function ($query) use($selectedCity){
            if($selectedCity != 'All'){
                $query->where('venue_city',$selectedCity);
            }
            $query->whereHas('coachingPackage');
        })->get()->toArray();
        $categoriesIds = [0];
        if(count($categories)){
            $categoriesIds = array_column($categories, 'id');
        }
        $data['coachingsData'] = HomeService::getCoachingDataByCityWithCategory($categoriesIds, $selectedCity);
        if (!\Session::has('CURR_CITY')) {
            \Session::put('CURR_CITY', 'Bengaluru');
        }
        $data['tournament'] = $this->homeDataApi();
        // dd($data['tournament']);
        return view('home.index', $data);
    }


    // CATEGORY WISE EVENT
    public function coachings(Request $request, $categorySlug)
    {
        $selectedCity = Session::has('CURR_CITY') ? Session::get('CURR_CITY') : 'All';

        // Fetch all categories and find the one that matches the slug
        $categories = Common::allEventCategoriesByApi();
        $category = collect($categories)->firstWhere('slug', $categorySlug);

        // If the category is not found, return a 404 error
        if (!$category) {
            abort(404, 'Category not found.');
        }

        // Get the ID of the matched category
        $categoryId = $category['id'];

        $data['page'] = $request->get('page', 1);
        $data['limit'] = $request->get('limit', 12);


        // Get category tournament data
        $category_tournament = $this->getCatgeoryData($categoryId,$data['page'], $data['limit']);

        $data['category_tournament'] = $category_tournament['CatEventData'] ?? [];
        $data['category'] = $categorySlug;
        $data['pagination'] = $category_tournament['Pagination'] ?? [];
        $data['category_desciption'] = $category['description'] ?? null;
        $data['meta_data'] = [
            'meta_title' => $category['meta_title'] ?? null,
            'meta_description' => $category['meta_description'] ?? null,
            'meta_keyword' => $category['meta_keyword'] ?? null,
        ];
        $data['catId'] = $categoryId;
        return view('home.category-events', $data);
    }

    public function categoryTournamentAjax(Request $request)
    {
        $data = [
            'catId' => $request->get('catId',1),
            'page' => $request->get('page', 1),
            'limit' => $request->get('limit', default: 12),
        ];

        $category_tournament = $this->getCatgeoryData($data['catId'], $data['page'], $data['limit']);
        $data['category_tournament'] = $category_tournament['CatEventData'] ?? [];
        $data['pagination'] = $category_tournament['Pagination'] ?? [];
        return response()->json([
            'html' => view('home.category-events-ajax', $data)->render(),
        ]);
    }    

    public function getCatgeoryData($catId,$page = 1, $limit = 12){
        try {
            // Instantiate the Guzzle client
            $client = new Client();

            $city = \Session::get('CURR_CITY', 'Bengaluru');

            // Prepare the data to send in the request body
            $data = [
                'cat_id' => $catId,
                'city'=>$city,
                "page" => $page,
                "limit" => $limit
            ];

            // Send POST request to the PHP admin panel API with the data in the body
            $baseUrl = env('BACKEND_BASE_URL');
            $response = $client->post("{$baseUrl}/web_api/cat_event.php", [
                'json' => $data,  // Use the 'json' option to send data as JSON in the request body
            ]);

            $responseData = json_decode($response->getBody(), true);

            if ($responseData['Result'] == true) {
                return $responseData;
            }
        } catch (\Throwable $th) {
           return [];
        }
    }

    // LOCATION WISE EVENT
    public function locationTournament(Request $request, $location)
    {
        try {

            $data = [
                'page' => $request->get('page', 1),
                'limit' => $request->get('limit', 12), // Default limit
            ];

            // Get category tournament data
            $fetchData = $this->getLocationTournament($location,$data['page'],$data['limit']);
    
            // Prepare data for the view
            $data['category_tournament'] = $fetchData['CatEventData'];
            $data['location'] = $fetchData['Location'];
            $data['category'] = $location;
            $data['pagination'] = $fetchData['Pagination'] ?? [];
            return view('home.locations', $data);
        } catch (\Exception $e) {
            // Catch exceptions to prevent the app from breaking
            return redirect()->back()->with('error', 'An error occurred while fetching tournament data: ' . $e->getMessage());
        }
    }

    public function locationTournamentAjax(Request $request)
    {
        $data = [
            'location' => $request->get('location'),
            'page' => $request->get('page', 1),
            'limit' => $request->get('limit',  12),
        ];

        $category_tournament = $this->getLocationTournament($data['location'], $data['page'], $data['limit']);
        $data['category_tournament'] = $category_tournament['CatEventData'] ?? [];
        $data['pagination'] = $category_tournament['Pagination'] ?? [];
        return response()->json([
            'html' => view('home.location-ajax', $data)->render(),
        ]);
    }    
    
    public function getLocationTournament($location,$page = 1, $limit = 12)
    {
        // try {
            // Instantiate the Guzzle client
            $client = new Client();
    
            // Prepare the data to send in the request body
            $data = [
                'location' => $location,
                "page" => $page,
                "limit" => $limit
            ];
    
            // Send POST request to the PHP admin panel API with the data in the body
            $baseUrl = env('BACKEND_BASE_URL');
            $response = $client->post("{$baseUrl}/web_api/location_event.php", [
                'json' => $data,  // Use the 'json' option to send data as JSON in the request body
            ]);
    
            // Decode the JSON response
            $responseData = json_decode($response->getBody(), true);
            if ($responseData['Result'] == true) {
                return $responseData;
            }
            // Return the relevant data
            return [
                'CatEventData' => [],
                'Location' => '',
                "Pagination"=>[]
            ];
        // } catch (\Exception $e) {
        //     // Return empty data in case of error
        //     return [
        //         'CatEventData' => [],
        //         'Location' => '',
        //         "Pagination"=>[]
        //     ];
        // }
    }    

    // Social Play
    public function socialPlay(Request $request)
    {
        $data = [
            'city' => $request->get('city', ''),
            'category' => $request->get('category', ''),
            'skill_level' => $request->get('skill_level', ''),
            'page' => $request->get('page', 1),
            'limit' => $request->get('limit', 12), // Default limit
        ];

        $socialPlayResponse = $this->getSocialPlayData($data);
        
        $data['social_play'] = $socialPlayResponse['SocialPlay'];
        $data['pagination'] = $socialPlayResponse['Pagination'];

        return view('home.social-play', $data);
    }

    public function socialPlayAjax(Request $request)
    {
        $data = [
            'city' => $request->get('city', ''),
            'category' => $request->get('category', ''),
            'skill_level' => $request->get('skill_level', ''),
            'page' => $request->get('page', 1),
            'limit' => $request->get('limit', 12),
        ];

        $socialPlayResponse = $this->getSocialPlayData($data);
        $data['social_play'] = $socialPlayResponse['SocialPlay'];
        $data['pagination'] = $socialPlayResponse['Pagination'];

        return response()->json([
            'html' => view('home.social-play-ajax', $data)->render(),
            'pagination' => $socialPlayResponse['Pagination'],
        ]);
    }


    private function getsocialPlayData($data)
    {
        try {
            $client = new Client();
            $baseUrl = env('BACKEND_BASE_URL');
            $response = $client->post("{$baseUrl}/web_api/social_play.php", [
                'json' => $data,
            ]);

            $responseData = json_decode($response->getBody(), true);

            if ($responseData['Result'] == true) {
                return $responseData;
            }
            return [];
        } catch (\Throwable $th) {
            return [];
        }
    }
   
    public function play($uuid){
        $response = $this->fetchplayDetailByApi($uuid);
        $data['play'] = $response['PlayDetail'];
        $data['relatedPlay'] = $response['RelatedPlay'];
        $data['joinedUsers'] = $response['JoinedUsers'];
        return view('home.play-detail',$data);
    }

    private function fetchplayDetailByApi($uuid){
        try {
            // Instantiate the Guzzle client
            $client = new Client();

            // Prepare the data to send in the request body
            $data = [
                "uuid"=>$uuid
            ];

            // Send POST request to the PHP admin panel API with the data in the body
            $baseUrl = env('BACKEND_BASE_URL');
            $response = $client->post("{$baseUrl}/web_api/play_detail.php", [
                'json' => $data,  
            ]);
            // Decode the JSON response
            $responseData = json_decode($response->getBody(), true);
            // dd($responseData);
            if($responseData['Result'] == true || $responseData['Result'] == "true"){
                // Return the HomeData from the response
                return $responseData;
            }
            return [];
        } catch (\Throwable $th) {
           return [];
        }
    }

    // JOIN PLAY
    public function joinPlay(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'eq' => 'required', // Encrypted play ID parameter
            'txt_number' => 'nullable|string|max:50', // User's phone number
            'message' => 'nullable|string|max:255', // User's message
        ]);

        // Check if the user is authenticated
        $user_id = Common::userId();
        if (empty($user_id)) {
            return redirect()->route('home')->with('error', 'Please login to continue!');
        }

        // Decrypt the 'eq' parameter to get the play ID
        $response = Common::decryptLink($request->eq);
        if (empty($response['id'])) {
            return redirect()->route('home')->with('error', 'Invalid play link.');
        }

        // Extract the play ID from the decrypted response
        $play_id = $response['id'];

        // Call the join play API by passing necessary data
        $apiResponse = $this->joinPlayByApi([
            'user_id' => $user_id,   // Use the authenticated user ID
            'play_id' => $play_id,   // The play ID from the decrypted link
            'txt_number' => $request->txt_number,  // User's phone number from the form
            'message' => $request->message,  // User's message from the form
        ]);

        // Check if the API response indicates success or failure
        if (!empty($apiResponse)) {
            if ($apiResponse['Result'] === 'true') {
                return redirect()->route('my-activity')->with('success', 'Successfully joined the play! Please wait for host approval.');
            } else {
                // Return the error message from the API response
                return redirect()->back()->with('error', $apiResponse['ResponseMsg']);
            }
        }

        // In case of an unknown failure, show a generic error message
        return redirect()->route('home')->with('error', 'Unable to join the play, please try again!');
    }

    private function joinPlayByApi($data)
    {
        try {
                // Instantiate the Guzzle HTTP client
                $client = new Client();

                // Prepare the data to send in the API request
                $requestData = [
                    "user_id" => $data['user_id'],   // User ID
                    "play_id" => $data['play_id'],   // Play ID
                    "txt_number" => $data['txt_number'],  // User's phone number
                    "message" => $data['message'],  // Message from the user
                ];

                // Define the base URL for the backend API (you can use an environment variable)
                $baseUrl = env('BACKEND_BASE_URL');

                // Make the POST request to the backend API
                $response = $client->post("{$baseUrl}/web_api/join_play.php", [
                    'json' => $requestData,  // Send the data as JSON in the request body
                ]);

                // Decode the JSON response from the backend API
                $responseData = json_decode($response->getBody(), true);

                // Return the response data
                return $responseData;
        } catch (\Exception $e) {
                // Log any exceptions and return an empty array in case of errors
                \Log::error('Error joining play via API: ' . $e->getMessage());
                return [];
        }
    }



    public function helpCenter(){
        $help = $this->fetchHelpCenterApi();
        return view('frontend.help',compact('help'));
    }
    
    private function fetchHelpCenterApi(){
        try {
            // Instantiate the Guzzle client
            $client = new Client();

            // Prepare the data to send in the request body
            $data = [
                "uid"=>0,
            ];

            // Send POST request to the PHP admin panel API with the data in the body
            $baseUrl = env('BACKEND_BASE_URL');
            $response = $client->post("{$baseUrl}/web_api/help-center.php", [
                'json' => $data,  // Use the 'json' option to send data as JSON in the request body
            ]);
            // Decode the JSON response
            $responseData = json_decode($response->getBody(), true);
            if($responseData['Result'] == true || $responseData['Result'] == "true"){
                // Return the HomeData from the response
                return $responseData['FaqData'];
            }
            return [];
        } catch (\Throwable $th) {
           return [];
        }
    }

    public function faqData(){
        $faq = $this->fetchFaqCenterApi();
        return view('frontend.faq',compact('faq'));
    }

    private function fetchFaqCenterApi(){
        try {
            // Instantiate the Guzzle client
            $client = new Client();

            // Prepare the data to send in the request body
            $data = [
                "uid"=>0,
            ];

            // Send POST request to the PHP admin panel API with the data in the body
            $baseUrl = env('BACKEND_BASE_URL');
            $response = $client->post("{$baseUrl}/web_api/faq.php", [
                'json' => $data,  // Use the 'json' option to send data as JSON in the request body
            ]);
            // Decode the JSON response
            $responseData = json_decode($response->getBody(), true);
            if($responseData['Result'] == true || $responseData['Result'] == "true"){
                // Return the HomeData from the response
                return $responseData['FaqData'];
            }
            return [];
        } catch (\Throwable $th) {
           return [];
        }
    }

    public function myBooking($status){
        $myBooing = $this->fetchMyBookingApi($status);
        return view('frontend.my-booking',compact('myBooing','status'));
    }

    // CREATE PLAY
    public function createPlay(Request $request)
    {
        // Check if user is authenticated
        $user = Common::userId();
        if (empty($user)) {
            return redirect()->route('home')->with('error', 'Please login to continue!');
        }
    
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'cat_id' => 'required|integer',
                'title' => 'required|string|max:225',
                'start_date' => 'required|date',
                'start_time' => 'required',
                'location' => 'required',
                'skill_level' => 'required|array',
                'skill_level.*' => 'string',
                'venue' => 'required|string|max:225',
                'slots' => 'required|integer',
                'price' => 'nullable|numeric',
                'upi_id' => 'nullable|string|max:225',
                'type' => 'required|string|in:public,group',
                'pay_join' => 'nullable|string|in:on,off',
                'note' => 'nullable|string|max:500',
            ]);
    
            // Prepare the payload for the API
            $payload = [
                'user_id' => $user,
                'cat_id' => $validatedData['cat_id'],
                'title' => $validatedData['title'],
                'start_date' => $validatedData['start_date'],
                'start_time' => $validatedData['start_time'],
                'skill_level' => $validatedData['skill_level'], // Array of skill levels
                'location' => $validatedData['location'],
                'venue' => $validatedData['venue'],
                'slots' => $validatedData['slots'],
                'price' => isset($validatedData['pay_join']) && $validatedData['pay_join'] === 'on' ? $validatedData['price'] : 0,
                'upi_id' => $validatedData['upi_id'] ?? null,
                'type' => $validatedData['type'],
                'pay_join' => isset($validatedData['pay_join']) && $validatedData['pay_join'] === 'on' ? 1 : 0,
                'note' => $validatedData['note'] ?? null,
            ];
    
            // Make an HTTP POST request to the backend API
            $client = new Client();
            $apiResponse = $client->post(env('BACKEND_BASE_URL') . '/web_api/create_social_play.php', [
                'json' => $payload,
            ]);
    
            // Decode the API response
            $responseBody = json_decode($apiResponse->getBody(), true);
            // Check the API response for success
            if (isset($responseBody['Result']) && $responseBody['Result'] === 'true') {
                return redirect()->route('home')->with('success', $responseBody['ResponseMsg'] ?? 'Social Play created successfully.');
            }
    
            // Handle API failure response
            return redirect()->route('home')->with('error', $responseBody['ResponseMsg'] ?? 'Failed to create social play.');
    
        } catch (\Exception $e) {
            // Redirect back with error message
            return redirect()->route('home')->with('error', 'An error occurred while creating the social play. Please try again.');
        }
    }    

    public function mySocialPlay(){
        
        $user = Common::userId();
        if (empty($user)) {
            return redirect()->route('home')->with('error', 'Please login to continue!');
        }

        $mySocialPlay = $this->fetchMySocialPlay($user);
        return view('frontend.my-social-play',compact('mySocialPlay'));
    }

    public function updatePlay(Request $request){
        // Check if user is authenticated
        $user = Common::userId();
        if (empty($user)) {
            return redirect()->route('home')->with('error', 'Please login to continue!');
        }

        $response = Common::decryptLink($request->eq);
        // Check if decryption was successful and if required data is available
        if (!$response || !isset($response['id'])) {
            return redirect()->back()->with('error', 'Invalid or missing data.');
        }
    
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'cat_id' => 'required|integer',
                'title' => 'required|string|max:225',
                'start_date' => 'required|date',
                'start_time' => 'required',
                'location' => 'required',
                'skill_level' => 'required|array',
                'skill_level.*' => 'string',
                'venue' => 'required|string|max:225',
                'slots' => 'required|integer',
                'price' => 'nullable|numeric',
                'upi_id' => 'nullable|string|max:225',
                'type' => 'required|string|in:public,group',
                'pay_join' => 'nullable|string|in:on,off',
                'note' => 'nullable|string|max:500',
            ]);
    
            // Prepare the payload for the API
            $payload = [
                'play_id' => $response['id'],
                'user_id' => $user,
                'cat_id' => $validatedData['cat_id'],
                'title' => $validatedData['title'],
                'start_date' => $validatedData['start_date'],
                'start_time' => $validatedData['start_time'],
                'skill_level' => $validatedData['skill_level'], // Array of skill levels
                'venue' => $validatedData['venue'],
                'location' => $validatedData['location'],
                'slots' => $validatedData['slots'],
                'price' => isset($validatedData['pay_join']) && $validatedData['pay_join'] === 'on' ? $validatedData['price'] : 0,
                'upi_id' => $validatedData['upi_id'] ?? null,
                'type' => $validatedData['type'],
                'pay_join' => isset($validatedData['pay_join']) && $validatedData['pay_join'] === 'on' ? 1 : 0,
                'note' => $validatedData['note'] ?? null,
            ];
    
            // Make an HTTP POST request to the backend API
            $client = new Client();
            $apiResponse = $client->post(env('BACKEND_BASE_URL') . '/web_api/update-play.php', [
                'json' => $payload,
            ]);
    
            // Decode the API response
            $responseBody = json_decode($apiResponse->getBody(), true);
            // Check the API response for success
            if (isset($responseBody['Result']) && $responseBody['Result'] === 'true') {
                return redirect()->back()->with('success', $responseBody['ResponseMsg'] ?? 'Social Play updated successfully.');
            }
    
            // Handle API failure response
            return redirect()->back()->with('error', $responseBody['ResponseMsg'] ?? 'Failed to updated social play.');
    
        } catch (\Exception $e) {
            // Redirect back with error message
            return redirect()->back()->with('error', 'An error occurred while creating the social play. Please try again.');
        }
    }

    private function fetchMySocialPlay($user){
        try {
            // Instantiate the Guzzle client
            $client = new Client();

            // Prepare the data to send in the request body
            
            $data = [
                "user_id"=>$user,
            ];

            // Send POST request to the PHP admin panel API with the data in the body
            $baseUrl = env('BACKEND_BASE_URL');
            $response = $client->post("{$baseUrl}/web_api/my-social-play.php", [
                'json' => $data,  // Use the 'json' option to send data as JSON in the request body
            ]);
            // Decode the JSON response
            $responseData = json_decode($response->getBody(), true);
            if($responseData['Result'] == true || $responseData['Result'] == "true"){
                // Return the HomeData from the response
                return $responseData['UserActivity'];
            }
            return [];
        } catch (\Throwable $th) {
           return [];
        }
    }

    public function joinUsers($uuid){
        $userInfo = [];
        $user = Common::userId();
        if (empty($user)) {
            return redirect()->route('home')->with('error', 'Please login to continue!');
        }

        $userInfo = $this->fetchJoinUsersApi($user,$uuid);
        // dd($userInfo);
        return view('frontend.join-users',compact('userInfo'));
    }

    private function fetchJoinUsersApi($user,$uuid){
        try {
            // Instantiate the Guzzle client
            $client = new Client();

            // Prepare the data to send in the request body
            
            $data = [
                "user_id"=>$user,
                "play_id"=>$uuid,
            ];

            // Send POST request to the PHP admin panel API with the data in the body
            $baseUrl = env('BACKEND_BASE_URL');
            $response = $client->post("{$baseUrl}/web_api/play-users.php", [
                'json' => $data,  // Use the 'json' option to send data as JSON in the request body
            ]);
            // Decode the JSON response
            $responseData = json_decode($response->getBody(), true);
            if($responseData['Result'] == true || $responseData['Result'] == "true"){
                // Return the HomeData from the response
                return $responseData['JoinDetails'];
            }
            return [];
        } catch (\Throwable $th) {
           return [];
        }
    }

    public function updateJoinStatus(Request $request)
    {
        // Decrypt the link to get the data
        $response = Common::decryptLink($request->eq);

        // Check if decryption was successful and if required data is available
        if (!$response || !isset($response['join_id'], $response['status'])) {
            return redirect()->back()->with('error', 'Invalid or missing data.');
        }

        $join_id = $response['join_id'];
        $status = $response['status'];

        try {
            // Validate status input
            if (!in_array($status, ['accept', 'decline'])) {
                return redirect()->back()->with('error', 'Invalid status value.');
            }

            // Instantiate the Guzzle client
            $client = new Client();

            // Prepare the data to send in the request body
            $data = [
                "join_id" => $join_id,
                "status" => $status,
            ];

            // Send POST request to the PHP admin panel API
            $baseUrl = env('BACKEND_BASE_URL');
            $apiUrl = "{$baseUrl}/web_api/update_joinuser_status.php";

            $response = $client->post($apiUrl, [
                'json' => $data,
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            // Decode the JSON response
            $responseData = json_decode($response->getBody(), true);

            // Check if the API response is successful
            if (isset($responseData['Result']) && $responseData['Result'] == "true") {
                return redirect()->back()->with('success', 'Play user status updated successfully.');
            }

            return redirect()->back()->with('error', $responseData['ResponseMsg'] ?? 'Failed to update play user status.');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'An error occurred while updating the status.');
        }
    }
   

    public function myActivity(){
        $user = Common::userId();
        if (empty($user)) {
            return redirect()->route('home')->with('error', 'Please login to continue!');
        }

        $myActivity = $this->myActivityApi($user);
        return view('frontend.my-activity',compact('myActivity'));
    }

    private function myActivityApi($user){
        try {
            // Instantiate the Guzzle client
            $client = new Client();

            $data = [
                "user_id"=>$user,
            ];

            // Send POST request to the PHP admin panel API with the data in the body
            $baseUrl = env('BACKEND_BASE_URL');
            $response = $client->post("{$baseUrl}/web_api/my-social-activity.php", [
                'json' => $data,  // Use the 'json' option to send data as JSON in the request body
            ]);
            // Decode the JSON response
            $responseData = json_decode($response->getBody(), true);
            if($responseData['Result'] == true || $responseData['Result'] == "true"){
                // Return the HomeData from the response
                return $responseData['UserActivity'];
            }
            return [];
        } catch (\Throwable $th) {
           return [];
        }
    }

    private function fetchMyBookingApi($status){
        try {
            // Instantiate the Guzzle client
            $client = new Client();

            $user = Common::userId();
            // Prepare the data to send in the request body
            $data = [
                "uid"=>$user,
                "status"=>$status
            ];

            // Send POST request to the PHP admin panel API with the data in the body
            $baseUrl = env('BACKEND_BASE_URL');
            $response = $client->post("{$baseUrl}/web_api/ticket_status.php", [
                'json' => $data,  // Use the 'json' option to send data as JSON in the request body
            ]);
            // Decode the JSON response
            $responseData = json_decode($response->getBody(), true);
            if($responseData['Result'] == true || $responseData['Result'] == "true"){
                // Return the HomeData from the response
                return $responseData['order_data'];
            }
            return [];
        } catch (\Throwable $th) {
           return [];
        }
    }    


    public function tournamentType(Request $request, $type) {
        $data['page'] = $request->get('page', 1);
        $data['limit'] = $request->get('limit', 12);

        $category_tournament = $this->getTournamentByType($type, $data['page'], $data['limit']);
        $data['category_tournament'] = $category_tournament['Events'] ?? [];
        $data['category'] = $type;
        $data['pagination'] = $category_tournament['Pagination'] ?? [];
        // dd($data);
        return view('home.coachings', $data);
    }
    public function fetchTournaments(Request $request)
    {
        $data = [
            'type' => $request->get('type', 'default'),
            'page' => $request->get('page', 1),
            'limit' => $request->get('limit', default: 12),
        ];

        $category_tournament = $this->getTournamentByType($data['type'], $data['page'], $data['limit']);
        $data['category_tournament'] = $category_tournament['Events'] ?? [];
        $data['pagination'] = $category_tournament['Pagination'] ?? [];
        return response()->json([
            'html' => view('home.coachings-ajax', $data)->render(),
        ]);
    }    

    public function getTournamentByType($type, $page = 1, $limit = 12) {
        try {
            $client = new Client();
            $city = \Session::get('CURR_CITY', 'Bengaluru');

            $data = [
                "city" => $city,
                "type" => $type,
                "page" => $page,
                "limit" => $limit
            ];

            $baseUrl = env('BACKEND_BASE_URL');
            $response = $client->post("{$baseUrl}/web_api/event_type_data.php", [
                'json' => $data,
            ]);

            $responseData = json_decode($response->getBody(), true);

            if ($responseData['Result'] == true) {
                return $responseData;
            }
            return ['Events' => [], 'Pagination' => []];
        } catch (\Throwable $th) {
            return ['Events' => [], 'Pagination' => []];
        }
    }
    
 
    public function homeDataApi($uid=0,$lats =0,$longs =0)
    {
        // Caching the response for 10 minutes
        // $homeData = \Cache::remember('home-data', 10, function() use($uid,$lats,$longs){
            // Instantiate the Guzzle client
            $client = new Client();

            $city = \Session::get('CURR_CITY', 'Bengaluru');
            // Prepare the data to send in the request body
            $data = [
                'uid' => $uid,
                'lats' => $lats,
                'longs' => $longs,
                'city'=> $city,
            ];

            // Send POST request to the PHP admin panel API with the data in the body
            $baseUrl = env('BACKEND_BASE_URL');
            $response = $client->post("{$baseUrl}/web_api/home_data.php", [
                'json' => $data,  // Use the 'json' option to send data as JSON in the request body
            ]);
            // Decode the JSON response
            $responseData = json_decode($response->getBody(), true);

            if($responseData['ResponseCode'] == 200){
                // Return the HomeData from the response
                return $responseData['HomeData'];
            }
            // Return the HomeData from the response
            return [];
        // });

        // Return the cached or fetched home data
        // return $homeData;
    }

    public function coachingBook(string $title,int $id)
    {
        $selectedCity = Session::has('CURR_CITY') ? Session::get('CURR_CITY') : 'All';
        $data['isTicketSoldAvailable'] = HomeService::checkedIfTicketSoldOut($id);
        
        $inputObj = new stdClass();
        $inputObj->params = 'coach_id='.$id;
        $inputObj->url = route('coaching-packages');
        $data['packageLink'] = Common::encryptLink($inputObj);

        $user = Common::userId();
        $details = $this->getTournamentDetails($user,$id);
        $data['tournament_detail'] = $details['EventData'];
        $data['tournament_detail']['category'] = $details['category'];
        $data['tournament_gallery'] = $details['Event_gallery'];
        $data['tournament_Artist'] = $details['Event_Artist'];
        $data['tournament_Facility'] = $details['Event_Facility'];
        $data['tournament_Restriction'] = $details['Event_Restriction'];
        $data['tournament_reviewdata'] = $details['reviewdata'];
        $data['related_tournament'] = $details['related'];
        
        
        // Use the title to create a more descriptive QR code file name
        $sanitizedTitle = preg_replace('/[^A-Za-z0-9\-]/', '_', $title); // Sanitize the title for use in filenames
        $qrCodeFileName = 'coaching-' . $sanitizedTitle . '-' . $id . '.png';
        $qrCodePath = public_path('qrcodes/' . $qrCodeFileName);
        
        // Check if the QR code already exists
        if (!file_exists($qrCodePath)) {
            \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                ->size(150) // Set the size of the QR code
                ->margin(0) // Minimize padding
                ->generate(route('coaching-detail', ['title' => $title, 'id' => $id]), $qrCodePath); // Generate and store the QR code
        }
        
        // Return the public URL for the cached QR code
        $data['qrCodePath'] = asset('qrcodes/' . $qrCodeFileName);
        // Generate share message
        return view('home.coaching-book', $data);
    }

    public function getTournamentDetails($userId, $eventId){
        try {
            // Instantiate the Guzzle client
            $client = new Client();

            // Prepare the data to send in the request body
            $data = [
                "uid"=>$userId,
                "event_id"=>$eventId
            ];

            // Send POST request to the PHP admin panel API with the data in the body
            $baseUrl = env('BACKEND_BASE_URL');
            $response = $client->post("{$baseUrl}/web_api/event_detail.php", [
                'json' => $data,  // Use the 'json' option to send data as JSON in the request body
            ]);
            // Decode the JSON response
            $responseData = json_decode($response->getBody(), true);

            // Return the HomeData from the response
            return $responseData;
        } catch (\Throwable $th) {
           return [];
        }
    }

    public function cityCoachings($cityName){
        $coachData = HomeService::getCoachingDataByCity($cityName);
        $data['cityName'] = $cityName;
        $data['coachingData'] = $coachData;
        return view('home.city-coachings', $data);
    }


    public function coachingPackages(){
        $coachingId = $this->memberObj['coach_id'];
        $data['tour_plans'] = $this->coachingPrice($coachingId);
        $data['coaching_id'] = $coachingId;
        return view('home.coaching-package', $data);
    }

    public function pagesData($slug){
        $pages = Common::pageListData();
        $page = null;
        foreach ($pages as $p) {
            if ($p['slug'] == $slug) {
                $page = $p;
                break;
            }
        }

        if (!$page) {
            abort(404); // Handle case where page is not found
        }
        return view('frontend.terms-and-conditions', ['page' => $page]); // Pass single page data
    }

    public function coachingPrice($event_id){
        try {
            // Instantiate the Guzzle client
            $client = new Client();

            // Prepare the data to send in the request body
            $data = [
                'event_id' => $event_id
            ];

            // Send POST request to the PHP admin panel API with the data in the body
            $baseUrl = env('BACKEND_BASE_URL');
            $response = $client->post("{$baseUrl}/web_api/u_event_type_price.php", [
                'json' => $data,  // Use the 'json' option to send data as JSON in the request body
            ]);
            // Decode the JSON response
            $responseData = json_decode($response->getBody(), true);

            // Return the HomeData from the response
            return $responseData['EventTypePrice'];
        } catch (\Throwable $th) {
           return [];
        }
    }

    public function bookCoachingPackage()
    {
        $packageId = $this->memberObj['id'];
        $data['coachingData'] = HomeService::getCoachingDataByPackage($packageId);
        if($data['coachingData']->is_sold_out == 1){
            return redirect('/');
        }

        $inputObj = new stdClass();
        $inputObj->params = 'id='.$packageId;
        $inputObj->url = url('store-book-coaching-package');
        $data['encLink'] = Common::encryptLink($inputObj);


        return view('home.book-coaching-package', $data);
    }

    public function get_curl_handle($razorpay_payment_id){
         $settingData = Common::paymentKeysAll();
         $url = 'https://api.razorpay.com/v1/payments/' . $razorpay_payment_id . '/capture';
         $key_id = $settingData->razorPublishKey;
         $key_secret = $settingData->razorSecretKey;
 
          $curl = curl_init();
 
         curl_setopt_array($curl, [
         CURLOPT_URL => "https://api.razorpay.com/v1/payments/".$razorpay_payment_id,
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => "",
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 30,
         CURLOPT_USERPWD=>$key_id . ':' . $key_secret,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => "GET",
         ]);
 
         return $curl;
     }

    public function storeBookCoachingPackage(Request $request)
    {
        $packageId = $this->memberObj['id'];
        $userId = Auth::guard('appuser')->check() ? Auth::guard('appuser')->user()->id : 0;
        $packageData = CoachingPackage::find($packageId);

        $realPrice = $packageData->package_price;
        $afterDiscountPrice = $packageData->package_price;
        if($packageData->discount_percent > 0 && $packageData->discount_percent <= 100){
            $perc = ($realPrice * $packageData->discount_percent) / 100;
            $afterDiscountPrice = round($realPrice - $perc, 2);
            $showDiscount = 1;
        }

        if($request->payment_method == 2){
           
            $orderId = CoachingPackageBooking::insertGetId([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'mobile_number' => $request->mobile_number,
                'address' => 'NA',
                'booking_id' => $request->merchant_order_id,
                'transaction_id' => $request->merchant_trans_id,
                'coaching_package_id' => $packageId,
                'user_id' => $userId,
                'actual_amount' => round($afterDiscountPrice, 2),
                'paid_amount' => $request->merchant_total / 100,
                'expiry_date' => date("Y-m-d H:i:s", strtotime("+".$packageData->package_duration)),
                'is_active' => CoachingPackageBooking::STATUS_ACTIVE,
                'payment_type' => 2,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            ]);
            
            if(!empty($request->whattsapp_subscribe)){
                WhatsappSubscriber::insert([
                    'phone_number'=>$request->mobile_number,
                    'created_at'=>date("Y-m-d H:i:s"),
                    'updated_at'=>date("Y-m-d H:i:s")
                ]);
            }

            $inputObjB = new \stdClass();
            $inputObjB->url = url('booked-coaching-package-details');
            $inputObjB->params = 'package_booking_id='.$orderId;
            $subLink = Common::encryptLink($inputObjB);

            return redirect($subLink)->with('success','Ticket Booked Successfully...');
        }else{
            if(!empty($request->razorpay_payment_id) && !empty($request->merchant_order_id)){
                $razorpay_payment_id = $request->razorpay_payment_id;
                $merchant_order_id = $request->merchant_order_id;
                $success = false;
                $error = '';
                try{
                    $ch = $this->get_curl_handle($razorpay_payment_id);
                    $result = curl_exec($ch);
                    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    if ($result === false){
                        $success = false;
                        $error = 'Curl error: ' . curl_error($ch);
                    }else{
                        $response_array = json_decode($result, true);
                        if ($http_status === 200 and isset($response_array['error']) === false){
                            $success = true;
                        }else{
                            $success = false;
                            if (!empty($response_array['error']['code'])){
                                $error = $response_array['error']['code'] . ':' . $response_array['error']['description'];
                            }else{
                                $error = 'RAZORPAY_ERROR:Invalid Response <br/>' . $result;
                            }
                        }
                    }
                    curl_close($ch);
                }catch(\Exception $e){
                    $success = false;
                    $error = 'OPENCART_ERROR:Request to Razorpay Failed';
                }
                if ($success === true){
                   
                    $checkData = CoachingPackageBooking::select('id')->where(['coaching_package_id'=>$packageId,'transaction_id'=>$razorpay_payment_id])->first();
                    if(!$checkData){
                        $orderId = CoachingPackageBooking::insertGetId([
                            'full_name' => $request->full_name,
                            'email' => $request->email,
                            'mobile_number' => $request->mobile_number,
                            'address' => 'NA',
                            'booking_id' => $merchant_order_id,
                            'transaction_id' => $razorpay_payment_id,
                            'coaching_package_id' => $packageId,
                            'user_id' => $userId,
                            'actual_amount' => round($afterDiscountPrice, 2),
                            'paid_amount' => $request->merchant_total / 100,
                            'expiry_date' => date("Y-m-d H:i:s", strtotime("+".$packageData->package_duration)),
                            'is_active' => CoachingPackageBooking::STATUS_ACTIVE,
                            'payment_type' => 1,
                            'created_at'=>date("Y-m-d H:i:s"),
                            'updated_at'=>date("Y-m-d H:i:s")
                        ]);
                        
                        if(!empty($request->whattsapp_subscribe)){
                            WhatsappSubscriber::insert([
                                'phone_number'=>$request->mobile_number,
                                'created_at'=>date("Y-m-d H:i:s"),
                                'updated_at'=>date("Y-m-d H:i:s")
                            ]);
                        }
                      
                    }else{
                        $orderId = $checkData->id;
                    }
    
                    $inputObjB = new \stdClass();
                    $inputObjB->url = url('booked-coaching-package-details');
                    $inputObjB->params = 'package_booking_id='.$orderId;
                    $subLink = Common::encryptLink($inputObjB);
    
                    return redirect($subLink)->with('success','Ticket Booked Successfully...');
                }else{
                    echo "<h4>Something went wrong..Payment Failed... <a href='/'>GO BACK TO Home</a></h4>";
                    exit();
                }
            }else{
                echo "<h4>Something went wrong..Payment Failed... <a href='/'>GO BACK TO Home</a></h4>";
                    exit();
            }
        }

        
    }

    public function bookedCoachingPackageDetails()
    {
        $packageBookingId = $this->memberObj['package_booking_id'];
        $data['orderData'] = CoachingPackageBooking::with(['coachingPackage' => function($query){
            $query->with('coaching');
        }])->find($packageBookingId);
        $data['userData'] = User::find($data['orderData']->coachingPackage->coaching->organiser_id);
        // dd($data['userData']);
        return view('home.booked-coaching-package-details', $data);
    }
}
