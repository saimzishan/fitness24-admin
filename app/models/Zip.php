<?php

class Zip extends Eloquent {

    protected $table = 'zips';
//    protected $primaryKey = 'id';
    protected $hidden = array('_token');
//    protected $guarded = array();
    protected $fillable = array(
        'zip',
        'state',
        'city',
        'lat',
        'lng'
    );

//////////////////////// Relations //////////////////////
////////////////////////// Methods ///////////////////////

    public static function get_cities_of_state($state) {
        return Zip::where("state", "=", "$state")->groupBy("city")->get()->toArray();
    }

    public static function insert_data() {
//    $query = "INSERT INTO `zips` (`zip`, `state`, `city`, `lat`, `lng`) VALUES (35004, 'AL', 'Acmar', '33.584132', '-86.515570')";
//
//
//
//        $result = DB::select(DB::raw($query));
//        if ($result) {
//            echo $result;
//        } else {
//            echo '<pre>';
//            print_r($result);
//            exit;
//        }
    }

}

#--------------------------------------------------[Developed by: Maqsood Shah]