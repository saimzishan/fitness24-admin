<?php
/*
  |--------------------------------------------------------------------------
  | Gravel Admin Panel Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */
// **********  Admin routing ************
Route::group(array('before' => 'check_login'), function() {
    
   Route::get('/', array('as' => 'home', 'uses' => 'UserController@get_home'));

   ////////////////////////// Users Routes ///////////////////
Route::post('updateuser', array('as' => 'update_user', 'uses' => 'UserController@update_user'));
Route::get('signup', array('as' => 'add_user', 'uses' => 'UserController@add_user'));
Route::post('signup', array('as' => 'post_signup', 'uses' => 'UserController@post_signup'));
Route::get('allusers', array('as' => 'all_user', 'uses' => 'UserController@get_all_user'));
Route::get('edituser/{id}', array('as' => 'edit_user', 'uses' => 'UserController@edit_user'))->where(array('id' => '[0-9]+'));
Route::get('userDetails/{id}', array('as' => 'view_user', 'uses' => 'UserController@view_user'))->where(array('id' => '[0-9]+'));
Route::post('updateuser', array('as' => 'update_user', 'uses' => 'UserController@update_user'));
Route::get('boradcast', array('as' => 'broadcast_message', 'uses' => 'UserController@boradcastMessage'));
Route::post('boradcast', array('as' => 'broadcast_message', 'uses' => 'UserController@pBoradcastMessage'));
/////////////////////////// Videos Routes ///////////////////////
Route::get('allvideos', array('as' => 'all_videos', 'uses' => 'VideoController@get_videos'));
Route::post('videostatus', array('as' => 'video_status', 'uses' => 'VideoController@change_video_status'));
Route::get('addVideo', array('as' => 'add_video', 'uses' => 'VideoController@add_video'));
Route::post('addVideo', array('as' => 'post_video', 'uses' => 'VideoController@post_video'));
Route::get('editVideo', array('as' => 'edit_video', 'uses' => 'VideoController@edit_video'));
Route::post('editVideo', array('as' => 'post_edit_video', 'uses' => 'VideoController@post_edit_video'));

Route::get('allNutrition', array('as' => 'all_nutrition', 'uses' => 'VideoController@get_nutrition'));
Route::get('addNutrition', array('as' => 'add_nutrition', 'uses' => 'VideoController@add_nutrition'));
Route::post('deleteNutrition', array('as' => 'delete_nutrition', 'uses' => 'VideoController@delete_nutrition'));

//////////////////////// Goals Routes /////////////
Route::get('goals', array('as' => 'goals', 'uses' => 'GoalsController@goals'));
Route::get('edit_goal/{id}', array('as' => 'edit_goal', 'uses' => 'GoalsController@edit_goal'));
Route::post('updateGoal', array('as' => 'update_goal', 'uses' => 'GoalsController@update_goal'));


/////////////////////////// Vehicle Routes ///////////////////////
Route::get('addVehicle/{id}', array('as' => 'add_vehicle', 'uses' => 'VehicleController@add_vehicle'))->where(array('id' => '[0-9]+'));
Route::post('addVehicle', array('as' => 'post_vehicle', 'uses' => 'VehicleController@post_vehicle'));
Route::get('editVehicle/{user_id}/{vehicle_id}', array('as' => 'edit_vehicle', 'uses' => 'VehicleController@edit_vehicle'))->where(array('user_id' => '[0-9]+', 'vehicle_id' => '[0-9]+'));
Route::post('updateVehicle', array('as' => 'update_vehicle', 'uses' => 'VehicleController@update_vehicle'));
Route::get('userVehicles/{id}', array('as' => 'user_vehicles', 'uses' => 'VehicleController@user_vehicles'))->where(array('id' => '[0-9]+'));
Route::get('VehicleTowing', array('as' => 'vehicle_list', 'uses' => 'VehicleController@towing_vehicle_list'))->where(array('id' => '[0-9]+'));
Route::get('changeStatus/{id}', array('as' => 'change_towing_status', 'uses' => 'VehicleController@change_towing_status'))->where(array('id' => '[0-9]+'));

////////////////////////// Vehicle Make & Model Routes ///////////////////
Route::get('addMakeModel', array('as' => 'add_make_model', 'uses' => 'VehicleController@add_make_model'));
Route::post('addMake', array('as' => 'post_make_model', 'uses' => 'VehicleController@post_make_model'));
Route::get('allMake', array('as' => 'all_make', 'uses' => 'VehicleController@all_vehicle_make'));
Route::get('viewModel/{id}', array('as' => 'view_vehicle_model', 'uses' => 'VehicleController@view_vehicle_model'))->where(array('id' => '[0-9]+'));
Route::get('addModel/{id}', array('as' => 'add_model', 'uses' => 'VehicleController@add_model'))->where(array('id' => '[0-9]+'));
Route::post('add_Make', array('as' => 'post_new_model', 'uses' => 'VehicleController@post_new_model'));
Route::get('editMake/{id}', array('as' => 'edit_make', 'uses' => 'VehicleController@edit_make'))->where(array('id' => '[0-9]+'));
Route::post('updateMake', array('as' => 'update_make_type', 'uses' => 'VehicleController@update_make_type'));
Route::get('editModel/{id}/{make_id}', array('as' => 'edit_model', 'uses' => 'VehicleController@edit_model'))->where(array('id' => '[0-9]+', 'make_id' => '[0-9]+'));
Route::post('updateModel', array('as' => 'update_model', 'uses' => 'VehicleController@update_model'));

/////////////////////////// Credit cards Routes ////////////////////
Route::get('addCard/{id}', array('as' => 'add_credit_card', 'uses' => 'PaymentController@add_credit_card'))->where(array('id' => '[0-9]+'));
Route::post('addCard', array('as' => 'post_credit_card', 'uses' => 'PaymentController@post_credit_card'));
Route::get('editCard/{id}/{token}', array('as' => 'edit_credit_card', 'uses' => 'PaymentController@edit_credit_card'))->where(array('id' => '[0-9]+'));
Route::post('updateCard', array('as' => 'update_credit_card', 'uses' => 'PaymentController@update_credit_card'));
Route::get('deleteCreditCard/{id}/{token}', array('as' => 'delete_credit_card', 'uses' => 'PaymentController@delete_credit_card'))->where(array('id' => '[0-9]+'));
Route::get('userCreditCards/{id}', array('as' => 'user_credit_cards', 'uses' => 'PaymentController@user_credit_cards'))->where(array('id' => '[0-9]+'));

/////////////////////////// Payment routes ////////////////////////
Route::get('merchantPayments/{id}', array('as' => 'merchant_payments', 'uses' => 'PaymentController@merchant_payments'))->where(array('id' => '[0-9]+'));
Route::post('merchant', array('as' => 'post_merchant', 'uses' => 'UserController@post_merchant'));

////////////////////////// Parking History Routes ///////////////////
Route::get('parkingHistory/{id}', array('as' => 'user_parking_history', 'uses' => 'ParkingSpotController@user_parking_history'))->where(array('id' => '[0-9]+'));
Route::get('favoriteLocation/{id}', array('as' => 'user_favorite_location', 'uses' => 'ParkingSpotController@user_favorite_location'))->where(array('id' => '[0-9]+'));
Route::get('searchHistory/{id}', array('as' => 'user_search_history', 'uses' => 'ParkingSpotController@user_search_history'))->where(array('id' => '[0-9]+'));

////////////////////////// Parking Sopts Routes ////////////////////
Route::get('addSpot/{id}', array('as' => 'add_parking_spot', 'uses' => 'ParkingSpotController@add_parking_spot'))->where(array('id' => '[0-9]+'));
Route::post('addSpot', array('as' => 'post_parking_spot', 'uses' => 'ParkingSpotController@post_parking_spot'));
Route::get('parkingSpots/{id}', array('as' => 'user_parking_spots', 'uses' => 'ParkingSpotController@user_parking_spots'))->where(array('id' => '[0-9]+'));
Route::get('spotDetails/{id}/{spot_id}', array('as' => 'single_parking_spot', 'uses' => 'ParkingSpotController@single_parking_spot'))->where(array('id' => '[0-9]+', 'spot_id' => '[0-9]+'));
Route::get('deletespotfeature/{user_id}/{spot_id}/{feature_id}', array('as' => 'delete_single_spot_feature', 'uses' => 'ParkingSpotController@delete_single_spot_feature'))->where(array('id' => '[0-9]+'));
Route::get('editSpot/{user_id}/{spot_id}', array('as' => 'edit_parking_spot', 'uses' => 'ParkingSpotController@edit_parking_spot'))->where(array('user_id' => '[0-9]+', 'spot_id' => '[0-9]+'));
Route::post('updateSpot', array('as' => 'update_spot', 'uses' => 'ParkingSpotController@update_parking_spot'));
Route::get('reserveStatus/{user_id}/{parking_id}/{is_reserved}', array('as' => 'change_reserve_status', 'uses' => 'ParkingSpotController@change_reserve_status'))->where(array('user_id' => '[0-9]+', 'parking_id' => '[0-9]+'));
Route::get('addSpotFeature/{user_id}/{spot_id}', array('as' => 'add_feature', 'uses' => 'ParkingSpotController@add_feature'))->where(array('user_id' => '[0-9]+', 'spot_id' => '[0-9]+'));
Route::post('updateSpotFeature', array('as' => 'post_particular_feature', 'uses' => 'ParkingSpotController@post_particular_feature'));
Route::get('changeAvailability/{id}/{user_id}/{spot_id}', array('as' => 'edit_availability', 'uses' => 'ParkingSpotController@edit_availability'))->where(array('id' => '[0-9]+', 'user_id' => '[0-9]+', 'spot_id' => '[0-9]+'));
Route::post('updateAvailability', array('as' => 'post_availability', 'uses' => 'ParkingSpotController@update_availability'))->where(array('id' => '[0-9]+'));

////////////////////////// Parking Features Routes ////////////////////
Route::get('addFeature', array('as' => 'add_parking_feature', 'uses' => 'ParkingSpotController@add_parking_feature'));
Route::post('addFeature', array('as' => 'post_parking_feature', 'uses' => 'ParkingSpotController@post_parking_feature'));
Route::get('allFeatures', array('as' => 'all_feature', 'uses' => 'ParkingSpotController@all_feature'));
Route::get('editfeature/{id}', array('as' => 'edit_feature', 'uses' => 'ParkingSpotController@edit_feature'))->where(array('id' => '[0-9]+'));
Route::post('updatefeature', array('as' => 'update_feature', 'uses' => 'ParkingSpotController@update_feature'));

/////////////////////////// Jquery Routes ///////////////////////
Route::post('userstatus', array('as' => 'user_status', 'uses' => 'UserController@change_user_status_jquery'));
Route::post('vehiclestatus', array('as' => 'vehicle_status', 'uses' => 'VehicleController@change_vehicle_status_jquery'));
Route::post('spotstatus', array('as' => 'spot_status', 'uses' => 'ParkingSpotController@change_spot_status_jquery'));
Route::post('modelstatus', array('as' => 'model_status', 'uses' => 'VehicleController@change_model_status_jquery'));
Route::post('makestatus', array('as' => 'make_status', 'uses' => 'VehicleController@change_make_status_jquery'));
Route::post('selectmodel', array('as' => 'select_model', 'uses' => 'VehicleController@select_model'));
Route::post('spotavailable', array('as' => 'spot_available', 'uses' => 'ParkingSpotController@change_spot_available_jquery'));
Route::post('selectemail', array('as' => 'select_email', 'uses' => 'UserController@select_email_jquery'));
Route::post('selectcity', array('as' => 'select_city', 'uses' => 'UserController@select_city_jquery'));

////////////////////////////// Promo Codes Routes //////////////////////
Route::get('newCoupon', array('as' => 'add_promo_code', 'uses' => 'UserController@add_promo_code'));
Route::get('editCoupon/{id}', array('as' => 'edit_coupon', 'uses' => 'UserController@edit_promo_code'));
Route::post('PromoCode', array('as' => 'post_promo_code', 'uses' => 'UserController@post_promo_code'));
Route::post('UpdateCoupon', array('as' => 'update_promo_code', 'uses' => 'UserController@update_promo_code'));
Route::get('coupons', array('as' => 'all_promo_codes', 'uses' => 'UserController@all_promo_codes'));

////////////////////////////// Exceptions Routes //////////////////////
Route::get('showException/{ex}', array('as' => 'showException', 'uses' => 'BaseController@showException'));

////////////////////////////// Vehicle Image Cropper Routes //////////////////////
Route::any('ajaxUpload', array('as' => 'ajaxUpload', 'uses' => 'VehicleController@ajaxUpload'));
Route::any('imageSelector', array('as' => 'imageSelector', 'uses' => 'VehicleController@imageSelector'));
Route::any('imageCrop', array('as' => 'imageCrop', 'uses' => 'VehicleController@imageCrop'));
Route::any('delImages', array('as' => 'delImages', 'uses' => 'VehicleController@delImages'));

////////////////////////////// User Image Cropper Routes //////////////////////
Route::any('ajaxUploadUser', array('as' => 'ajaxUploadUser', 'uses' => 'UserController@ajaxUpload'));
Route::any('userImageSelector', array('as' => 'userImageSelector', 'uses' => 'UserController@imageSelector'));
Route::any('userImageCrop', array('as' => 'userImageCrop', 'uses' => 'UserController@imageCrop'));

///////////////////////////// Database Queries Script Routes /////////////////////
//Route::get('insert', array('as' => 'insert', 'uses' => 'UserController@insert_data'));
//  =============================   Rotes for faq ===================== ////

Route::get('listAllFaq', array('as' => 'listAllFaq', 'uses' => 'GoalsController@makeFaq'));
Route::get('newFaq/{id?}', array('as' => 'newFaq', 'uses' => 'GoalsController@addFaq'));
Route::get('deleteFaq/{id}', array('as' => 'deleteFaq', 'uses' => 'GoalsController@deleteFaq'));
Route::post('postFaq', array('as' => 'postFaq', 'uses' => 'GoalsController@post_faq'));

//  =============================   Rotes for faq cat ===================== ////

    Route::get('listAllFaqCat', array('as' => 'listAllFaqCat', 'uses' => 'GoalsController@makeFaqCat'));
    Route::get('newFaqCat/{id?}', array('as' => 'newFaqCat', 'uses' => 'GoalsController@addFaqCat'));
    Route::get('deleteFaqCat/{id}', array('as' => 'deleteFaqCat', 'uses' => 'GoalsController@deleteFaqCat'));
    Route::post('postFaqCat', array('as' => 'postFaqCat', 'uses' => 'GoalsController@post_faqCat'));

//  =============================   Rotes for Exercise ===================== ////

    Route::get('listAllExercise', array('as' => 'listAllExercise', 'uses' => 'ExerciseController@index'));
    Route::get('newExercise/{id?}', array('as' => 'newExercise', 'uses' => 'ExerciseController@create'));
    Route::get('deleteExercise/{id}', array('as' => 'deleteExercise', 'uses' => 'ExerciseController@deleteExercise'));
    Route::get('removeExerciseVideo/{id}', array('as' => 'removeExerciseVideo', 'uses' => 'ExerciseVideosController@removeVideo'));

    Route::get('getAllVideos/{id}', array('as' => 'getAllVideos', 'uses' => 'ExerciseController@getAllVideos'));
    Route::get('getAllExercse/{id}', array('as' => 'getAllExercse', 'uses' => 'ExerciseController@getAllExercse'));

    Route::post('postlinkedVideos/{id?}', array('as' => 'postlinkedVideos', 'uses' => 'ExerciseController@postlinkedVideos'));
    Route::post('postlinkedExs/{id?}', array('as' => 'postlinkedExs', 'uses' => 'ExerciseController@postlinkedExs'));

    Route::get('relatedVideos/{id}', array('as' => 'relatedVideos', 'uses' => 'ExerciseController@getRelatedVideos'));
    Route::post('postExercise/{id?}', array('as' => 'postExercise', 'uses' => 'ExerciseController@store'));

        Route::get('deleteExerciseOfDay/{id}', array('as' => 'deleteExerciseOfDay', 'uses' => 'ExerciseController@deleteExerciseOfDay'));

//  =============================   Rotes for Plan ===================== ////

    Route::get('listAllPlans', array('as' => 'listAllPlans', 'uses' => 'PlanController@index'));
    Route::get('newPlan/{id?}', array('as' => 'newPlan', 'uses' => 'PlanController@create'));
    Route::get('deletePlan/{id}', array('as' => 'deletePlan', 'uses' => 'PlanController@destroy'));
    Route::post('postPlan/{id?}', array('as' => 'postPlan', 'uses' => 'PlanController@store'));
//  getting plan days
    Route::get('getPlanDays/{id}', array('as' => 'getPlanDays', 'uses' => 'PlanController@renderPlanDays'));
// Delete plan days
    Route::get('deletePlandays/{id}', array('as' => 'deletePlandays', 'uses' => 'PlanController@destroyPlandays'));

//  =============================   Rotes for Plan Days ===================== ////

    Route::get('listAllPlanDays', array('as' => 'listAllPlanDays', 'uses' => 'PlanDaysController@viewAllPlanDays'));
    Route::get('newPlanDay/{id?}', array('as' => 'newPlanDay', 'uses' => 'PlanDaysController@create'));
    Route::get('deletePlanDay/{id}', array('as' => 'deletePlanDay', 'uses' => 'PlanDaysController@destroy'));
    Route::post('postPlanDay', array('as' => 'postPlanDay', 'uses' => 'PlanDaysController@store'));
//  =============================   Rotes for Plan Day Exercise===================== ////

    Route::get('listAllPlanDayExercise', array('as' => 'listAllPlanDayExercise', 'uses' => 'PlanDayExerciseController@viewAllPlanDayExercise'));
    Route::get('newPlanDayExercise/{id?}', array('as' => 'newPlanDayExercise', 'uses' => 'PlanDayExerciseController@create'));
    Route::get('deletePlanDayExercise/{id}', array('as' => 'deletePlanDayExercise', 'uses' => 'PlanDayExerciseController@destroy'));
    Route::post('postPlanDayExercise', array('as' => 'postPlanDayExercise', 'uses' => 'PlanDayExerciseController@store'));

    Route::get('renderHtml/{id?}', array('as' => 'renderHtml', 'uses' => 'PlanDayExerciseController@renderHtml'));
#=========================== Application Routes End ==============================
});




// Need to remove
////////////////////////// Login Routes ///////////////////
Route::any('login', array( 'uses' => 'UserController@login'));
Route::post('login', array('as' => 'post_login', 'uses' => 'UserController@post_login'));
Route::get('logout', array('as' => 'logout', 'uses' => 'UserController@get_logout'));
