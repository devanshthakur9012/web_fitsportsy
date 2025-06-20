<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Event;
use App\Models\User;
use App\Models\Review;
use App\Models\Ticket;
use App\Models\Coupon;
use App\Models\Tax;
use App\Models\OrderTax;
use App\Models\AppUser;
use App\Models\Category;
use App\Models\Blog;
use App\Models\Faq;
use Twilio\Rest\Client;
use App\Models\Order;
use App\Models\Setting;
use App\Models\PaymentSetting;
use App\Models\NotificationTemplate;
use App\Models\EventReport;
use App\Models\OrderChild;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use OneSignal;
use Stripe;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Rave;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Mail\ResetPassword;
use App\Mail\TicketBook;
use App\Mail\TicketBookOrg;
use App\Models\Language;
use App\Http\Controllers\FaqController;
use App\Models\Banner;
use App\Models\ContactUs;
use App\Models\Country;
use App\Models\Product;
use App\Models\Popups;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Guard;
use Illuminate\Auth\Events\Registered;
use Throwable;
use App\Helpers\Common;
use App\Models\EventDescription;

class FrontendController extends Controller
{

    // public function generatQrFlex(){
    //     $qrimage = "https://app.fitsportsy.in/images/qr/207.png";
    //     $bannerImage = "https://app.fitsportsy.in/images/sample-qr-holding.png";
    //     $sponsreName = "Sample Name";

    //     $data = [
    //         'qrimage' => $qrimage,
    //         'bannerImage' => $bannerImage,
    //         'sponsreName' => $sponsreName,
    //     ];

    //     return view('home.generate-qr', $data);
    // }


