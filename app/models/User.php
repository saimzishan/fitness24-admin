<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $hidden = array('password', '_token');
    public static $singup_rules = array(
        'password' => 'required|min:8',
        'email' => 'required|email|unique:users'
    );
    public static $update_user_rules = array(
        'email' => 'required|email'
    );
    public static $login_rules = array(
        'email' => 'required|email',
        'password' => 'required'
    );
    //rules of the image upload form
    public static $upload_rules = array(
        'title' => 'required|min:3',
        'image' => 'required|image'
    );
    public static $messages = array(
        'email.required' => 'We need to know your e-mail address!',
        'password.required' => 'Your password should be minimum 8 characters long!',
    );
//    protected $guarded = array();
    protected $fillable = array(
        'first_name',
        'last_name',
        'email',
        'password',
        'profile_image',
        'phone_number',
        'zipcode',
        'customer_id',
        'merchant_id',
        'role',
        'archive',
        'is_verified'
    );

    ///////////////////////// Relationships /////////////////////
    public function vehicle() {
        return $this->hasMany("Vehicle", "user_id", "id");
    }

    public function search() {
        return $this->hasMany("RecentSearch", "user_id", "id");
    }

    public function parkingHistory() {
        return $this->hasMany("ParkingHistory", "user_id", "id");
    }
    
    public function devicetoken() {
        return $this->hasOne("DeviceToken", "user_id", "id");
    }

    ////////////////////////// Methods/////////////////
    //////////////////////Get all users////////////////////
    public static function get_all_user() {
        return User::where("role", "!=", "admin")->get();
    }

    //////////////////////Count all users////////////////////
    public static function count_all_user() {
        return User::where("role", "!=", "super_admin")->count();
    }

    //////////////////////Creating new User//////////////////////
    public static function save_new_user($inputs, $image_new_name, $password, $braintree_customer_id) {
        $user = new User($inputs);
        $user->password = $password;
        $user->profile_image = $image_new_name;
       // $user->customer_id = $braintree_customer_id;
        if ($user->save()) {
            return $user;
        } else {
            return false;
        }
    }

    ////////////////////////Get particular user////////////////
    public static function get_user_by_id($id) {
        return User::where("id", "=", $id)->first();
    }
    public static function getUserDetail($id) {
        return User::join('profiles', 'profiles.user_id','=','users.id')->where("users.id", "=", $id)->select('users.id','users.full_name','users.email','users.password', 'profiles.gender','profiles.current_date_height','profiles.current_date_weight','profiles.current_bmi','profiles.target_bmi','profiles.image')->first();
    }
    /////////////////process update particular user//////////////
    public static function update_user($id, $user_update) {
        $user = User::where("id", "=", "$id")->update($user_update);
        if ($user) {
            return true;
        } else {
            return false;
        }
    }

    ///////////////// Braintree process update particular user//////////////
    public static function braintree_customer_user_update($id, $braintree_customer_id) {
        $user = User::find($id);
        $user->customer_id = $braintree_customer_id;
        if ($user->save()) {
            return true;
        } else {
            return false;
        }
    }

    //////////////////////////Admin Login Process///////////////////
    public static function get_login_user() {
        $validation = Validator::make(Input::all(), User::$login_rules);
        if ($validation->fails()) {
            return Redirect::route('login')->withInput(Input::except('password'))->with('message', "danger=" . $validation->errors()->first());
        } else {
            $credentials = array(
                'email' => Input::get('email'),
                'password' => Input::get('password'),
//                'archive' => 0
            );
            if (Auth::attempt($credentials, false)) {
                $user = Auth::getUser()->attributesToArray();
                if ($user['role'] == "super_admin") {
                    return Redirect::route('home')->with('message', "success= Login successfully");
                }
            } else {
                return Redirect::route('login')->with('message', 'danger= Invalid Username/password');
            }
        }
    }

    public static function update_user_with_id($data) {
        return User::where("id", "=", $data['id'])->update($data);
    }

    ////////////////////////Get particular user data////////////////
    public static function get_particular_user_data($id) {
        return User::where("id", "=", $id)->first();
    }

    //////////////////Change user status using jquery ajax///////////////////
    public static function archive_user_via_jquery($user_inputs, $id) {
        $user_data = new User($user_inputs);
        $user_status = $user_data->toArray();
        User::where("id", "=", "$id")->update($user_status);
    }
    
    //////////////////////Get all users with deviceTokens////////////////////
    public static function get_users() {
        return User::where("role", "!=", "super_admin")->with("devicetoken")->get()->toArray();
    }

}

#--------------------------------------------------------------[Developed by: Maqsood Shah]