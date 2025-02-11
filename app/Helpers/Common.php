<?php

namespace App\Helpers;
use App\Models\Category;
use App\Models\CourtSlot;
use Auth;
use GuzzleHttp\Client;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Common
{
  const TYPE_COURT_BOOK = 1;
  const TYPE_COACH_BOOK = 2;
  const STATUS_ACTIVE = 1;
  public static function encryptLink($inputObj){
    $params = isset($inputObj->params) ? $inputObj->params : '';
    $url = url($inputObj->url);
    if($params!=''){
      $link = $url.'?eq='.urlencode(\Crypt::encrypt($inputObj->params));
      return $link;
    }
    return $url;
  }

  public static function decryptLink($input){
    $decrString = urldecode(\Crypt::decrypt($input));
    $reqArr = [];
    if(strpos($decrString,"=")!==false){
      $keyVal = explode("&",$decrString);
      if(count($keyVal) > 0){
        foreach($keyVal as $v):
          $kvarr = explode("=",$v);
          if(count($kvarr)>0){
            $reqArr[$kvarr[0]] = $kvarr[1];
          }
        endforeach;
      }
    }
    return $reqArr;
  }

  public static function isUserLogin()
  {
      // Check if the session contains 'user_id'
      if (Session::has('user_login_session') && Session::get('user_login_session')['id']) {
          return true;  // The user is logged in
      } else {
          return false;  // The user is not logged in
      }
  }


//   public static function razorpayCredential(){
//     return [
//       'key'=>'rzp_test_Hz6WNQ7Mmd23f3',
//       'secret_id'=>'uzS1BmibeaZrMQHqjoYjrH5z',
//       'account_number'=>'2323230076407708'
//     ];
//   }

  public static function siteGeneralSettings(){
    $settingData = \Cache::rememberForever('site-general-settings',function(){
      return \App\Models\Setting::select('app_name','email','logo','favicon','footer_copyright','currency','currency_sybmol','timezone','Facebook','Twitter','Instagram')->find(1);
    });
    return $settingData;
  }

  public static function userId(){
   return Common::isUserLogin() ? \Session::get('user_login_session')['id'] : 0;
  }

  public static function siteGeneralSettingsApi(){
    // $settingData = \Cache::rememberForever('site-general-settings',function(){
    //   return \App\Models\Setting::select('app_name','email','logo','favicon','footer_copyright','currency','currency_sybmol','timezone','Facebook','Twitter','Instagram')->find(1);
    // });
    // return $settingData;
    
    $siteData = \Cache::remember('site-general-settings-apis', 10, function(){
     
      // Instantiate the Guzzle client
     $client = new Client();

     // Send GET request to the PHP admin panel API
     $baseUrl = env('BACKEND_BASE_URL');
     $response = $client->get("{$baseUrl}/web_api/site_setting.php");

     // Decode the JSON response
     $data = json_decode($response->getBody(), true);

     return $siteData = $data['HomeData'];

     // Pass the data to the view to display in the frontend
     // return view('frontend.content', ['data' => $data]);

   });
   return $siteData;
  }

     public static function pageListData()
    {
        $siteData = \Cache::remember('site-pages', 10, function () {
            $client = new Client();
            $baseUrl = env('BACKEND_BASE_URL');
            try {
                $response = $client->get("{$baseUrl}/web_api/page-list.php");
                $data = json_decode($response->getBody(), true);
                if (isset($data['pagelist']) && is_array($data['pagelist'])) {
                    // Generate slugs within the cached data
                    $data['pagelist'] = array_map(function ($item) {
                        $item['slug'] = Str::slug($item['title']);
                        return $item;
                    }, $data['pagelist']);
                    return $data['pagelist'];
                } else {
                    Log::error("Invalid page list data received from API: " . json_encode($data));
                    return []; // Return empty array on error
                }
            } catch (\GuzzleHttp\Exception\GuzzleException $e) {
                Log::error("Error fetching page list from API: " . $e->getMessage());
                return []; // Return empty array on error
            }
        });
        return $siteData;
    }

  public static function daysArr(){
    return ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
  }

  public static function generateUniqueTicketNum($ticket){
    $checkData = \App\Models\Ticket::where('ticket_number',$ticket)->count();
    return $ticket.($checkData+1);
  }

  public static function allEventCategories(){
    $catData = \Cache::rememberForever('event-categories',function(){
      return \App\Models\Category::select('id','name','slug','image')->orderBy('order_num','ASC')->where('status',1)->get();
    });
    return $catData;
  }

  public static function fetchLocation(){
      try {
        
          $payData = \Cache::remember('location', 10, function() {
              // Instantiate the Guzzle client
              $client = new Client();
    
              // Send GET request to the PHP admin panel API
              $baseUrl = env('BACKEND_BASE_URL');
              $response = $client->get("{$baseUrl}/web_api/location.php");
    
              // Decode the JSON response
              $data = json_decode($response->getBody(), true);
    
              // Ensure that 'Location' is set and return it
              return isset($data['Location']) ? $data['Location'] : [];
          });
    
          return $payData;
      } catch (\Throwable $th) {
          // If an error occurs, return an empty array
          return [];
      }
  }
  
  public static function paymentGatewayList(){
   
    $payData =  \Cache::remember('payment-gateway', 10, function(){
    
      // Instantiate the Guzzle client
      $client = new Client();

      // Send GET request to the PHP admin panel API
      $baseUrl = env('BACKEND_BASE_URL');
      $response = $client->get("{$baseUrl}/web_api/u_paymentgateway.php");

      // Decode the JSON response
      $data = json_decode($response->getBody(), true);
      return $payData = $data['paymentdata'];

    });
    return $payData;
  }

  public static function allEventCategoriesByApi()
  {
      $catData = \Cache::remember('tournament-categories', 10, function () {
          $client = new Client();
          $baseUrl = env('BACKEND_BASE_URL');
          $response = $client->get("{$baseUrl}/web_api/cat_data.php");
          $data = json_decode($response->getBody(), true);
          
          // Generate slugs for each category
          return collect($data['HomeData'])->map(function ($cat) {
              $cat['slug'] = Str::slug($cat['title']);
              return $cat;
          })->toArray();
      });

      return $catData;
  }


  public static function fetchUserDetails()
  {
      // Retrieve the session data
      $userSession = Session::get('user_login_session');
  
      // Blank data structure for fallback
      $blankData = [
          'name' => "",
          'email' => "",
          'ccode' => "",
          'mobile' => "",
          'refercode' => "",
          'parentcode' => "",
          'reg_date' => "",
          'status' => "",
          'pro_pic' => "",
          'wallet' => "",
      ];
  
      // Check if the session exists
      if (!$userSession) {
          Session::forget('user_login_session');
          return $blankData;
      }
  
      // Use the user ID from the session
      $userId = $userSession['id'];
  
      try {
          // Instantiate the Guzzle client
          $client = new Client();
  
          // Backend API base URL
          $baseUrl = env('BACKEND_BASE_URL');
  
          // Data to send in the API request
          $data = ['uid' => $userId];
  
          // Send POST request to the PHP admin panel API
          $response = $client->post("{$baseUrl}/web_api/user_profile.php", [
              'json' => $data, // Send data as JSON in the request body
          ]);
  
          // Decode the JSON response
          $responseData = json_decode($response->getBody(), true);
  
          // Check if the response is successful
          if (isset($responseData['Result']) && $responseData['ResponseCode'] === "200") {
              return $responseData['user_info']; // Return user info
          } else {
              // If API returns an error, clear the session
              Session::forget('user_login_session');
              return $blankData;
          }
      } catch (\Exception $e) {
          // Log the exception for debugging
          Log::error('Error fetching user profile', [
              'userId' => $userId,
              'message' => $e->getMessage(),
          ]);
  
          // Clear the session and return blank data
          Session::forget('user_login_session');
          return $blankData;
      }
  }  
  
  public static function abhisheka(){
    $selectedCity = \Session::has('CURR_CITY') ? \Session::get('CURR_CITY') : 'All';
    $date = date("Y-m-d H:i:s");
    $category = Category::select('id','name','slug','image','banner_image','redirect_link')->with(['events'=>function($query) use($date,$selectedCity){
      $query->select('events.name as name','events.id','category_id','events.image','temple_name','t.price','t.discount_type','t.discount_amount')->where([['events.status', 1], ['events.is_deleted', 0], ['event_status', 'Pending']])->where(function($q) use($date){
          $q->where('events.end_time', '>', $date)->orWhereIn('event_type',[2,3]);
      });
      if($selectedCity!='All'){
          $query->where('city_name',$selectedCity);
      }
      $query->leftJoin('tickets as t','t.event_id','events.id');
      $query->orderBy('event_type','ASC')->orderBy('events.start_time', 'desc')->groupBy('events.id')->take(20);
    }])->where('status', 1)->orderBy('order_num', 'ASC')->get();
    // dd($category);
    return $category;

  }

  public static function allEventCities(){
    $catData = \Cache::rememberForever('event-cities',function(){
      return \App\Models\City::select('city_name','id')->groupBy('city_name')->has('selectCity')->get();
    });
    return $catData;
  }


  public static function allCities(){
    return \App\Models\City::select('city_name','id')->groupBy('city_name')->get();
  }


  public static function nextTwoWeeks(){
    $days   = [];
    $period = new \DatePeriod(new \DateTime(), new \DateInterval('P1D'),  14);
    foreach ($period as $day)
    {
        $days[] = $day->format('d M Y');
    }
    return $days;
  }

  public static function generateUniqueCouponNum($ticket){
    $checkData = \App\Models\Coupon::where('coupon_code',$ticket)->count();
    return $ticket.($checkData+1);
  }

  public static function generateUniqueUserTicketNumber($ticket){
    $checkData = \App\Models\OrderChild::where('ticket_number',$ticket)->count();
    return $ticket.($checkData+1);
  }

  public static function paymentKeysAll(){
    $settingData = \Cache::rememberForever('payment-keys-all',function(){
      return \App\Models\PaymentSetting::select('razorPublishKey','razorSecretKey')->find(1);
    });
    return $settingData;
  }

  public static function randomMerchantId($userId){
    return substr(str_shuffle($userId.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,3).time().rand(111,999);
  }


  public static function encryptId($string){
    $privateKey 	= 'NXYvSqE96kxiF5rJPn'; // user define key
    $secretKey 		= 'OcXifC2PjV5wf'; // user define secret key
    $encryptMethod  = "AES-256-CBC";
    $string 		= $string; // user define value

    $key = hash('sha256', $privateKey);
    $ivalue = substr(hash('sha256', $secretKey), 0, 16); // sha256 is hash_hmac_algo
    $result = openssl_encrypt($string, $encryptMethod, $key, 0, $ivalue);
    return base64_encode($result);  // output is a encripted value
}

public static function decryptId($stringEncrypt){
    $privateKey 	= 'NXYvSqE96kxiF5rJPn'; // user define key
    $secretKey 		= 'OcXifC2PjV5wf'; // user define secret key
    $encryptMethod      = "AES-256-CBC";
    $key    = hash('sha256', $privateKey);
    $ivalue = substr(hash('sha256', $secretKey), 0, 16); // sha256 is hash_hmac_algo
    return  openssl_decrypt(base64_decode($stringEncrypt), $encryptMethod, $key, 0, $ivalue);
}

public static function shippingCharge(){
  return 100;
}

public static function statesAll(){
  $cityData = \Cache::rememberForever('states-all',function(){
    return \DB::table('states')->select('state_title')->where('status','ACTIVE')->get();
  });
  return $cityData;
}

public static function checkstepCount(){
  $userID = Auth::id();
  $checkData = \App\Models\TempEvent::select('step_count')->where('user_id',$userID)->orderBy('id','DESC')->first();
  return $checkData;
}

public static function allAgeGroup(){
  return [
    '18+',
    'Teens',
    'Anyone'
  ];
}

public static function demoOptions(){
  return ['No','Yes'];
}

public static function equipmentOptions(){
  return ['No','Yes'];
}

public static function allSkillsArr(){
  return ['Beginer','Intermediate','Advanced','Professional'];
}

public static function sessionPlanArr(){
  return ['Monthly','Weekly Batch','Summer Batch','Special Batch','Quarterly','Half-Yearly','Yearly'];
}

public static function amenitiesArr(){
    return [
      [
        'sport'=>'Bed Room',
        'image'=>asset('images/amenities/white/bedroom.svg')
      ],
      [
        'sport'=>'Blue Parking',
        'image'=>asset('images/amenities/white/blueparking.svg')
      ],
      [
        'sport'=>'Changing Room',
        'image'=>asset('images/amenities/white/changingroom.svg')
      ],
      [
        'sport'=>'Drinking',
        'image'=>asset('images/amenities/white/drinking.svg')
      ],
      [
        'sport'=>'FirstAid',
        'image'=>asset('images/amenities/white/firstaid.svg')
      ],
      [
        'sport'=>'Parking',
        'image'=>asset('images/amenities/white/parking.svg')
      ],
      [
        'sport'=>'Running',
        'image'=>asset('images/amenities/white/running.svg')
      ],
      [
        'sport'=>'Shower',
        'image'=>asset('images/amenities/white/shower.svg')
      ],
      [
        'sport'=>'Toilets',
        'image'=>asset('images/amenities/white/toilets.svg')
      ],
      [
        'sport'=>'Washroom',
        'image'=>asset('images/amenities/white/washroom.svg')
      ],
      [
        'sport'=>'Dress Change',
        'image'=>asset('images/amenities/white/dresschange.svg')
      ],
      [
        'sport'=>'Lockers',
        'image'=>asset('images/amenities/white/lockers.svg')
      ],
      [
        'sport'=>'Signage',
        'image'=>asset('images/amenities/white/signage.svg')
      ],
      [
        'sport'=>'Wifi',
        'image'=>asset('images/amenities/white/wifi.svg')
      ],
    
      
    ];
}

public static function availableSportsArr(){
  return [
    [
      'sport'=>'Badminton',
      'image'=>asset('images/amenities/white/badminton.svg')
    ],
    [
      'sport'=>'Basket Ball',
      'image'=>asset('images/amenities/white/basketball.svg')
    ],
    [
      'sport'=>'Cricket',
      'image'=>asset('images/amenities/white/cricket.svg')
    ],
    [
      'sport'=>'Long Tennis',
      'image'=>asset('images/amenities/white/longtennis.svg')
    ],
    [
      'sport'=>'Skating',
      'image'=>asset('images/amenities/white/skating.svg')
    ],
    [
      'sport'=>'Swimming',
      'image'=>asset('images/amenities/white/swimming.svg')
    ],
    [
      'sport'=>'Table Tennis',
      'image'=>asset('images/amenities/white/tabletennis.svg')
    ],
    [
      'sport'=>'Volley Ball',
      'image'=>asset('images/amenities/white/volleyball.svg')
    ],
    [
      'sport'=>'Chess',
      'image'=>asset('images/amenities/white/chess.svg')
    ],
    [
      'sport'=>'Crossfit',
      'image'=>asset('images/amenities/white/crossfit.svg')
    ],
    [
      'sport'=>'Hockey',
      'image'=>asset('images/amenities/white/hockey.svg')
    ],
    [
      'sport'=>'Yoga',
      'image'=>asset('images/amenities/white/yoga.svg')
    ],
    [
      'sport'=>'Hockey',
      'image'=>asset('images/amenities/white/hockey.svg')
    ],
    [
      'sport'=>'Zumba',
      'image'=>asset('images/amenities/white/zumba.svg')
    ],
  
    
  ];
}

public static function SportsSvgArr($key){
  $arr = [
    'Badminton' => asset('images/amenities/white/badminton.svg'),
    'Basket_Ball' => asset('images/amenities/white/basketball.svg'),
    'Cricket' => asset('images/amenities/white/cricket.svg'),
    'Long_Tennis' => asset('images/amenities/white/longtennis.svg'),
    'Skating' => asset('images/amenities/white/skating.svg'),
    'Swimming' => asset('images/amenities/white/swimming.svg'),
    'Table_Tennis' => asset('images/amenities/white/tabletennis.svg'),
    'Volley_Ball' => asset('images/amenities/white/volleyball.svg'),
    'Chess' => asset('images/amenities/white/chess.svg'),
    'Chess' => asset('images/amenities/white/chess.svg'),
    'Hockey' => asset('images/amenities/white/hockey.svg'),
    'Yoga' => asset('images/amenities/white/yoga.svg'),
    'Zumba' => asset('images/amenities/white/zumba.svg'),
  ];
  return $arr[$key];
}

public static function amenitiesSvgArr($key){
  $arr = [
    'Bed_Room' => asset('images/amenities/white/bedroom.svg'),
    'Blue_Parking' => asset('images/amenities/white/blueparking.svg'),
    'Changing_Room' => asset('images/amenities/white/changingroom.svg'),
    'Drinking' => asset('images/amenities/white/drinking.svg'),
    'FirstAid' => asset('images/amenities/white/firstaid.svg'),
    'Parking' => asset('images/amenities/white/parking.svg'),
    'Running' => asset('images/amenities/white/running.svg'),
    'Shower' => asset('images/amenities/white/shower.svg'),
    'Toilets' => asset('images/amenities/white/toilets.svg'),
    'Washroom' => asset('images/amenities/white/washroom.svg'),
    'Dress_Change' => asset('images/amenities/white/dresschange.svg'),
    'Lockers' => asset('images/amenities/white/lockers.svg'),
    'Signage' => asset('images/amenities/white/signage.svg'),
    'Wifi' => asset('images/amenities/white/wifi.svg'),
  ];
  return $arr[$key];
}

public static function courtBookDurationArr(){
  return [
    '30 minute'=>'30 Minute',
    '1 hour'=>'1 Hour',
    '2 hour'=>'2 Hour',
    '3 hour'=>'3 Hour',
  ];
}

public static function generateCourtToken(){
    do {
        $str = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890'),15);
    } while (CourtSlot::where('slot_token', $str)->exists());
    return $str;
}

public static function allBenefits($categoryId){
  $data =  Category::select('benefits')->where('id',$categoryId)->first();
  return explode(',',$data->benefits);
}

public static function randomRatings(){
  $num = rand(3,5);
  $str = '';
  for($i = 1; $i <= 5; $i++){
    $str .= '<small><i class="fas fa-star '.($i <= $num ? 'active' : '').'"></i></small>';
  }
  return $str. '<span class="text-dark"> ('.$num.') Ratings</span>';                                      
}

public static function showDiscountLabel($price = 0, $discount = 0)
{ 
  $afterDiscountPrice = $price;
  if($discount > 0 && $discount < 101){
    $percPrice = $price * ($discount / 100);
    $afterDiscountPrice = $price - $percPrice;
  }
  $str = '<p class=" h6 text-dark mb-1">';
  if($price == $afterDiscountPrice){
    return '<span class="font-weight-bold pr-2">₹'. ($price+0) .'</span>';
  }else{
    $str .= '<small>
                <del class="mr-1 text-muted "> 
                    ₹'. ($price+0) .'
                </del>
            </small>
            <span class="font-weight-bold pr-2">₹'. ($afterDiscountPrice+0) .'</span>
            <small class="text-danger" style="font-size:18px !important;">'. $discount .'% off</small>
            ';
  }
  $str .= '</p>';
  return $str;
  
}

public static function sportIntensityArr(){
  return [
    'High',
    'Moderate',
    'Low',
    'High To Moderate',
    'Low To Moderate',
    'Moderate To High',
  ];
}

public static function intensityColors($key=null){
  $arr =  [
    'High' => '#FF0000',
    'Moderate' => '#FFA500',
    'Low' => '#32CD32',
    'High To Moderate' => '#FF4500',
    'Low To Moderate' => '#ADFF2F',
    'Moderate To High' => '#FF7F50',
  ];
  return isset($arr[$key]) ? $arr[$key] : "#FFFFFF";
}

public static function sessionColors($key){
  $colors = [
      0 => '#FF4500',  // Bright Red-Orange
      1 => '#FFA500',  // Orange
      2 => '#32CD32',  // Lime Green
      3 => '#FF6347',  // Tomato Red
      4 => '#9ACD32',  // Yellow-Green
      5 => '#FF7F50',  // Coral
      6 => '#00CED1',  // Dark Turquoise
      7 => '#4682B4',  // Steel Blue
      8 => '#9370DB',  // Medium Purple
      9 => '#DA70D6',  // Orchid
      10 => '#FFD700', // Gold
      11 => '#FF69B4', // Hot Pink
      12 => '#FF4500', // Orange Red
      13 => '#8A2BE2', // Blue Violet
      14 => '#5F9EA0', // Cadet Blue
      15 => '#20B2AA', // Light Sea Green
      16 => '#7FFF00', // Chartreuse
      17 => '#FF1493', // Deep Pink
      18 => '#FF6347', // Tomato Red (repeated)
      19 => '#9400D3', // Dark Violet
      20 => '#00FF7F'  // Spring Green
  ];
  return isset($colors[$key]) ? $colors[$key] : $colors[array_rand($colors)];
}




public static function caloriesArr()
{
  return ["400-500", "500-700", "600-900", "500-700", "400-600", "300-400", "350-500", "700-900", "450-750", "600-1000", "400-600", "350-500", "250-400", "500-700", "600-800", "500-700", "300-450", "250-400", "200-400", "300-500", "400-600", "250-400", "700-900", "400-600", "400-600", "600-900", "300-500", "200-300", "200-300", "600-800"];

}

public static function packageDurationTypes()
{
  return ["Weeks", "Months", "Years"];
}

}