    public function home()
    {
        
            $setting = Common::siteGeneralSettings();
            SEOMeta::setTitle($setting->app_name . ' - Home' ?? env('APP_NAME'))
                ->setDescription('This is home page')
                ->setCanonical(url()->current())
                ->addKeyword(['home page', $setting->app_name, $setting->app_name . ' Home']);

            OpenGraph::setTitle($setting->app_name . ' - Home' ?? env('APP_NAME'))
                ->setDescription('This is home page')
                ->setUrl(url()->current());
            JsonLdMulti::setTitle($setting->app_name . ' - Home' ?? env('APP_NAME'));
            JsonLdMulti::setDescription('This is home page');
            JsonLdMulti::addImage($setting->logo ? url('images/upload/' . $setting->logo) : asset('/images/logo.png'));

            SEOTools::setTitle($setting->app_name . ' - Home' ?? env('APP_NAME'));
            SEOTools::setDescription('This is home page');
            SEOTools::opengraph()->setUrl(url()->current());
            SEOTools::setCanonical(url()->current());
            SEOTools::jsonLd()->addImage($setting->logo ? url('images/upload/' . $setting->logo) : asset('/images/logo.png'));
            $timezone = $setting->timezone;
            $selectedCity = \Session::has('CURR_CITY') ? \Session::get('CURR_CITY') : 'All';
            $date = Carbon::now($timezone);
            $category = Category::select('id','name','slug','image','banner_image','redirect_link')->with(['events'=>function($query) use($date,$selectedCity){
                $query->select('events.name as name','events.id','category_id','events.image','temple_name','t.price','t.discount_type','t.discount_amount')->where([['events.status', 1], ['events.is_deleted', 0], ['event_status', 'Pending']])->where(function($q) use($date){
                    $q->where('events.end_time', '>', $date->format('Y-m-d H:i:s'))->orWhereIn('event_type',[2,3]);
                });
                if($selectedCity!='All'){
                    $query->where('city_name',$selectedCity);
                }
                $query->leftJoin('tickets as t','t.event_id','events.id');
                $query->orderBy('event_type','ASC')->orderBy('events.start_time', 'desc')->groupBy('events.id')->take(10);
            }])->where('status', 1)->orderBy('order_num', 'ASC')->get();
            $blog = Blog::select('title','description','image','id')->where('status', 1)->orderBy('id', 'DESC')->limit(10)->get();
            $banner = Banner::select('title','description','image','redirect_link')->where('status', 1)->get();
            $products = Product::select('image','product_name','product_price','rating','product_slug','quantity')->where('status',1)->inRandomOrder()->limit(10)->get();
            // $user = Auth::guard('appuser')->user();

            $cityName = session()->get('CURR_CITY');
            if($cityName != 'All'){
                $popup = Popups::Where('city',$cityName)->orderBy('id','DESC')->first();
            }else{
                $popup = "";
            }

            return view('frontend.home', compact('category', 'blog', 'banner','products','popup'));
        
    }
    public function login()
    {

        $setting = Setting::first(['app_name', 'logo']);
        SEOMeta::setTitle($setting->app_name . ' - Login' ?? env('APP_NAME'))
            ->setDescription('This is login page')
            ->setCanonical(url()->current())
            ->addKeyword(['login page', $setting->app_name, $setting->app_name . ' Login', 'sign-in page', $setting->app_name . ' sign-in']);

        OpenGraph::setTitle($setting->app_name . ' - Login' ?? env('APP_NAME'))
            ->setDescription('This is login page')
            ->setUrl(url()->current());

        JsonLdMulti::setTitle($setting->app_name . ' - Login' ?? env('APP_NAME'));
        JsonLdMulti::setDescription('This is login page');
        JsonLdMulti::addImage($setting->imagePath . $setting->logo);

        SEOTools::setTitle($setting->app_name . ' - Login' ?? env('APP_NAME'));
        SEOTools::setDescription('This is login page');
        SEOTools::opengraph()->addProperty(
            'keywords',
            [
                'login page', $setting->app_name, $setting->app_name . ' Login',
                'sign-in page', $setting->app_name . ' sign-in'
            ]
        );
        SEOTools::opengraph()->addProperty('image', $setting->imagePath . $setting->logo);
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(url()->current());
        SEOTools::jsonLd()->addImage($setting->imagePath . $setting->logo);
        return view('frontend.auth.login');
    }
    public function userLogin(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required',
        ]);

        $userdata = array(
            'email' => $request->email,
            'password' => $request->password,
        );
        $remember = $request->get('remember');
        if ($request->type == 'user') {
            if (Auth::guard('appuser')->attempt($userdata, $remember)) {
                $user =  Auth::guard('appuser')->user();
                $setting = Setting::first(['app_name', 'logo']);
                if(!$setting->user_verify) {
                    return redirect('/');
                } else {
                    if (!$user->is_verify) {
                        $details = [
                            'id' => $user->id,
                        ];
                        Mail::to($user->email)->send(new \App\Mail\VerifyMail($details));
                        return redirect('user/login')->with(['checkMail' => "Verification link has been sent to your email. Please visit that link to complete the verification"]);
                    }
                }
                $this->setLanguage($user);
            } else {
                return Redirect::back()->with('error_msg', 'Invalid Username or Password.');
            }
        }
        if ($request->type == 'org') {
            if (Auth::attempt($userdata, $remember)) {
                if (Auth::user()->hasRole('Organizer')) {
                    if (Auth::user()->status == 1) {
                        $this->setLanguage(Auth::user());
                        return redirect('organization/home');
                    } else {
                        return "hello";
                        return Redirect::back();
                    }
                } else {
                    Auth::logout();
                    return Redirect::back()->with('error_msg', 'Only authorized person can login.');
                }
            } else {
                return Redirect::back()->with('error_msg', 'Invalid Username or Password.');
            }
        }
    }

    public function userLogout(Request $request)
    {
        if (Auth::guard('appuser')->check()) {
            Auth::guard('appuser')->logout();
            return redirect('/');
        }
    }
    public function register()
    {
        $setting = Setting::first(['app_name', 'logo']);

        SEOMeta::setTitle($setting->app_name . ' - Register' ?? env('APP_NAME'))
            ->setDescription('This is register page')
            ->setCanonical(url()->current())
            ->addKeyword([
                'register page', $setting->app_name, $setting->app_name . ' Register',
                'sign-up page', $setting->app_name . ' sign-up'
            ]);

        OpenGraph::setTitle($setting->app_name . ' - Register' ?? env('APP_NAME'))
            ->setDescription('This is register page')
            ->setUrl(url()->current());

        JsonLdMulti::setTitle($setting->app_name . ' - Register' ?? env('APP_NAME'));
        JsonLdMulti::setDescription('This is register page');
        JsonLdMulti::addImage($setting->imagePath . $setting->logo);

        SEOTools::setTitle($setting->app_name . ' - Register' ?? env('APP_NAME'));
        SEOTools::setDescription('This is register page');
        SEOTools::opengraph()->addProperty(
            'keywords',
            [
                'register page', $setting->app_name,
                $setting->app_name . ' Register',
                'sign-up page', $setting->app_name . ' sign-up'
            ]
        );
        SEOTools::opengraph()->addProperty('image', $setting->imagePath . $setting->logo);
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(url()->current());
        SEOTools::jsonLd()->addImage($setting->imagePath . $setting->logo);
        $logo = Setting::find(1)->logo;
        $phone = Country::get();
        return view('frontend.auth.register', compact('logo', 'phone'));
    }
    public function userRegister(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'last_name' => 'bail|required',
            'email' => 'bail|required|email|unique:app_user',
            'phone' => 'bail|required|numeric',
            'password' => 'bail|required|min:6',
            'Countrycode' => 'bail|required',
        ]);
        $verify = Setting::first()->user_verify == 1 ? 0 : 1;
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['image'] = "defaultuser.png";
        $data['status'] = 1;
        $data['provider'] = "LOCAL";
        $data['language'] = Setting::first()->language;
        $data['phone'] = "+" . $request->Countrycode . $request->phone;
        $data['is_verify'] = $verify;
        if ($data['user_type'] == 'organizer') {
            $user = User::create($data);
            $user->assignRole('Organizer');
        } else {
            $user = AppUser::create($data);
        }
        if ($user->is_verify == 0) {
            $details = [
                'id' => $user->id,
            ];
            // Mail::to($user->email)->send(new \App\Mail\VerifyMail($details));
            return redirect('user/login')->with(['checkMail' => "Verification link has been sent to your email. Please visit that link to complete the verification"]);
        }
        return redirect('user/login')->with(['checkMail' => "Congratulations! Your account registration was successful. You can now log in to your account and start using our services. Thank you for choosing our platform"]);
    }
    public function LoginByMail($id)
    {
        $user = AppUser::find($id);
        if (Auth::guard('appuser')->loginUsingId($id)) {
            $user =  Auth::guard('appuser')->user();
            $verify = AppUser::find($user->id);
            $verify->email_verified_at = Carbon::now();
            $verify->is_verify = 1;
            $verify->update();
            $this->setLanguage($user);
            return redirect('/');
        }
    }

    public function orgForgetPass(Request $req){
        $setting = Setting::first(['app_name', 'logo']);
        SEOMeta::setTitle($setting->app_name . ' - reset password' ?? env('APP_NAME'))
            ->setDescription('This is reset password page')
            ->setCanonical(url()->current())
            ->addKeyword([
                'reset password page', $setting->app_name, $setting->app_name . ' reset password',
                'forgot password page', $setting->app_name . ' forgot password'
            ]);

        OpenGraph::setTitle($setting->app_name . ' - reset password' ?? env('APP_NAME'))
            ->setDescription('This is reset password page')
            ->setUrl(url()->current());

        JsonLdMulti::setTitle($setting->app_name . ' - reset password' ?? env('APP_NAME'));
        JsonLdMulti::setDescription('This is reset password page');
        JsonLdMulti::addImage($setting->imagePath . $setting->logo);

        SEOTools::setTitle($setting->app_name . ' - reset password' ?? env('APP_NAME'));
        SEOTools::setDescription('This is reset password page');
        SEOTools::opengraph()->addProperty(
            'keywords',
            [
                'reset password page', $setting->app_name,
                $setting->app_name . ' reset password',
                'forgot password page', $setting->app_name . ' forgot password'
            ]
        );
        SEOTools::opengraph()->addProperty('image', $setting->imagePath . $setting->logo);
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(url()->current());
        SEOTools::jsonLd()->addImage($setting->imagePath . $setting->logo);
        return view('frontend.auth.forgot-password');
    }

    public function postOrgForgetPass(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        $password = rand(100000, 999999);

        if ($user) {
            $content = NotificationTemplate::where('title', 'Reset Password')->first()->mail_content;
            $detail['user_name'] = $user->name;
            $detail['password'] = $password;
            $detail['app_name'] = Setting::find(1)->app_name;
            $user->update(['password' => Hash::make($password)]);

            try {
                Mail::to($user->email)->send(new ResetPassword($content, $detail));
            } catch (\Throwable $th) {
                Log::info($th->getMessage());
            }
            return Redirect::back()->with('success', 'New password will send in your mail, please check it.');
        } else {
            return Redirect::back()->with('warning', 'Invalid Email Id, Please try another.');
        }
        
    }


    public function resetPassword()
    {
        $setting = Setting::first(['app_name', 'logo']);
        SEOMeta::setTitle($setting->app_name . ' - reset password' ?? env('APP_NAME'))
            ->setDescription('This is reset password page')
            ->setCanonical(url()->current())
            ->addKeyword([
                'reset password page', $setting->app_name, $setting->app_name . ' reset password',
                'forgot password page', $setting->app_name . ' forgot password'
            ]);

        OpenGraph::setTitle($setting->app_name . ' - reset password' ?? env('APP_NAME'))
            ->setDescription('This is reset password page')
            ->setUrl(url()->current());

        JsonLdMulti::setTitle($setting->app_name . ' - reset password' ?? env('APP_NAME'));
        JsonLdMulti::setDescription('This is reset password page');
        JsonLdMulti::addImage($setting->imagePath . $setting->logo);

        SEOTools::setTitle($setting->app_name . ' - reset password' ?? env('APP_NAME'));
        SEOTools::setDescription('This is reset password page');
        SEOTools::opengraph()->addProperty(
            'keywords',
            [
                'reset password page', $setting->app_name,
                $setting->app_name . ' reset password',
                'forgot password page', $setting->app_name . ' forgot password'
            ]
        );
        SEOTools::opengraph()->addProperty('image', $setting->imagePath . $setting->logo);
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(url()->current());
        SEOTools::jsonLd()->addImage($setting->imagePath . $setting->logo);
        return view('frontend.auth.resetPassword');
    }

    public function userResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
        ]);
        if ($request->logintype == 1) {
            $user = AppUser::where('email', $request->email)->first();
        } else {
            $user = User::where('email', $request->email)->first();
        }
        $password = rand(100000, 999999);
        if ($user) {
            $content = NotificationTemplate::where('title', 'Reset Password')->first()->mail_content;
            $detail['user_name'] = $user->name;
            $detail['password'] = $password;
            $detail['app_name'] = Setting::find(1)->app_name;
            $user->update(['password' => Hash::make($password)]);

            try {
                Mail::to($user->email)->send(new ResetPassword($content, $detail));
            } catch (\Throwable $th) {
                // dd($th);
                Log::info($th->getMessage());
            }
            return Redirect::back()->with('success', 'New password will send in your mail, please check it.');
        } else {
            return Redirect::back()->with('warning', 'Invalid Email Id, Please try another.');
        }
    }

    public function orgRegister()
    {
        $setting = Setting::first(['app_name', 'logo']);

        SEOMeta::setTitle($setting->app_name . ' - Organizer Register' ?? env('APP_NAME'))
            ->setDescription('This is organizer register page')
            ->setCanonical(url()->current())
            ->addKeyword([
                'organizer register page', $setting->app_name, $setting->app_name . ' Organizer Register',
                'organizer sign-up page', $setting->app_name . ' organizer sign-up'
            ]);

        OpenGraph::setTitle($setting->app_name . ' - Organizer Register' ?? env('APP_NAME'))
            ->setDescription('This is organizer register page')
            ->setUrl(url()->current());

        JsonLdMulti::setTitle($setting->app_name . ' - Organizer Register' ?? env('APP_NAME'));
        JsonLdMulti::setDescription('This is organizer register page');
        JsonLdMulti::addImage($setting->imagePath . $setting->logo);

        SEOTools::setTitle($setting->app_name . ' - Organizer Register' ?? env('APP_NAME'));
        SEOTools::setDescription('This is register page');
        SEOTools::opengraph()->addProperty(
            'keywords',
            [
                'register page', $setting->app_name,
                $setting->app_name . ' Organizer Register',
                'organizer sign-up page', $setting->app_name . ' organizer sign-up'
            ]
        );
        SEOTools::opengraph()->addProperty('image', $setting->imagePath . $setting->logo);
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(url()->current());
        SEOTools::jsonLd()->addImage($setting->imagePath . $setting->logo);
        return view('frontend.auth.orgRegister');
    }

    public function organizerRegister(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'first_name' => 'bail|required',
            'last_name' => 'bail|required',
            'email' => 'bail|required|email|unique:users',
            'phone' => 'bail|required|numeric',
            'password' => 'bail|required|min:6',
            'confirm_password' => 'bail|required|min:6|same:password',
            'country' => 'bail|required',
        ]);
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['image'] = 'defaultuser.png';
        $data['language'] = Setting::first()->language;
        $user = User::create($data);
        $user->assignRole('Organizer');
        return redirect('login');
    }

    public function allEvents(Request $request)
    {
        (new AppHelper)->eventStatusChange();
        $setting = Setting::first(['app_name', 'logo']);

        SEOMeta::setTitle($setting->app_name . ' - All-Events' ?? env('APP_NAME'))
            ->setDescription('This is all events page')
            ->setCanonical(url()->current())
            ->addKeyword([
                'all event page',
                $setting->app_name,
                $setting->app_name . ' All-Events',
                'events page',
                $setting->app_name . ' Events',
            ]);

        OpenGraph::setTitle($setting->app_name . ' - All-Events' ?? env('APP_NAME'))
            ->setDescription('This is all events page')
            ->setUrl(url()->current());

        JsonLdMulti::setTitle($setting->app_name . ' - All-Events' ?? env('APP_NAME'));
        JsonLdMulti::setDescription('This is all events page');
        JsonLdMulti::addImage($setting->imagePath . $setting->logo);

        SEOTools::setTitle($setting->app_name . ' - All-Events' ?? env('APP_NAME'));
        SEOTools::setDescription('This is all events page');
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->addProperty('keywords', [
            'all event page',
            $setting->app_name,
            $setting->app_name . ' All-Events',
            'events page',
            $setting->app_name . ' Events',
        ]);
        SEOTools::jsonLd()->addImage($setting->imagePath . $setting->logo);

        $timezone = Setting::find(1)->timezone;
        $date = Carbon::now($timezone);
        $events  = Event::with(['category:id,name'])
            ->where([['status', 1], ['is_deleted', 0], ['event_status', 'Pending'], ['end_time', '>', $date->format('Y-m-d')]]);

        $chip = array();
        if ($request->has('type') && $request->type != null) {
            $chip['type'] = $request->type;
            $events = $events->where('type', $request->type);
        }
        if ($request->has('category') && $request->category != null) {
            $chip['category'] = Category::find($request->category)->name;
            $events = $events->where('category_id', $request->category);
        }
        if ($request->has('duration') && $request->duration != null) {
            $chip['date'] = $request->duration;
            if ($request->duration == 'Today') {
                $temp = Carbon::now($timezone)->format('Y-m-d');
                $events = $events->whereBetween('start_time', [$temp . ' 00:00:00', $temp . ' 23:59:59']);
            } else if ($request->duration == 'Tomorrow') {
                $temp = Carbon::tomorrow($timezone)->format('Y-m-d');
                $events = $events->whereBetween('start_time', [$temp . ' 00:00:00', $temp . ' 23:59:59']);
            } else if ($request->duration == 'ThisWeek') {
                $now = Carbon::now($timezone);
                $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i:s');
                $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i:s');
                $events = $events->whereBetween('start_time', [$weekStartDate, $weekEndDate]);
            } else if ($request->duration == 'date') {
                if (isset($request->date)) {
                    $temp = Carbon::parse($request->date)->format('Y-m-d H:i:s');
                    $events = $events->whereBetween('start_time', [$request->date . ' 00:00:00', $request->date . ' 23:59:59']);
                }
            }
        }
        $events = $events->orderBy('start_time', 'ASC')->get();
        foreach ($events as $value) {
            $value->total_ticket = Ticket::where([['event_id', $value->id], ['is_deleted', 0], ['status', 1]])->sum('quantity');
            $value->sold_ticket = Order::where('event_id', $value->id)->sum('quantity');
            $value->available_ticket = $value->total_ticket - $value->sold_ticket;
        }
        $user = Auth::guard('appuser')->user();
        $offlinecount = 0;
        $onlinecount = 0;
        foreach ($events as $key => $value) {
            if ($value->type == 'online') {
                $onlinecount += 1;
            }
            if ($value->type == 'offline') {
                $offlinecount += 1;
            }
        }

        return view('frontend.events', compact('user', 'events', 'chip', 'onlinecount', 'offlinecount'));
    }

    public function singleEventDetail()
    {
        // Fetch the event data or perform any necessary logic here
        $event = [
            'title' => 'Sample Event',
            'description' => 'This is a sample event description.',
            // Add more fields as needed
        ];

        // Pass the event data to the view
        return view('frontend.single-event-detail', compact('event'));
    }
    public function eventDetail($id, $name = null)
    {
        $setting = Common::siteGeneralSettings();
        $currency = $setting->currency_sybmol;
        $data = Event::select('id','category_id','user_id','name','event_type','age_group','bring_equipment','demo_session','description','tags','temple_name','address','event_description_id','venue_name','city_name','recurring_days','start_time','end_time','gallery','image','banner_img','session_plan','coaching_fee','time_slots')->with(['category:id,name,image','organization:id,first_name,name,bio,last_name,image'])->find($id);
        // dd($data);

        $eventDesc = EventDescription::select('amenities','sports_available')->where('id',$data->event_description_id)->first();

        $categoryId = $data->category_id;

        $imgOg = $data->image;
        if($data->gallery!=null){
            $imgarr = explode(',',$data->gallery);
            // $imgOg = $imgarr[0];
        }

        $desctSubstr = \Str::substr(strip_tags($data->description), 0, 250);
        SEOMeta::setTitle( $data->name.'-'.$data->temple_name)
            ->setDescription($desctSubstr)
            ->addMeta('event:category', $data->category->name, 'property')
            ->addKeyword([
                $setting->app_name,
                $data->name,
                $setting->app_name . ' - ' . $data->name,
                $data->category->name,
                $data->tags
        ]);

        OpenGraph::setTitle($data->name.'-'.$data->temple_name)
        ->setDescription($desctSubstr)
        ->setUrl(url()->current())
        ->addImage(asset('images/upload/'. $imgOg))
        ->setArticle([
            'start_time' => $data->created_at,
            'end_time' => $data->updated_at,
            'organization' => $data->organization->name,
            'catrgory' => $data->category->name,
            'type' => "offline",
            'address' => $data->address,
            'tag' => $data->tags,
        ]);

        

        TwitterCard::setType('summary_large_image');
        TwitterCard::setTitle($data->name.'-'.$data->temple_name);
        TwitterCard::setSite('@BookmyPujaSeva');
       
        TwitterCard::addValue('creator','@BookmyPujaSeva');
        TwitterCard::setUrl(url()->current());
        TwitterCard::setImage("asset('images/upload/'. $imgOg)");

        JsonLd::setTitle($data->name.'-'.$data->temple_name)
            ->setDescription($desctSubstr)
            ->setType('Article')
            ->addImage(asset('images/upload/'. $imgOg));

        SEOTools::setTitle($data->name.'-'.$data->temple_name);
        SEOTools::setDescription($desctSubstr);
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->addProperty('keywords', [
            $setting->app_name,
            $data->name,
            $setting->app_name . ' - ' . $data->name,
            $data->category->name,
            $data->tags
        ]);
        SEOTools::jsonLd()->addImage(asset('images/upload/'. $imgOg));
        if($data->event_type=='Particular'){
            $timezone = $setting->timezone;
            $date = Carbon::now($timezone);
            $data->ticket_data = Ticket::select('name','id','type','description','start_time','end_time','quantity','maximum_checkins','price','ticket_sold')->withSum('total_orders','quantity')->where([['event_id', $data->id], ['is_deleted', 0], ['status', 1], ['end_time', '>=', $date->format('Y-m-d H:i:s')], ['start_time', '<=', $date->format('Y-m-d H:i:s')]])->orderBy('id', 'DESC')->get();
        }else{
            $data->ticket_data = Ticket::select('name','id','type','description','start_time','end_time','quantity','maximum_checkins','price','ticket_sold','discount_type','discount_amount')->withSum('total_orders','quantity')->where([['event_id', $data->id], ['is_deleted', 0], ['status', 1]])->orderBy('id', 'DESC')->get();
        }
        $images = is_null($data->gallery) ? [] : json_decode($data->gallery);
        $date = date("Y-m-d H:i:s");
        $relatedEvents= Event::select('events.name as name','events.id','events.image','temple_name')->where([['events.status', 1], ['events.is_deleted', 0], ['event_status', 'Pending']])->where(function($q) use($date){
            $q->where('events.end_time', '>', $date)->orWhereIn('event_type',[2,3]);
        })->limit(10)->where('category_id',$categoryId)->where('events.id','!=',$id)->get();

        // dd($data);
        return view('frontend.eventDetail', compact('currency', 'data', 'images','relatedEvents','eventDesc'));
    }

    public function orgDetail($id, $name)
    {
        $setting = Setting::first(['app_name', 'logo']);
        $data = User::find($id);

        SEOMeta::setTitle($data->first_name . ' ' . $data->last_name)
            ->setDescription($data->bio)
            ->addKeyword([
                $setting->app_name,
                $data->name,
                $data->first_name . ' ' . $data->last_name,
            ]);

        OpenGraph::setTitle($data->first_name . ' ' . $data->last_name)
            ->setDescription($data->bio)
            ->setType('profile')
            ->setUrl(url()->current())
            ->addImage($data->imagePath . $data->image)
            ->setProfile([
                'first_name' => $data->first_name,
                'last_name' => $data->last_name,
                'username' => $data->name,
                'email' => $data->email,
                'bio' => $data->bio,
                'country' => $data->country,
            ]);

        JsonLd::setTitle($data->first_name . ' ' . $data->last_name)
            ->setDescription($data->bio)
            ->setType('Profile')
            ->addImage($data->imagePath . $data->image);

        SEOTools::setTitle($data->first_name . ' ' . $data->last_name);
        SEOTools::setDescription($data->bio);
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->addProperty('keywords', [
            $setting->app_name,
            $data->name,
            $data->first_name . ' ' . $data->last_name,
        ]);
        SEOTools::jsonLd()->addImage($setting->imagePath . $setting->logo);
        SEOTools::jsonLd()->addImage($data->imagePath . $data->image);

        $timezone = Setting::find(1)->timezone;
        $date = Carbon::now($timezone);
        $data->total_event = Event::where([['status', 1], ['is_deleted', 0], ['user_id', $id], ['event_status', 'Pending'], ['end_time', '>', $date->format('Y-m-d H:i:s')]])->count();
        $data->events = Event::where([['status', 1], ['is_deleted', 0], ['user_id', $id], ['event_status', 'Pending'], ['end_time', '>', $date->format('Y-m-d H:i:s')]])->orderBy('start_time', 'ASC')->get();
        return view('frontend.orgDetail', compact('data'));
    }

    public function reportEvent(Request $request)
    {
        $data = $request->all();
        if (Auth::guard('appuser')->check()) {
            $data['user_id'] = Auth::guard('appuser')->user()->id;
        }
        EventReport::create($data);
        return redirect()->back()->withStatus(__('Report is submitted successfully.'));
    }

    public function checkout(Request $request, $id)
    {

        $data = Ticket::find($id);
        $data->event = Event::find($data->event_id);

        $setting = Setting::first(['app_name', 'logo']);

        SEOMeta::setTitle($data->name)
            ->setDescription($data->description)
            ->addKeyword([
                $setting->app_name,
                $data->name,
                $data->event->name,
                $data->event->tags
            ]);

        OpenGraph::setTitle($data->name)
            ->setDescription($data->description)
            ->setUrl(url()->current());

        JsonLd::setTitle($data->name)
            ->setDescription($data->description);

        SEOTools::setTitle($data->name);
        SEOTools::setDescription($data->description);
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->addProperty('keywords', [
            $setting->app_name,
            $data->name,
            $data->event->name,
            $data->event->tags
        ]);
        SEOTools::jsonLd()->addImage($setting->imagePath . $setting->logo);

        $arr = [];
        $used = Order::where('ticket_id', $id)->sum('quantity');
        $data->available_qty = $data->quantity - $used;
        $data->tax = Tax::where([['allow_all_bill', 1], ['status', 1]])->orderBy('id', 'DESC')->get()->makeHidden(['created_at', 'updated_at']);
        foreach ($data->tax as $key => $item) {
            if ($item->amount_type == 'percentage') {

                $amount = ($item->price * $data->price) / 100;
                array_push($arr, $amount);
            }
            if ($item->amount_type == 'price') {
                $amount = $item->price;
                array_push($arr, $amount);
            }
        }
        $data->tax_total = array_sum($arr);
        $data->tax_total = round($data->tax_total,2);
        $data->currency_code = Setting::find(1)->currency;
        return view('frontend.checkout', compact('data'));
    }
    public function applyCoupon(Request $request)
    {
        $total = $request->total;
        $date = Carbon::now()->format('Y-m-d');
        $coupon = Coupon::where([['coupon_code', $request->coupon_code], ['status', 1], ['event_id', $request->event_id]])->first();
        if ($coupon) {
            if (Carbon::parse($date)->between(Carbon::parse($coupon->start_date), Carbon::parse($coupon->end_date))) {
                if ($coupon->max_use > $coupon->use_count) {
                    if ($total > $coupon->minimum_amount) {

                        if ($coupon->discount_type == 0) {
                            $discount = $total * ($coupon->discount / 100);
                        } else {
                            $discount = $coupon->discount;
                        }
                        if ($discount > $coupon->maximum_discount) {
                            $discount = $coupon->maximum_discount;
                        }
                        $subtotal = $total - $discount;

                        return response([
                            'success' => true, 'payableamount' => $discount, 'total_price' => $subtotal, 'total' => $total, 'discount' => $coupon->discount, 'coupon_id' => $coupon->id, 'coupon_type' => $coupon->discount_type
                        ]);
                    } else {
                        return response([
                            'success' => false,
                            'message' => 'Invalid amount.'
                        ]);
                    }
                } else {
                    return response([
                        'success' => false,
                        'message' => 'This coupon is reached max use!'
                    ]);
                }
            } else {
                return response([
                    'success' => false,
                    'message' => 'This coupon is expire!'
                ]);
            }
        } else {
            return response([
                'success' => false,
                'message' => 'Invalid Coupon code for this event!'
            ]);
        }
    }

    public function createOrder(Request $request)
    {

        $data = $request->all();
        $ticket = Ticket::findOrFail($request->ticket_id);
        if ($ticket->allday == 0) {
            $request->validate([
                'ticket_date' => 'bail|required',
            ]);
        }
        $event = Event::find($ticket->event_id);

        $org = User::find($event->user_id);
        $user = AppUser::find(Auth::guard('appuser')->user()->id);
        $data['order_id'] = '#' . rand(9999, 100000);
        $data['event_id'] = $event->id;
        $data['customer_id'] = $user->id;
        $data['organization_id'] = $org->id;
        $data['order_status'] = 'Pending';


        if ($request->coupon_code != null) {
            $data['payment'] = $request->subtotal;
        } else {
            $data['payment'] = $request->payment;
        }
        if ($request->payment_type == 'LOCAL') {
            $data['payment_status'] = 0;
        } else {
            $data['payment_status'] = 1;
        }


        $com = Setting::find(1, ['org_commission_type', 'org_commission']);
        $p =   $request->payment - $request->tax;
        if ($request->payment_type == "FREE") {
            $data['org_commission']  = 0;
        } else {
            if ($com->org_commission_type == "percentage") {
                $data['org_commission'] =  $p * $com->org_commission / 100;
            } else if ($com->org_commission_type == "amount") {
                $data['org_commission']  = $com->org_commission;
            }
        }
        if ($request->payment_type == "STRIPE") {
            $currency_code = Setting::first()->currency;
            $stripe_payment = $currency_code == "USD" || $currency_code == "EUR" || $currency_code == "INR" ? $request->payment * 100 : $request->payment;

            $cur = Setting::find(1)->currency;
            $stripe_secret =  PaymentSetting::find(1)->stripeSecretKey;

            Stripe\Stripe::setApiKey($stripe_secret);
            $token = $_POST['stripeToken'];
            $stripeDetail =  Stripe\PaymentIntent::create([
                "amount" => $stripe_payment,
                "currency" => $cur,

            ]);
            $data['payment_token'] = $stripeDetail->id;
        }

        if ($request->coupon_id != null) {
            $count = Coupon::find($request->coupon_id)->use_count;
            $count = $count + 1;
            Coupon::find($request->coupon_id)->update(['use_count' => $count]);
        }


        $order = Order::create($data);
        for ($i = 1; $i <= $request->quantity; $i++) {
            $child['ticket_number'] = uniqid();
            $child['ticket_id'] = $request->ticket_id;
            $child['order_id'] = $order->id;
            $child['customer_id'] = Auth::guard('appuser')->user()->id;

            OrderChild::create($child);
        }

        if (isset($request->tax_data)) {

            foreach (json_decode($data['tax_data']) as $value) {

                $tax['order_id'] = $order->id;
                $tax['tax_id'] = $value->id;
                $tax['price'] = $value->price;
                OrderTax::create($tax);
            }
        }

        $user = AppUser::find($order->customer_id);
        $setting = Setting::find(1);

        // for user notification
        $message = NotificationTemplate::where('title', 'Book Coaching')->first()->message_content;
        $detail['user_name'] = $user->name . ' ' . $user->last_name;
        $detail['quantity'] = $request->quantity;
        $detail['event_name'] = Event::find($order->event_id)->name;
        $detail['date'] = Event::find($order->event_id)->start_time->format('d F Y h:i a');
        $detail['app_name'] = $setting->app_name;
        $noti_data = ["{{user_name}}", "{{quantity}}", "{{event_name}}", "{{date}}", "{{app_name}}"];
        $message1 = str_replace($noti_data, $detail, $message);
        $notification = array();
        $notification['organizer_id'] = null;
        $notification['user_id'] = $user->id;
        $notification['order_id'] = $order->id;
        $notification['title'] = 'Ticket Booked';
        $notification['message'] = $message1;
        Notification::create($notification);
        if ($setting->push_notification == 1) {
            if ($user->device_token != null) {
                (new AppHelper)->sendOneSignal('user', $user->device_token, $message1);
            }
        }
        // for user sms
        //  if ($setting->sms_notification == 1) {
        //     $twilio = new Client($setting->twilio_account_id, $setting->twilio_auth_token);
        //     $twilio->messages->create($user->phone, [
        //         'from' => $setting->twillio_phone_number,
        //         'body' => 'Hello, this is a test message from Laravel.'
        //     ]);
        // }

        // for user mail
        $ticket_book = NotificationTemplate::where('title', 'Book Coaching')->first();
        $details['user_name'] = $user->name . ' ' . $user->last_name;
        $details['quantity'] = $request->quantity;
        $details['event_name'] = Event::find($order->event_id)->name;
        $details['date'] = Event::find($order->event_id)->start_time->format('d F Y h:i a');
        $details['app_name'] = $setting->app_name;
        if ($setting->mail_notification == 1) {

            try {
                $qrcode = $order->order_id;
                Mail::to($user->email)->send(new TicketBook($ticket_book->mail_content, $details, $ticket_book->subject, $qrcode));
            } catch (\Throwable $th) {
                Log::info($th->getMessage());
            }
        }

        // for Organizer notification
        $org =  User::find($order->organization_id);
        $or_message = NotificationTemplate::where('title', 'Organizer Book Coaching')->first()->message_content;
        $or_detail['organizer_name'] = $org->first_name . ' ' . $org->last_name;
        $or_detail['user_name'] = $user->name . ' ' . $user->last_name;
        $or_detail['quantity'] = $request->quantity;
        $or_detail['event_name'] = Event::find($order->event_id)->name;
        $or_detail['date'] = Event::find($order->event_id)->start_time->format('d F Y h:i a');
        $or_detail['app_name'] = $setting->app_name;
        $or_noti_data = ["{{organizer_name}}", "{{user_name}}", "{{quantity}}", "{{event_name}}", "{{date}}", "{{app_name}}"];
        $or_message1 = str_replace($or_noti_data, $or_detail, $or_message);
        $or_notification = array();
        $or_notification['organizer_id'] =  $org->id;
        $or_notification['user_id'] = null;
        $or_notification['order_id'] = $order->id;
        $or_notification['title'] = 'New Ticket Booked';
        $or_notification['message'] = $or_message1;
        Notification::create($or_notification);
        if ($setting->push_notification == 1) {
            if ($org->device_token != null) {
                (new AppHelper)->sendOneSignal('organizer', $org->device_token, $or_message1);
            }
        }
        // for Organizer mail
        $new_ticket = NotificationTemplate::where('title', 'Organizer Book Coaching')->first();
        $details1['organizer_name'] = $org->first_name . ' ' . $org->last_name;
        $details1['user_name'] = $user->name . ' ' . $user->last_name;
        $details1['quantity'] = $request->quantity;
        $details1['event_name'] = Event::find($order->event_id)->name;
        $details1['date'] = Event::find($order->event_id)->start_time->format('d F Y h:i a');
        $details1['app_name'] = $setting->app_name;
        if ($setting->mail_notification == 1) {
            try {
                Mail::to($org->email)->send(new TicketBookOrg($new_ticket->mail_content, $details1, $new_ticket->subject));
            } catch (\Throwable $th) {
                Log::info($th->getMessage());
            }
        }
        return redirect('my-tickets');
    }

    public function categoryEvents($id, $name)
    {
        $setting = Setting::first(['app_name', 'logo']);
        $category = Category::find($id);

        SEOMeta::setTitle($setting->app_name . '- Events' ?? env('APP_NAME'))
            ->setDescription('This is category events page')
            ->setCanonical(url()->current())
            ->addKeyword([
                'category event page',
                $category->name . ' - Events',
                $setting->app_name,
                $setting->app_name . ' Events',
                'events page',
            ]);

        OpenGraph::setTitle($setting->app_name . ' - Events' ?? env('APP_NAME'))
            ->setDescription('This is category events page')
            ->setUrl(url()->current());

        JsonLdMulti::setTitle($setting->app_name . ' - Events' ?? env('APP_NAME'));
        JsonLdMulti::setDescription('This is category events page');
        JsonLdMulti::addImage($setting->imagePath . $setting->logo);

        SEOTools::setTitle($setting->app_name . ' - Events' ?? env('APP_NAME'));
        SEOTools::setDescription('This is category events page');
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->addProperty('keywords', [
            'category event page',
            $category->name . ' - Events',
            $setting->app_name,
            $setting->app_name . ' Events',
            'events page',
        ]);
        SEOTools::jsonLd()->addImage($setting->imagePath . $setting->logo);

        $timezone = Setting::find(1)->timezone;
        $date = Carbon::now($timezone);
        $events  = Event::with(['category:id,name'])
            ->where([['status', 1], ['is_deleted', 0], ['category_id', $id], ['event_status', 'Pending'], ['end_time', '>', $date->format('Y-m-d H:i:s')]])
            ->orderBy('start_time', 'ASC')->get();
        $offlinecount = 0;
        $onlinecount = 0;
        foreach ($events as $key => $value) {
            if ($value->type == 'online') {
                $onlinecount += 1;
            }
            if ($value->type == 'offline') {
                $offlinecount += 1;
            }
        }
        $user = Auth::guard('appuser')->user();
        $catactive = $name;
        return view('frontend.events', compact('events', 'category', 'onlinecount', 'offlinecount', 'user', 'catactive'));
    }

    public function eventType($type)
    {
        $setting = Setting::first(['app_name', 'logo']);

        SEOMeta::setTitle($setting->app_name . ' - All-Events' ?? env('APP_NAME'))
            ->setDescription('This is all events page')
            ->setCanonical(url()->current())
            ->addKeyword([
                'all event page',
                $setting->app_name,
                $setting->app_name . ' All-Events',
                'events page',
                $setting->app_name . ' Events',
            ]);

        OpenGraph::setTitle($setting->app_name . ' - All-Events' ?? env('APP_NAME'))
            ->setDescription('This is all events page')
            ->setUrl(url()->current());

        JsonLdMulti::setTitle($setting->app_name . ' - All-Events' ?? env('APP_NAME'));
        JsonLdMulti::setDescription('This is all events page');
        JsonLdMulti::addImage($setting->imagePath . $setting->logo);

        SEOTools::setTitle($setting->app_name . ' - All-Events' ?? env('APP_NAME'));
        SEOTools::setDescription('This is all events page');
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->addProperty('keywords', [
            'all event page',
            $setting->app_name,
            $setting->app_name . ' All-Events',
            'events page',
            $setting->app_name . ' Events',
        ]);
        SEOTools::jsonLd()->addImage($setting->imagePath . $setting->logo);


        $timezone = Setting::find(1)->timezone;
        $date = Carbon::now($timezone);
        if ($type == "all") {
            $events  = Event::with(['category:id,name'])
                ->where([['status', 1], ['is_deleted', 0], ['event_status', 'Pending'], ['end_time', '>', $date->format('Y-m-d H:i:s')]])
                ->orderBy('start_time', 'ASC')->get();

            return view('frontend.events', compact('events'));
        } else {
            $events  = Event::with(['category:id,name'])
                ->where([['status', 1], ['is_deleted', 0], ['event_status', 'Pending'], ['type', $type], ['end_time', '>', $date->format('Y-m-d H:i:s')]])
                ->orderBy('start_time', 'ASC')->get();
            return view('frontend.events', compact('events', 'type'));
        }
    }

    public function allCategory()
    {
        $setting = Setting::first(['app_name', 'logo']);

        SEOMeta::setTitle($setting->app_name . ' - Category' ?? env('APP_NAME'))
            ->setDescription('This is all category page')
            ->setCanonical(url()->current())
            ->addKeyword([
                'all event page',
                $setting->app_name,
                $setting->app_name . ' Category',
                'category page',
                $setting->app_name . ' category',
            ]);

        OpenGraph::setTitle($setting->app_name . ' - Category' ?? env('APP_NAME'))
            ->setDescription('This is all category page')
            ->setUrl(url()->current());

        JsonLdMulti::setTitle($setting->app_name . ' - Category' ?? env('APP_NAME'));
        JsonLdMulti::setDescription('This is all category page');
        JsonLdMulti::addImage($setting->imagePath . $setting->logo);

        SEOTools::setTitle($setting->app_name . ' - Category' ?? env('APP_NAME'));
        SEOTools::setDescription('This is all category page');
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->addProperty('keywords', [
            'all event page',
            $setting->app_name,
            $setting->app_name . ' Category',
            'category page',
            $setting->app_name . ' category',
        ]);
        SEOTools::jsonLd()->addImage($setting->imagePath . $setting->logo);
        $data = Category::where('status', 1)->orderBy('id', 'DESC')->get();
        $catactive = 'all';

        return view('frontend.allCategory', compact('data', 'catactive'));
    }

    public function blogs()
    {
        $blogs = Blog::where('status', 1)->orderBy('id', 'DESC')->paginate(20);
        $category = [];
        $setting = Common::siteGeneralSettings();;
        SEOMeta::setTitle($setting->app_name . ' - Blogs' ?? env('APP_NAME'))
            ->setDescription('This is blogs page')
            ->setCanonical(url()->current())
            ->addKeyword([
                'blogs page',
                $setting->app_name,
                $setting->app_name . ' Blogs',
                'blog page',
            ]);
        OpenGraph::setDescription('This is blogs page');
        OpenGraph::setTitle($setting->app_name . ' - Blogs' ?? env('APP_NAME'));
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'blogs');
        JsonLd::setTitle($setting->app_name . ' - Blogs' ?? env('APP_NAME'));
        JsonLd::setDescription('This is blogs page');
        JsonLd::addImage($setting->imagePath . $setting->logo);
        SEOTools::setTitle($setting->app_name . ' - Blogs' ?? env('APP_NAME'));
        SEOTools::setDescription('This is blogs page');
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->addProperty('type', 'blogs');
        $user = Auth::guard('appuser')->user();
        return view('frontend.blog', compact('blogs', 'category', 'user'));
    }

    public function blogDetail($id, $name)
    {
        $setting = Setting::first(['app_name', 'logo']);

        $data = Blog::find($id);
        $data->category = Category::find($data->category_id);
        $tags = explode(',', $data->tags);
        SEOMeta::setTitle($data->title);
        SEOMeta::setDescription($data->description);
        SEOMeta::addMeta('blog:published_time', $data->created_at->toW3CString(), 'property');
        SEOMeta::addMeta('blog:category', $data->category->name, 'property');
        SEOMeta::addKeyword($data->tags);

        OpenGraph::setTitle($data->title)
            ->setDescription($data->description)
            ->setType('blog')
            ->addImage($data->imagePath . $data->image)
            ->setArticle([
                'published_time' => $data->created_at,
                'modified_time' => $data->updated_at,
                'section' => $data->category->name,
                'tag' => $data->tags
            ]);

        JsonLd::setTitle($data->title);
        JsonLd::setDescription($data->description);
        JsonLd::setType('Blog');
        JsonLd::addImage($data->imagePath . $data->image);
        $user = Auth::guard('appuser')->user();

        return view('frontend.blogDetail', compact('data', 'tags', 'user'));
    }

    public function profile()
    {
        $user = Auth::guard('appuser')->user();
        $setting = Setting::first(['app_name', 'logo']);

        SEOMeta::setTitle('User Profile')
            ->setDescription('This is user profile page')
            ->addKeyword([
                $setting->app_name,
                $user->name,
                $user->name . ' ' . $user->last_name,
            ]);

        OpenGraph::setTitle('User Profile')
            ->setDescription('This is user profile page')
            ->setType('profile')
            ->setUrl(url()->current())
            ->addImage($user->imagePath . $user->image)
            ->setProfile([
                'first_name' => $user->name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'bio' => $user->bio,
                'country' => $user->country,
            ]);

        JsonLd::setTitle('User Profile' ?? env('APP_NAME'))
            ->setDescription('This is user profile page')
            ->setType('Profile')
            ->addImage($user->imagePath . $user->image);

        SEOTools::setTitle('User Profile' ?? env('APP_NAME'));
        SEOTools::setDescription('This is user profile page');
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->addProperty('keywords', [
            $setting->app_name,
            $user->name,
            $user->name . ' ' . $user->last_name,
        ]);
        SEOTools::jsonLd()->addImage($setting->imagePath . $setting->logo);
        SEOTools::jsonLd()->addImage($user->imagePath . $user->image);

        $user->saved_event = Event::whereIn('id', array_filter(explode(',', $user->favorite)))->where([['status', 1], ['is_deleted', 0]])->get();
        $user->saved_blog = Blog::whereIn('id', array_filter(explode(',', $user->favorite_blog)))->where('status', 1)->get();
        $user->following = User::whereIn('id', array_filter(explode(',', $user->following)))->get();
        foreach ($user->saved_event as $value) {
            $value->total_ticket = Ticket::where([['event_id', $value->id], ['is_deleted', 0], ['status', 1]])->sum('quantity');
            $value->sold_ticket = Order::where('event_id', $value->id)->sum('quantity');
            $value->available_ticket = $value->total_ticket - $value->sold_ticket;
        }
        return view('frontend.profile', compact('user'));
    }

    public function update_profile()
    {
        $user =  Auth::guard('appuser')->user();
        $phone = Country::get();
        $languages = Language::where('status', 1)->get();
        return view('frontend.user_profile', compact('user', 'languages', 'phone'));
    }

    public function update_user_profile(Request $request)
    {
        $data = $request->all();
        $user =  Auth::guard('appuser')->user();
        $user->update($data);
        $this->setLanguage($user);
        return redirect('/user/profile');
    }

    public function setLanguage($user)
    {
        $name = $user->language;
        if (!$name) {
            $name = 'English';
        }
        App::setLocale($name);
        session()->put('locale', $name);
        $direction = Language::where('name', $name)->first()->direction;
        session()->put('direction', $direction);
        return true;
    }

    public function addFavorite($id, $type)
    {
        $users = AppUser::find(Auth::guard('appuser')->user()->id);
        if ($type == "event") {
            $likes = array_filter(explode(',', $users->favorite));
            if (count(array_keys($likes, $id)) > 0) {
                if (($key = array_search($id, $likes)) !== false) {
                    unset($likes[$key]);
                }
                $msg = "Remove event from Favorite!";
            } else {
                array_push($likes, $id);
                $msg = "Add event in Favorite!";
            }
            $client = AppUser::find(Auth::guard('appuser')->user()->id);
            $client->favorite = implode(',', $likes);
        } else if ($type == "blog") {
            $likes = array_filter(explode(',', $users->favorite_blog));
            if (count(array_keys($likes, $id)) > 0) {
                if (($key = array_search($id, $likes)) !== false) {
                    unset($likes[$key]);
                }
                $msg = "Remove blog from Favorite!";
            } else {
                array_push($likes, $id);
                $msg = "Add blog in Favorite!";
            }
            $client = AppUser::find(Auth::guard('appuser')->user()->id);
            $client->favorite_blog = implode(',', $likes);
        }
        $client->update();
        return response()->json(['msg' => $msg, 'success' => true, 'type' => $type], 200);
    }

    public function addFollow($id)
    {
        $users = AppUser::find(Auth::guard('appuser')->user()->id);
        $likes = array_filter(explode(',', $users->following));
        if (count(array_keys($likes, $id)) > 0) {
            if (($key = array_search($id, $likes)) !== false) {
                unset($likes[$key]);
            }
            $msg = "Remove from following list!";
        } else {
            array_push($likes, $id);
            $msg = "Add in following!";
        }
        $client = AppUser::find(Auth::guard('appuser')->user()->id);
        $client->following = implode(',', $likes);
        $client->update();
        return response()->json(['msg' => $msg, 'success' => true], 200);
    }

    public function addBio(Request $request)
    {
        $success = AppUser::find(Auth::guard('appuser')->user()->id)->update(['bio' => $request->bio]);
        return response()->json(['data' => $request->bio, 'success' => $success], 200);
    }

    public function changePassword()
    {
        $setting = Setting::first(['app_name', 'logo']);

        SEOMeta::setTitle($setting->app_name . ' - Change Password' ?? env('APP_NAME'))
            ->setDescription('This is change password page')
            ->setCanonical(url()->current())
            ->addKeyword([
                'change password page',
                $setting->app_name,
                $setting->app_name . ' Change Password'
            ]);

        OpenGraph::setTitle($setting->app_name . ' - Change Password' ?? env('APP_NAME'))
            ->setDescription('This is change password page')
            ->setUrl(url()->current());

        JsonLdMulti::setTitle($setting->app_name . ' - Change Password' ?? env('APP_NAME'));
        JsonLdMulti::setDescription('This is change password page');
        JsonLdMulti::addImage($setting->imagePath . $setting->logo);

        SEOTools::setTitle($setting->app_name . ' - Change Password' ?? env('APP_NAME'));
        SEOTools::setDescription('This is change password page');
        SEOTools::opengraph()->addProperty('keywords', [
            'change password page',
            $setting->app_name,
            $setting->app_name . ' Change Password'
        ]);
        SEOTools::opengraph()->addProperty('image', $setting->imagePath . $setting->logo);
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(url()->current());
        SEOTools::jsonLd()->addImage($setting->imagePath . $setting->logo);

        return view('frontend.auth.changePassword');
    }

    public function changeUserPassword(Request $request)
    {
        $request->validate([
            'old_password' => 'bail|required',
            'password' => 'bail|required|min:6',
            'password_confirmation' => 'bail|required|same:password|min:6'
        ]);
        if (Hash::check($request->old_password, Auth::guard('appuser')->user()->password)) {
            AppUser::find(Auth::guard('appuser')->user()->id)->update(['password' => Hash::make($request->password)]);
            return redirect('user/profile')->withStatus(__('Password is changed successfully.'));
        } else {
            return Redirect::back()->with('error_msg', 'Current Password is wrong!');
        }
    }

    public function uploadProfileImage(Request $request)
    {
        $appuser = AppUser::find(Auth::guard('appuser')->user());
        if ($request->hasFile('image') != 'defaultuser.png') {
            (new AppHelper)->deleteFile($appuser->image);
            $imageName = (new AppHelper)->saveImage($request);
            AppUser::find(Auth::guard('appuser')->user()->id)->update(['image' => $imageName]);
        } else {
            $imageName = (new AppHelper)->saveImage($request);
            AppUser::find(Auth::guard('appuser')->user()->id)->update(['image' => $imageName]);
        }
        return response()->json(['data' => $imageName, 'success' => true], 200);
    }

    public function contact()
    {
        $setting = Common::siteGeneralSettings();
        $data = ContactUs::find(1);
        SEOMeta::setTitle($setting->app_name . ' - Contact Us' ?? env('APP_NAME'))
            ->setDescription('This is contact us page')
            ->setCanonical(url()->current())
            ->addKeyword([
                $setting->app_name,
                $setting->app_name . ' Contact Us',
                'contact us page',
            ]);

        OpenGraph::setTitle($setting->app_name . ' - Contact Us' ?? env('APP_NAME'))
            ->setDescription('This is contact us page')
            ->setUrl(url()->current());

        JsonLdMulti::setTitle($setting->app_name . ' - Contact Us' ?? env('APP_NAME'));
        JsonLdMulti::setDescription('This is contact us page');
        JsonLdMulti::addImage($setting->imagePath . $setting->logo);

        SEOTools::setTitle($setting->app_name . ' - Contact Us' ?? env('APP_NAME'));
        SEOTools::setDescription('This is contact us page');
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->addProperty('keywords', [
            $setting->app_name,
            $setting->app_name . ' Contact Us',
            'contact us page',
        ]);
        SEOTools::jsonLd()->addImage($setting->imagePath . $setting->logo);
        return view('frontend.contact', compact('data'));
    }

    public function userTickets()
    {

        $user = Auth::guard('appuser')->user();
        $setting = Setting::first(['app_name', 'logo', 'currency']);
        SEOMeta::setTitle('User Tickets')
            ->setDescription('This is user tickets page')
            ->addKeyword([
                $setting->app_name,
                $user->name,
                $user->name . ' ' . $user->last_name,
                $user->name . ' ' . $user->last_name . ' tickets',
            ]);

        OpenGraph::setTitle('User Tickets')
            ->setDescription('This is user tickets page')
            ->setUrl(url()->current())
            ->addImage($user->imagePath . $user->image);


        JsonLd::setTitle('User Tickets' ?? env('APP_NAME'))
            ->setDescription('This is user tickets page')
            ->addImage($user->imagePath . $user->image);

        SEOTools::setTitle('User Tickets' ?? env('APP_NAME'));
        SEOTools::setDescription('This is user tickets page');
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->addProperty('keywords', [
            $setting->app_name,
            $user->name,
            $user->name . ' ' . $user->last_name,
            $user->name . ' ' . $user->last_name . ' tickets',
        ]);
        SEOTools::jsonLd()->addImage($setting->imagePath . $setting->logo);
        SEOTools::jsonLd()->addImage($user->imagePath . $user->image);
        (new AppHelper)->eventStatusChange();
        $ordertax = array();
        $tax = array();

        $ticket['upcoming'] = Order::with(['event:id,name,image,start_time,type,end_time,address', 'ticket:id,ticket_number,start_time,name,price,type', 'organization:id,first_name,last_name,image'])
            ->where([['customer_id', Auth::guard('appuser')->user()->id], ['order_status', 'Pending']])
            ->orWhere([['customer_id', Auth::guard('appuser')->user()->id], ['order_status', 'Complete']])
            ->orderBy('id', 'DESC')->get();
        $event = [];

        if (count($ticket['upcoming']) > 0) {
            foreach ($ticket['upcoming'] as $events) {
                if ($events->event->start_time <= Carbon::now() && $events->event->end_time >= Carbon::now()) {
                    $event[] = $events;
                }
            }
            $ticket['upcoming']->event = $event;
        }

        $ordertax = array();
        $tax = array();
        foreach ($ticket['upcoming'] as $item) {
            $ordertaxs = OrderTax::where('order_id', $item->id)->get();
            $ordertax = $ordertaxs;
        }
        foreach ($ordertax as $item) {
            $taxs = Tax::find($item->tax_id)->get();
            $tax = $taxs;
        }
        $ticket['upcoming']->maintax = $tax;


        $ticket['past'] = Order::with(['event:id,name,image,start_time,type,end_time,address', 'ticket:id,ticket_number,name,type,price', 'organization:id,first_name,last_name,image'])
            ->where([['customer_id', Auth::guard('appuser')->user()->id], ['order_status', 'Cancel']])
            ->orderBy('id', 'DESC')->get();
        if (count($ticket['past']) > 0) {
            foreach ($ticket['past'] as $events) {
                if ($events->event->end_time <= Carbon::now()) {
                    $event[] = $events;
                }
            }
            $ticket['past']->event = $event;
        }
        foreach ($ticket['past'] as $item) {
            $ordertaxs = OrderTax::where('order_id', $item->id)->get();
            $ordertax = $ordertaxs;
        }

        foreach ($ordertax as $item) {
            $taxs = Tax::find($item->tax_id)->get();
            $tax = $taxs;
        }
        $ticket['past']->maintax = $tax;
        $blog =  Auth::guard('appuser')->user()->favorite_blog;
        $blog_id = array_map('intval', explode(',', $blog));
        $liked_blog = [];
        foreach ($blog_id as $key => $value) {
            $temp_blog[] = Blog::find($value);
            $liked_blog =  $temp_blog;
        }
        $follow = Auth::guard('appuser')->user()->following;
        $follow_id = array_map('intval', explode(',', $follow));
        $following = [];
        foreach ($follow_id as $key => $value) {
            $temp_follow[] = User::find($value);
            $following = $temp_follow;
        }

        return view('frontend.userTickets', compact('ticket', 'liked_blog', 'following'));
    }
    public function userOrderTicket($id)
    {
        $order = Order::with(['event', 'ticket', 'organization'])->find($id);
        $taxes_id = OrderTax::where('order_id', $order->id)->get();
        // $coupon = Coupon::find($order->coupon_id);
        $taxes = [];
        foreach ($taxes_id as $key => $value) {
            $temp_tax[] = Tax::find($value->tax_id);
            $taxes = $temp_tax;
        }
        $orderchild = OrderChild::where('order_id', $order->id)->get();
        $review = Review::where('order_id', $order->id)->first();
        return view('frontend.userOrderTicket', compact('order', 'taxes', 'review', 'orderchild'));
    }
    public function  getOrder($id)
    {
        $data = Order::with(['event:id,name,image,start_time,type,end_time,address', 'ticket:id,ticket_number,name,price,type', 'organization:id,first_name,last_name,image'])->find($id);
        $data->review = Review::where('order_id', $id)->first();
        $data->time = $data->created_at->format('D') . ', ' . $data->created_at->format('d M Y') . ' at ' . $data->created_at->format('h:i a');
        $data->start_time = $data->event->start_time->format('d M Y') . ', ' . $data->event->start_time->format('h:i a');
        $data->end_time = $data->event->end_time->format('d M Y') . ', ' . $data->event->end_time->format('h:i a');
        $taxs = array();
        $ordertax = OrderTax::where('order_id', $id)->get();
        foreach ($ordertax as $item) {
            $taxs = Tax::find($item->tax_id)->get();
            $taxs = $taxs;
        }
        $data->maintax = $taxs;

        return response()->json(['data' => $data, 'success' => true], 200);
    }

    public function addReview(Request $request)
    {
        $data = $request->all();
        $data['organization_id'] = Order::find($request->order_id)->organization_id;
        $data['event_id'] = Order::find($request->order_id)->event_id;
        $data['user_id'] = Auth::guard('appuser')->user()->id;
        $data['status'] = 0;
        Review::create($data);
        return redirect()->back();
    }

    public function sentMessageToAdmin(Request $request)
    {
        $data = $request->all();
        // dd($data);
        try {
            Mail::send('emails.message', ['data' => $data], function ($message) use ($data) {
                $setting = Setting::first();
                $message->from($setting->sender_email);
                $message->to(User::find(1)->email);
                $message->subject($data['subject']);
            });
        } catch (Throwable $th) {
            Log::info($th->getMessage());
        }
        return redirect('/contact')->with('success','Message sent to admin successfully!! Thank you for contact us. We will respond to you soon.');
    }

    public function privacypolicy()
    {
        return view('frontend.privacy-policy');
    }

    public function termsAndConditions ()
    {
       return view('frontend.terms-and-conditions');
    }

    public function appuserPrivacyPolicyShow(Request $request)
    {
        $policy = Setting::find(1)->appuser_privacy_policy;
        return view('frontend.privacy-policy', compact('policy'));
    }
    public function searchEvent(Request $request)
    {
        $search = $request->search ?? '';
        if ($search == '') {
            return redirect()->back();
        }
        $timezone = Setting::find(1)->timezone;
        $date = Carbon::now($timezone);
        $events  = Event::with(['category:id,name'])
            ->where([['address', 'LIKE', "%$search%"], ['status', 1], ['is_deleted', 0], ['event_status', 'Pending'], ['end_time', '>', $date->format('Y-m-d')]])
            ->orWhere([['name', 'LIKE', "%$search%"], ['status', 1], ['is_deleted', 0], ['event_status', 'Pending'], ['end_time', '>', $date->format('Y-m-d')]])
            ->orWhere([['description', 'LIKE', "%$search%"], ['status', 1], ['is_deleted', 0], ['event_status', 'Pending'], ['end_time', '>', $date->format('Y-m-d')]]);
        $chip = array();
        if ($request->has('type') && $request->type != null) {
            $chip['type'] = $request->type;
            $events = $events->where('type', $request->type);
        }
        if ($request->has('category') && $request->category != null) {
            $chip['category'] = Category::find($request->category)->name;
            $events = $events->where('category_id', $request->category);
        }
        if ($request->has('duration') && $request->duration != null) {
            $chip['date'] = $request->duration;
            if ($request->duration == 'Today') {
                $temp = Carbon::now($timezone)->format('Y-m-d');
                $events = $events->whereBetween('start_time', [$temp . ' 00:00:00', $temp . ' 23:59:59']);
            } else if ($request->duration == 'Tomorrow') {
                $temp = Carbon::tomorrow($timezone)->format('Y-m-d');
                $events = $events->whereBetween('start_time', [$temp . ' 00:00:00', $temp . ' 23:59:59']);
            } else if ($request->duration == 'ThisWeek') {
                $now = Carbon::now($timezone);
                $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i:s');
                $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i:s');
                $events = $events->whereBetween('start_time', [$weekStartDate, $weekEndDate]);
            } else if ($request->duration == 'date') {
                if (isset($request->date)) {
                    $temp = Carbon::parse($request->date)->format('Y-m-d H:i:s');
                    $events = $events->whereBetween('start_time', [$request->date . ' 00:00:00', $request->date . ' 23:59:59']);
                }
            }
        }
        $events = $events->orderBy('start_time', 'ASC')->get();
        foreach ($events as $value) {
            $value->total_ticket = Ticket::where([['event_id', $value->id], ['is_deleted', 0], ['status', 1]])->sum('quantity');
            $value->sold_ticket = Order::where('event_id', $value->id)->sum('quantity');
            $value->available_ticket = $value->total_ticket - $value->sold_ticket;
        }
        $user = Auth::guard('appuser')->user();
        $offlinecount = 0;
        $onlinecount = 0;
        foreach ($events as $key => $value) {
            if ($value->type == 'online') {
                $onlinecount += 1;
            }
            if ($value->type == 'offline') {
                $offlinecount += 1;
            }
        }

        return view('frontend.events', compact('user', 'events', 'chip', 'onlinecount', 'offlinecount'));
    }
    public function eventsByTag($tag)
    {
        $events = Event::where('tags', 'LIKE', "%$tag%")->get();
        $onlinecount = 0;
        $offlinecount = 0;
        foreach ($events as $key => $value) {
            if ($value->type == 'online') {
                $onlinecount += 1;
            } else {
                $offlinecount += 1;
            }
        }
        if (Auth::guard('appuser')->check()) {
            $user = Auth::guard('appuser')->user();
            return view('frontend.events', compact('events', 'onlinecount', 'offlinecount', 'user'));
        }
        return view('frontend.events', compact('events', 'onlinecount', 'offlinecount'));
    }
    public function blogByTag($tag)
    {
        $blogs = Blog::where('tags', 'LIKE', "%$tag%")->where('status', 1)->orderBy('id', 'DESC')->get();
        $category = Category::where('status', 1)->orderBy('id', 'DESC')->get();
        if (Auth::guard('appuser')->user()) {
            $user = Auth::guard('appuser')->user();
            return view('frontend.blog', compact('blogs', 'category', 'user'));
        }
        return view('frontend.blog', compact('blogs', 'category'));
    }
    public function Faqs()
    {
        $data = Faq::where('status', 1)->get();
        return view('frontend.show_faq', compact('data'));
    }

    public function cancellatioPolicy(){
        return view('frontend.cancellation-policy');
    }
    public function listYourEvent(){
        return view('frontend.list-your-event');
    }
}
