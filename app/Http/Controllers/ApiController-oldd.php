<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\AppUser;
use App\Models\User;
use App\Models\Event;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderTax;
use App\Models\Tax;
use App\Models\Review;
use App\Models\OrderChild;
use App\Http\Controllers\AppHelper;
use App\Models\PaymentSetting;
use App\Models\Ticket;
use App\Models\Currency;
use App\Models\Setting;
use App\Mail\ResetPassword;
use App\Mail\TicketBook;
use App\Mail\TicketBookOrg;
use App\Models\NotificationTemplate;
use App\Models\Notification;
use App\Models\EventReport;
use Carbon\Carbon;
use OneSignal;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Stripe;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct()
    {
        // (new AppHelper)->mailConfig();
    }

    public function userLogin(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'bail|required|email',
            'provider' => 'bail|required',
            'password' => 'bail|required',
        ]);
        if ($validator->fails())
        {
            $error =  $validator->errors()->first();
            return response()->json(['msg' => $error, 'success' => false], 200);
        }
        if ($request->provider == "LOCAL") {
            $userdata = array('email' => $request->email, 'status' => 1, 'password' => $request->password);
            if (Auth::guard('appuser')->attempt($userdata)) {
                $user = Auth::guard('appuser')->user();
                AppUser::find($user->id)->update(['device_token' => $request->device_token]);
                $user['token'] = $user->createToken('eventRight')->accessToken;
                return response()->json(['msg' => 'Login successfully', 'data' => $user, 'success' => true], 200);
            } else {
                return response()->json(['msg' => 'Invalid Username or password', 'data' => null, 'success' => false]);
            }
        }
    }

    public function userRegister(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'first_name' => 'bail|required',
            'last_name' => 'bail|required',
            'email' => 'bail|required|email|unique:app_user',
            'password' => 'bail|required|min:6',
            'phone' => 'bail|required',
        ]);
        if ($validator->fails())
        {
            $error =  $validator->errors()->first();
            return response()->json(['msg' => $error, 'success' => false], 200);
        }
        $data = $request->all();
        $data['password'] =  Hash::make($request->password);
        $data['image'] = "defaultuser.png";
        $data['status'] = 1;
        $data['name'] = $request->first_name;
        $data['provider'] = "LOCAL";
        $data['language'] = Setting::first()->language;
        $user = AppUser::create($data);
        $user['token'] = $user->createToken('eventRight')->accessToken;

        return response()->json(['msg' => 'Registered successfully', 'data' => $user, 'success' => true], 200);
    }

    public function organization()
    {
        $users = User::role('Organizer')->where('status', 1)->orderBy('id', 'DESC')->get()->makeHidden(['created_at', 'updated_at']);

        foreach ($users as $value) {
            if (Auth::check()) {
                if (in_array(Auth::user()->id, $value->followers)) {
                    $value->isFollow = true;
                } else {
                    $value->isFollow = false;
                }
            } else {
                $value->isFollow = false;
            }
        }
        return response()->json(['msg' => null, 'data' => $users, 'success' => true], 200);
    }

    public function events(Request $request)
    {
        $event = array();
        $timezone = Setting::findOrFail(1)->timezone;
        $date = Carbon::now($timezone);
        $data['events'] = Event::with(['ticket'])
            ->where([['status', 1], ['is_deleted', 0], ['event_status', 'Pending'], ['end_time', '>', $date->format('Y-m-d H:i:s')]])
            ->orderBy('start_time', 'ASC')->get()->makeHidden(['created_at', 'updated_at']);
        foreach ($data['events'] as $value) {
            $value->description =  str_replace("&nbsp;", " ", strip_tags($value->description));
            $value->time = $value->start_time->format('d F Y h:i a');
            if (Auth::guard('userApi')->check()) {
                if (in_array($value->id, array_filter(explode(',', Auth::guard('userApi')->user()->favorite)))) {
                    $value->isLike = true;
                } else {
                    $value->isLike = false;
                }
            } else {
                $value->isLike = false;
            }
        }
        if ($request->searchString != null && $request->searchDate == null) {
            $events  = Event::with(['category:id,name'])
                ->where([['address', 'LIKE', "%$request->searchString%"], ['status', 1], ['is_deleted', 0], ['event_status', 'Pending'], ['end_time', '>', $date->format('Y-m-d')]])
                ->orWhere([['name', 'LIKE', "%$request->searchString%"], ['status', 1], ['is_deleted', 0], ['event_status', 'Pending'], ['end_time', '>', $date->format('Y-m-d')]])
                ->orWhere([['description', 'LIKE', "%$request->searchString%"], ['status', 1], ['is_deleted', 0], ['event_status', 'Pending'], ['end_time', '>', $date->format('Y-m-d')]])->get();
            foreach ($events as $key => $value) {
                array_push($event, $value->id);
            }
        }
        if ($request->searchDate != null && $request->searchString == null) {
            $events  = Event::where('start_time', '<=', Carbon::parse($request->searchDate)->format('Y-m-d'))
                ->where('end_time', '>=', Carbon::parse($request->searchDate)->format('Y-m-d'))
                ->where(['status', 1], ['is_deleted', 0], ['event_status', 'Pending'])
                ->get();
            foreach ($events as $key => $value) {
                array_push($event, $value->id);
            }
        }
        if ($request->searchString != null && $request->searchDate != null) {
            $events  = Event::with(['category:id,name'])
                ->where([['address', 'LIKE', "%$request->searchString%"], ['status', 1], ['is_deleted', 0], ['event_status', 'Pending'], ['end_time', '>', $date->format('Y-m-d')],['start_time','<',$date->format('Y-m-d')]])
                ->orWhere([['name', 'LIKE', "%$request->searchString%"], ['status', 1], ['is_deleted', 0], ['event_status', 'Pending'], ['end_time', '>', $date->format('Y-m-d')],['start_time','<',$date->format('Y-m-d')]])
                ->orWhere([['description', 'LIKE', "%$request->searchString%"], ['status', 1], ['is_deleted', 0], ['event_status', 'Pending'], ['end_time', '>', $date->format('Y-m-d')],['start_time','<',$date->format('Y-m-d')]])->get();
            foreach ($events as $key => $value) {
                array_push($event, $value->id);
            }
        }

        if ($request->searchString != null || $request->searchDate != null) {
            $events = Event::with(['ticket'])->whereIn('id', $event)->where([['status', 1], ['is_deleted', 0]])->orderBy('start_time', 'ASC')->get();
            if ($events != null) {
                foreach ($events as $key => $value) {
                    $value->description =  str_replace("&nbsp;", " ", strip_tags($value->description));
                    $value->time = $value->start_time->format('d F Y h:i a');
                    if (Auth::guard('userApi')->check()) {
                        if (in_array($value->id, array_filter(explode(',', Auth::guard('userApi')->user()->favorite)))) {
                            $value->isLike = true;
                        } else {
                            $value->isLike = false;
                        }
                    } else {
                        $value->isLike = false;
                    }
                }
                $data['events'] = $events;
                return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
            }
        }
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }

    public function EventFrmCategory(Request $request)
    {
        $request->validate([
            'category_id' => 'bail|required',
        ]);
        $timezone = Setting::findOrFail(1)->timezone;
        $date = Carbon::now($timezone);

        $data =  Event::where([['status', 1], ['is_deleted', 0], ['category_id', $request->category_id], ['start_time', '>=', $date->format('Y-m-d H:i:s')]])->get();
        return $data;
        if ($request->lat != null &&  $request->lang != null) {
            $lat = $request->lat;
            $lang = $request->lang;
            $event = array();
            $radius = 50;
            $results = DB::select(DB::raw('SELECT id,name, ( 3959 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( lang ) - radians(' . $lang . ') ) + sin( radians(' . $lat . ') ) * sin( radians(lat) ) ) ) AS distance FROM events HAVING distance < ' . $radius . '  ORDER BY distance'));
            if (count($results) > 0) {
                foreach ($results as $q) {
                    array_push($event, $q->id);
                }
            }
            $data = $data->whereIn('id', $event);
        }

        $data = $data->orderBy('id', 'DESC')->get();
        foreach ($data as $value) {
            $value->description =  str_replace("&nbsp;", " ", strip_tags($value->description));
            $value->time = $value->start_time->format('d F Y h:i a');
            if (Auth::guard('userApi')->check()) {
                if (in_array($value->id, array_filter(explode(',', Auth::guard('userApi')->user()->favorite)))) {
                    $value->isLike = true;
                } else {
                    $value->isLike = false;
                }
            } else {
                $value->isLike = false;
            }
        }
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }

    public function searchFreeEvent(Request $request)
    {
        $request->validate([
            'free_event' => 'bail|required|numeric',
            'category_id' => 'bail|required|numeric',
        ]);
        $timezone = Setting::findOrFail(1)->timezone;
        $date = Carbon::now($timezone);
        $data = Event::where([['status', 1], ['is_deleted', 0], ['category_id', $request->category_id], ['start_time', '>=', $date->format('Y-m-d H:i:s')]]);
        if ($request->free_event == 1) {
            $ar_event = array();
            $ar = Event::where([['status', 1], ['is_deleted', 0], ['start_time', '>=', $date->format('Y-m-d H:i:s')]])->get();
            foreach ($ar as $value) {
                $ticket = Ticket::where([['status', 1], ['is_deleted', 0], ['event_id', $value->id], ['type', 'free']])->get();
                if (count($ticket) > 0) {
                    array_push($ar_event, $value->id);
                }
            }
            $data = $data->whereIn('id', $ar_event);
        }
        if ($request->lat != null &&  $request->lang != null) {
            $lat = $request->lat;
            $lang = $request->lang;
            $event = array();
            $radius = 50;
            $results = DB::select(DB::raw('SELECT id,name, ( 3959 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( lang ) - radians(' . $lang . ') ) + sin( radians(' . $lat . ') ) * sin( radians(lat) ) ) ) AS distance FROM events HAVING distance < ' . $radius . '  ORDER BY distance'));
            if (count($results) > 0) {
                foreach ($results as $q) {
                    array_push($event, $q->id);
                }
            }
            $data = $data->whereIn('id', $event);
        }
        $data = $data->orderBy('id', 'DESC')->get();
        foreach ($data as $value) {
            $value->description =  str_replace("&nbsp;", " ", strip_tags($value->description));
            $value->time = $value->start_time->format('d F Y h:i a');
            if (Auth::guard('userApi')->check()) {
                if (in_array($value->id, array_filter(explode(',', Auth::guard('userApi')->user()->favorite)))) {
                    $value->isLike = true;
                } else {
                    $value->isLike = false;
                }
            } else {
                $value->isLike = false;
            }
        }
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }

    public function category()
    {
        $data = Category::where('status', 1)->orderBy('id', 'DESC')->get();
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }

    public function organizationDetail($id)
    {
        $data = User::findOrFail($id);
        $data->event = Event::where([['user_id', $id], ['is_deleted', 0], ['status', 1]])->orderBy('id', 'DESC')->get();
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }

    public function eventDetail($id)
    {

        $data = Event::with(['ticket', 'organization:id,first_name,last_name,image,email'])->findOrFail($id);
        $data->hasTag = explode(',', $data->tags);
        $data->description =  str_replace("&nbsp;", " ", strip_tags($data->description));
        $data->recent_event = Event::where([['category_id', $data->category_id], ['is_deleted', 0], ['status', 0]])->orderBy('start_time', 'ASC')->get();
        $data->date = $data->start_time->format('d F Y');
        $data->endDate = $data->end_time->format('d F Y');
        $data->startTime = $data->start_time->format('h:i a');
        $data->gallery = array_filter(explode(',', $data->gallery));
        $data->endTime = $data->end_time->format('h:i a');
        foreach ($data->recent_event  as $value) {
            $value->time = $value->start_time->format('d F Y h:i a');
            if (Auth::guard('userApi')->check()) {
                if (in_array($value->id, array_filter(explode(',', Auth::guard('userApi')->user()->favorite)))) {
                    $value->isLike = true;
                } else {
                    $value->isLike = false;
                }
            } else {
                $value->isLike = false;
            }
        }
        if (Auth::guard('userApi')->check()) {
            if (in_array(Auth::guard('userApi')->user()->id, $data->organization->followers)) {
                $data->organization->isFollow = true;
            } else {
                $data->organization->isFollow = false;
            }
            if (in_array($id, array_filter(explode(',', Auth::guard('userApi')->user()->favorite)))) {
                $data->isLike = true;
            } else {
                $data->isLike = false;
            }
        } else {
            $data->organization->isFollow = false;
            $data->isLike = false;
        }
        $all_ticket = Ticket::where([['event_id', $id], ['is_deleted', 0], ['status', 1]])->sum('quantity');
        $use_ticket = Order::where('event_id', $id)->sum('quantity');
        if ($all_ticket == 0) {
            $data->sold_out = false;
        } else {
            if ($all_ticket == $use_ticket) {
                $data->sold_out = true;
            } else {
                $data->sold_out = false;
            }
        }

        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }

    public function ticketDetail($id)
    {
        $data = Ticket::findOrFail($id)->makeHidden(['created_at', 'updated_at']);
        $event = Event::findOrFail($data->event_id);
        $data->event_name = $event->name;
        $data->organization = User::findOrFail($event->user_id)->name;
        $data->use_ticket = (int)Order::where('ticket_id', $id)->sum('quantity');
        $data->startTime = $data->start_time->format('Y-m-d h:i a');
        $data->endTime = $data->end_time->format('Y-m-d h:i a');
        if ($data->quantity <= $data->use_ticket) {
            $data->sold_out = true;
        } else {
            $data->sold_out = false;
        }
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }

    public function eventTickets($id)
    {
        $event = Event::findOrFail($id);
        $data['event_name'] = $event->name;

        $data['organization'] = User::findOrFail($event->user_id)->name;
        $timezone = Setting::findOrFail(1)->timezone;
        $date = Carbon::now($timezone);

        $data['ticket'] = Ticket::where([['event_id', $id], ['is_deleted', 0], ['status', 1], ['end_time', '>=', $date->format('Y-m-d H:i:s')], ['start_time', '<=', $date->format('Y-m-d H:i:s')]])
            ->orderBy('id', 'DESC')->get();

        foreach ($data['ticket'] as $value) {
            $value->use_ticket = Order::where('ticket_id', $value->id)->sum('quantity');
            $value->startTime = $value->start_time->format('Y-m-d h:i a');
            $value->endTime = $value->end_time->format('Y-m-d h:i a');
            if ($value->use_ticket == $value->quantity) {
                $value->sold_out = true;
            } else {
                $value->sold_out = false;
            }
        }
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }



    public function reportEvent(Request $request)
    {
        $request->validate([
            'event_id' => 'bail|required',
            'email' => 'bail|required|email',
            'reason' => 'bail|required',
            'message' => 'bail|required',
        ]);
        $report = EventReport::create($request->all());
        return response()->json(['msg' => null, 'data' => $report, 'success' => true], 200);
    }

    public function categoryEvent()
    {
        $data = Category::where('status', 1)->orderBy('id', 'DESC')->get();
        foreach ($data as $value) {
            $value->events = Event::where([['status', 1], ['is_deleted', 0], ['category_id', $value->id]])->orderBy('id', 'DESC')->get();
        }
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }

    public function userProfile()
    {
        (new AppHelper)->eventStatusChange();
        $data = Auth::user();
        $data->likeCount = count(array_filter(explode(',', $data->favorite)));
        $data->totalTicket = Order::where('customer_id', $data->id)->count();
        $data->followingCount = count(array_filter(explode(',', $data->following)));
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }

    public function userLikes()
    {

        $data = Event::whereIn('id', array_filter(explode(',', Auth::user()->favorite)))->where([['status', 1], ['is_deleted', 0]])->orderBy('id', 'DESC')->get();
        foreach ($data as $value) {
            $value->description =  str_replace("&nbsp;", " ", strip_tags($value->description));
            $value->time = $value->start_time->format('d F Y h:i a');
        }
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }

    public function userFollowing()
    {
        $data = User::whereIn('id', array_filter(explode(',', Auth::user()->following)))->orderBy('id', 'DESC')->get();
        foreach ($data as $value) {
            if (Auth::check()) {
                if (in_array(Auth::user()->id, $value->followers)) {
                    $value->isFollow = true;
                } else {
                    $value->isFollow = false;
                }
            } else {
                $value->isFollow = false;
            }
        }
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }

    public function editUserProfile(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'last_name' => 'bail|required',
        ]);
        AppUser::findOrFail(Auth::user()->id)->update($request->all());
        $user = AppUser::findOrFail(Auth::user()->id);
        return response()->json(['msg' => 'Profile Update successfully', 'data' => $user, 'success' => true], 200);
    }

    public function editImage(Request $request)
    {
        $request->validate([
            'image' => 'bail|required',
        ]);

        if (isset($request->image)) {
            $image_name = (new AppHelper)->saveApiImage($request);
            AppUser::findOrFail(Auth::user()->id)->update(['image' => $image_name]);
            return response()->json(['msg' => null, 'data' => null, 'success' => true], 200);
        } else {
            return response()->json(['msg' => null, 'data' => null, 'success' => false], 200);
        }
    }

    public function addFavorite(Request $request)
    {
        $request->validate([
            'event_id' => 'bail|required',
        ]);
        $users = AppUser::findOrFail(Auth::user()->id);
        $likes = array_filter(explode(',', $users->favorite));
        if (count(array_keys($likes, $request->event_id)) > 0) {
            if (($key = array_search($request->event_id, $likes)) !== false) {
                unset($likes[$key]);
            }
            $msg = "Remove from Bookmark!";
        } else {
            array_push($likes, $request->event_id);
            $msg = "Add in Bookmark!";
        }
        $client = AppUser::findOrFail(Auth::user()->id);
        $client->favorite = implode(',', $likes);
        $client->update();

        return response()->json(['msg' => $msg, 'data' => null, 'success' => true], 200);
    }

    public function addFollowing(Request $request)
    {
        $request->validate([
            'user_id' => 'bail|required',
        ]);
        $users = AppUser::findOrFail(Auth::user()->id);
        $likes = array_filter(explode(',', $users->following));
        if (count(array_keys($likes, $request->user_id)) > 0) {
            if (($key = array_search($request->user_id, $likes)) !== false) {
                unset($likes[$key]);
            }
            $msg = "Remove from following list!";
        } else {
            array_push($likes, $request->user_id);
            $msg = "Add in following!";
        }
        $client = AppUser::findOrFail(Auth::user()->id);
        $client->following = implode(',', $likes);
        $client->update();
        return response()->json(['msg' => $msg, 'data' => null, 'success' => true], 200);
    }

    public function checkCode(Request $request)
    {
        $request->validate([
            'coupon_code' => 'bail|required',
            'event_id' => 'bail|required',
            'amount' => 'bail|required',
        ]);
        //New Code
        $total = $request->amount;
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
                            'success' => true,
                            'data' => [
                                'total_price' => $subtotal,
                                'total' => $total,
                                'discount' => $coupon->discount,
                                'applied_discount' => $discount,
                                'coupon_id' => $coupon->id,
                                'coupon_type' => $coupon->discount_type
                            ],
                            'message' => 'coupon apply successful.'
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

    public function  allCoupon()
    {
        $data = Coupon::where('status', 1)->orderBy('id', 'DESC')->get();
        return response()->json(['success' => true, 'msg' => null, 'data' => $data], 200);
    }

    public function userNotification()
    {
        (new AppHelper)->eventStatusChange();
        $data = Notification::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        foreach ($data as $value) {
            $order = Order::findOrFail($value->order_id);
            if ($order) {
                $event = $order->event_id;
                $value->event_image = url('images/upload') . '/' . Event::findOrFail($event)->image;
            } else {
                $value->event_image = null;
            }
        }
        return response()->json(['success' => true, 'msg' => null, 'data' => $data], 200);
    }

    public function addReview(Request $request)
    {
        $request->validate([
            'event_id' => 'bail|required',
            'order_id' => 'bail|required',
            'message' => 'bail|required',
            'rate' => 'bail|required|numeric',
        ]);
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['organization_id'] = Event::findOrFail($request->event_id)->user_id;
        $data['status'] = 0;
        $review = Review::create($data);
        return response()->json(['success' => true, 'msg' => null, 'data' => $review], 200);
    }

    public function orderTax($id)
    {
        $organizer = Event::findOrFail($id)->user_id;
        $data = Tax::where([['user_id', $organizer], ['status', 1], ['allow_all_bill', 1]])->orderBy('id', 'DESC')->get()->makeHidden(['created_at', 'updated_at']);
        return response()->json(['success' => true, 'msg' => null, 'data' => $data], 200);
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'event_id' => 'bail|required',
            'ticket_id' => 'bail|required',
            'quantity' => 'bail|required',
            'coupon_discount' => 'bail|required',
            'payment' => 'bail|required|numeric',
            'tax' => 'bail|required|numeric',
            'payment_type' => 'bail|required',
            'payment_token' => 'required_if:payment_type,STRIPE,PAYPAL,RAZOR',
        ]);
        $data = $request->all();
        $data['order_id'] = '#' . rand(9999, 100000);
        $data['organization_id'] = Event::findOrFail($request->event_id)->user_id;
        $data['customer_id'] = Auth::user()->id;
        if ($request->payment_type == "LOCAL") {
            $data['payment_status'] = 0;
        } else {
            $data['payment_status'] = 1;
        }
        $com = Setting::findOrFail(1, ['org_commission_type', 'org_commission']);
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

        if ($request->coupon_id != null) {
            $count = Coupon::findOrFail($request->coupon_id)->use_count;
            $count = $count + 1;
            Coupon::findOrFail($request->coupon_id)->update(['use_count' => $count]);
        }
        if ($request->payment_type == "STRIPE") {
            $currency_code = Setting::first()->currency;
            $stripe_payment = $currency_code == "USD" || $currency_code == "EUR" || $currency_code == "INR" ? $request->payment * 100 : $request->payment;

            $cur = Setting::find(1)->currency;
            $stripe_secret =  PaymentSetting::find(1)->stripeSecretKey;

            Stripe\Stripe::setApiKey($stripe_secret);
            $stripeDetail =  Stripe\PaymentIntent::create([
                "amount" => $stripe_payment,
                "currency" => $cur,
                // "source" => $request->payment_token,
            ]);
            $data['payment_token'] = $stripeDetail->id;
        }

        $data = Order::create($data);

        for ($i = 1; $i <= $request->quantity; $i++) {
            $child['ticket_number'] = uniqid();
            $child['ticket_id'] = $request->ticket_id;
            $child['order_id'] = $data->id;
            $child['customer_id'] = Auth::User()->id;
            OrderChild::create($child);
        }

        if (isset($request->tax_data)) {
            foreach (json_decode($request->tax_data) as $value) {
                $tax['order_id'] = $data->id;
                $tax['tax_id'] = $value->tax_id;
                $tax['price'] = $value->price;
                OrderTax::create($tax);
            }
        }

        $user = AppUser::find($data->customer_id);
        $setting = Setting::find(1);

        // for user notification
        $message = NotificationTemplate::where('title', 'Book Coaching')->first()->message_content;
        $detail['user_name'] = $user->name;
        $detail['quantity'] = $request->quantity;
        $detail['event_name'] = Event::find($request->event_id)->name;
        $detail['date'] = Event::find($request->event_id)->start_time->format('d F Y h:i a');
        $detail['app_name'] = $setting->app_name;
        $noti_data = ["{{user_name}}", "{{quantity}}", "{{event_name}}", "{{date}}", "{{app_name}}"];
        $message1 = str_replace($noti_data, $detail, $message);
        $notification = array();
        $notification['organizer_id'] = null;
        $notification['user_id'] = $user->id;
        $notification['order_id'] = $data->id;
        $notification['title'] = 'Ticket Booked';
        $notification['message'] = $message1;
        Notification::create($notification);
        if ($setting->push_notification == 1) {
            (new AppHelper)->sendOneSignal('user', $user->device_token, $message1);
        }
        // for user mail
        $ticket_book = NotificationTemplate::where('title', 'Book Coaching')->first();
        $details['user_name'] = $user->name . ' ' . $user->last_name;
        $details['quantity'] = $request->quantity;
        $details['event_name'] = Event::find($request->event_id)->name;
        $details['date'] = Event::find($request->event_id)->start_time->format('d F Y h:i a');
        $details['app_name'] = $setting->app_name;
        if ($setting->mail_notification == 1) {
            try {
                Mail::to($user->email)->send(new TicketBook($ticket_book->mail_content, $details, $ticket_book->subject));
            } catch (\Throwable $th) {
                Log::info($th->getMessage());
            }
        }

        // for Organizer notification
        $org =  User::find($data->organization_id);
        $or_message = NotificationTemplate::where('title', 'Organizer Book Coaching')->first()->message_content;
        $or_detail['organizer_name'] = $org->first_name . ' ' . $org->last_name;
        $or_detail['user_name'] = $user->name . ' ' . $user->last_name;
        $or_detail['quantity'] = $request->quantity;
        $or_detail['event_name'] = Event::find($request->event_id)->name;
        $or_detail['date'] = Event::find($request->event_id)->start_time->format('d F Y h:i a');
        $or_detail['app_name'] = $setting->app_name;
        $or_noti_data = ["{{organizer_name}}", "{{user_name}}", "{{quantity}}", "{{event_name}}", "{{date}}", "{{app_name}}"];
        $or_message1 = str_replace($or_noti_data, $or_detail, $or_message);
        $or_notification = array();
        $or_notification['organizer_id'] =  $data->organization_id;
        $or_notification['user_id'] = null;
        $or_notification['order_id'] = $data->id;
        $or_notification['title'] = 'New Ticket Booked';
        $or_notification['message'] = $or_message1;
        Notification::create($or_notification);
        if ($setting->push_notification == 1) {
        }
        // for Organizer mail
        $new_ticket = NotificationTemplate::where('title', 'Organizer Book Coaching')->first();
        $details1['organizer_name'] = $org->first_name . ' ' . $org->last_name;
        $details1['user_name'] = $user->name . ' ' . $user->last_name;
        $details1['quantity'] = $request->quantity;
        $details1['event_name'] = Event::find($request->event_id)->name;
        $details1['date'] = Event::find($request->event_id)->start_time->format('d F Y h:i a');
        $details1['app_name'] = $setting->app_name;
        if ($setting->mail_notification == 1) {
            try {
                Mail::to($user->email)->send(new TicketBookOrg($new_ticket->mail_content, $details1, $new_ticket->subject));
            } catch (\Throwable $th) {
                Log::info($th->getMessage());
            }
        }

        return response()->json(['success' => true, 'msg' => null, 'data' => $data], 200);
    }

    public function viewUserOrder()
    {
        (new AppHelper)->eventStatusChange();
        $data = Order::with(['event', 'ticket', 'organization'])->where('customer_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return response()->json(['success' => true, 'msg' => null, 'data' => $data], 200);
    }

    public function viewSingleOrder($id)
    {
        (new AppHelper)->eventStatusChange();
        $data = Order::with(['event', 'ticket', 'organization'])->find($id);
        $data['order_child'] = OrderChild::where('order_id', $data->id)->get();
        return response()->json(['success' => true, 'msg' => null, 'data' => $data], 200);
    }

    public function allSetting()
    {
        $general = Setting::find(1, ['app_name', 'app_version', 'logo', 'currency', 'onesignal_app_id', 'onesignal_project_number', 'help_center', 'privacy_policy', 'cookie_policy', 'terms_services', 'acknowledgement', 'currency_sybmol']);

        if (auth('api')->check()) {
            $general->stripe = PaymentSetting::find(1)->stripe;
            $general->cod = PaymentSetting::find(1)->cod;
            $general->paypal = PaymentSetting::find(1)->paypal;
            $general->razor = PaymentSetting::find(1)->razor;
            $general->flutterwave = PaymentSetting::find(1)->flutterwave;
            $general->stripeSecretKey = PaymentSetting::find(1)->stripeSecretKey;
            $general->stripePublicKey = PaymentSetting::find(1)->stripePublicKey;
            $general->paypalClientId = PaymentSetting::find(1)->paypalClientId;
            $general->paypalSecret = PaymentSetting::find(1)->paypalSecret;
            $general->razorPublishKey = PaymentSetting::find(1)->razorPublishKey;
            $general->razorSecretKey = PaymentSetting::find(1)->razorSecretKey;
            $general->ravePublicKey = PaymentSetting::find(1)->ravePublicKey;
            $general->raveSecretKey = PaymentSetting::find(1)->raveSecretKey;
            $general->flutterDebugMode = PaymentSetting::find(1)->flutterDebugMode;
        }
        return response()->json(['success' => true, 'msg' => null, 'data' => $general], 200);
    }

    public function userOrder()
    {

        $data['upcoming'] = Order::with(['event', 'ticket'])->where([['customer_id', Auth::user()->id], ['order_status', 'Pending']])->orderBy('id', 'DESC')->get();
        $data['past'] = Order::with(['event', 'ticket'])
            ->where([['customer_id', Auth::user()->id], ['order_status', 'Complete']])
            ->orWhere([['customer_id', Auth::user()->id], ['order_status', 'Cancel']])
            ->orderBy('id', 'DESC')->get();

        foreach ($data['upcoming'] as $upcoming) {
            $upcoming['order_child'] = OrderChild::where('order_id', $upcoming->id)->get();
        }

        foreach ($data['past'] as $past) {
            $past['order_child'] = OrderChild::where('order_id', $past->id)->get();
        }
        return response()->json(['success' => true, 'msg' => null, 'data' => $data], 200);
    }

    public function singleOrder($id)
    {
        (new AppHelper)->eventStatusChange();
        $data = Order::with(['event', 'ticket'])->find($id);
        return response()->json(['success' => true, 'msg' => null, 'data' => $data], 200);
    }

    public function searchEvent(Request $request)
    {
        $timezone = Setting::find(1)->timezone;
        $date = Carbon::now($timezone);
        $data = Event::where([['status', 1], ['is_deleted', 0], ['start_time', '>=', $date->format('Y-m-d')]]);
        if ($request->lat != null && $request->lang != null) {
            $lat = $request->lat;
            $lang = $request->lang;
            $event = array();
            $radius = 50;
            $results = DB::select(DB::raw('SELECT id,name, ( 3959 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( lang ) - radians(' . $lang . ') ) + sin( radians(' . $lat . ') ) * sin( radians(lat) ) ) ) AS distance FROM events HAVING distance < ' . $radius . '  ORDER BY distance'));
            if (count($results) > 0) {
                foreach ($results as $q) {
                    array_push($event, $q->id);
                }
            }
            $data = $data->whereIn('id', $event);
        }
        if ($request->category != "All") {
            $data = $data->where([['category_id', $request->category], ['start_time', '>=', $date->format('Y-m-d H:i:s')]]);
        }
        if ($request->date != "All") {
            if ($request->date == "Today") {
                $start_date = Carbon::now()->format('Y-m-d') . ' 00:00:00';
                $end_date = Carbon::now()->format('Y-m-d') . ' 23:59:59';
            } elseif ($request->date == "Tommorow") {
                $start_date = Carbon::now()->addDays(1)->format('Y-m-d') . ' 00:00:00';
                $end_date = Carbon::now()->addDays(1)->format('Y-m-d') . ' 23:59:59';
            } elseif ($request->date == "This Week") {
                $start_date = Carbon::now()->modify('this week')->format('Y-m-d') . ' 00:00:00';
                $end_date = Carbon::now()->modify('this week +6 days')->format('Y-m-d') . ' 23:59:59';
            } else {
                $start_date = carbon::parse($request->date)->format('Y-m-d') . ' 00:00:00';
                $end_date = carbon::parse($request->date)->format('Y-m-d') . ' 23:59:59';
            }
            $data = $data->durationData($start_date, $end_date);
        }
        $data = $data->get();
        foreach ($data as $value) {
            $value->description =  str_replace("&nbsp;", " ", strip_tags($value->description));
            $value->time = $value->start_time->format('d F Y h:i a');
            if (Auth::guard('userApi')->check()) {
                if (in_array($value->id, array_filter(explode(',', Auth::guard('userApi')->user()->favorite)))) {
                    $value->isLike = true;
                } else {
                    $value->isLike = false;
                }
            } else {
                $value->isLike = false;
            }
        }
        return response()->json(['success' => true, 'msg' => null, 'data' => $data], 200);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'bail|required',
            'password' => 'bail|required|min:6',
            'password_confirmation' => 'bail|required|same:password|min:6'
        ]);
        if (Hash::check($request->old_password, Auth::user()->password)) {
            AppUser::find(Auth::user()->id)->update(['password' => Hash::make($request->password)]);
            return response()->json(['success' => true, 'msg' => 'Your password is change successfully', 'data' => null], 200);
        } else {
            return response()->json(['success' => false, 'msg' => 'Current Password is wrong!', 'data' => null], 200);
        }
    }

    public function forgetPassword(Request $request)
    {

        $request->validate([
            'email' => 'bail|required|email',
        ]);
        $user = AppUser::where('email', $request->email)->first();
        $password = rand(100000, 999999);

        if ($user) {
            $content = NotificationTemplate::where('title', 'Reset Password')->first()->mail_content;
            $detail['user_name'] = $user->name;
            $detail['password'] = $password;
            $detail['app_name'] = Setting::find(1)->app_name;

            try {
                Mail::to($user->email)->send(new ResetPassword($content, $detail));
            } catch (\Throwable $th) {
                Log::info($th->getMessage());
            }
            AppUser::find($user->id)->update(['password' => Hash::make($password)]);
            return response()->json(['success' => true, 'msg' => 'New password send in your email', 'data' => null], 200);
        } else {
            return response()->json(['success' => false, 'msg' => 'Invalid email ID', 'data' => null], 200);
        }
    }

    public function clearNotification()
    {
        $noti = Notification::where('user_id', Auth::user()->id)->get();
        foreach ($noti as $value) {
            $value->delete();
        }
        return response()->json(['success' => true, 'msg' => 'Notification deleted successfully.'], 200);
    }
    public function user_delete($id)
    {
        $time = Carbon::now();
        $time->toArray();
        $app_user = AppUser::find($id);
        $app_user['name'] = 'User Deleted';
        $app_user['last_name'] = 'Deleted';
        $app_user['status'] = 0;
        $app_user['email'] =  $time->timestamp . '@deleteduser.com';
        $app_user->update();
        $app_user->delete();
        return response()->json(['success' => true, 'msg' => 'Account deleted successfully.'], 200);
    }
}
