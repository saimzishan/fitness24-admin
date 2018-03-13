<div class="page-sidebar-wrapper">
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <li class="sidebar-toggler-wrapper">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler">
                </div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>
            <li class="start">
                <a href="<?php echo route("home"); ?>">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                    <span class="arrow "></span>
                </a>
            </li>
            <?php
            $route = Route::getCurrentRoute()->uri();
            $profile_style = ($route == "userDetails/{id}") ? 'style="background: #575757;"' : "";
            $vehicle_style = ($route == "userVehicles/{id}") ? 'style="background: #575757;"' : "";
            $spot_style = ($route == "parkingSpots/{id}") ? 'style="background: #575757;"' : "";
            $allcard_style = ($route == "userCreditCards/{id}") ? 'style="background: #575757;"' : "";
            $history_style = ($route == "parkingHistory/{id}") ? 'style="background: #575757;"' : "";
            $favorit_style = ($route == "favoriteLocation/{id}") ? 'style="background: #575757;"' : "";
            $search_style = ($route == "searchHistory/{id}") ? 'style="background: #575757;"' : "";
            $spotDetails_style = ($route == "spotDetails/{id}/{spot_id}") ? 'style="background: #575757;"' : "";
            $editspot_style = ($route == "editSpot/{user_id}/{spot_id}") ? 'style="background: #575757;"' : "";
            $addspot_style = ($route == "addSpot/{id}") ? 'style="background: #575757;"' : "";
            $addfeature_style = ($route == "addSpotFeature/{user_id}/{spot_id}") ? 'style="background: #575757;"' : "";
            $addvehicle_style = ($route == "addVehicle/{id}") ? 'style="background: #575757;"' : "";
            $editvehicle_style = ($route == "editVehicle/{user_id}/{vehicle_id}") ? 'style="background: #575757;"' : "";
            $editcard_style = ($route == "editCard/{id}/{token}") ? 'style="background: #575757;"' : "";
            $availability_style = ($route == "changeAvailability/{id}/{user_id}/{spot_id}") ? 'style="background: #575757;"' : "";
            $merchant_style = ($route == "merchantPayments/{id}") ? 'style="background: #575757;"' : "";
            $edituser_style = ($route == "edituser/{id}") ? 'style="background: #575757;"' : "";
            $addcard_style = ($route == "addCard/{id}") ? 'style="background: #575757;"' : "";
//            if ($route == 'userDetails/{id}' || $route == 'userVehicles/{id}' ||
//                    $route == 'parkingSpots/{id}' || $route == 'userCreditCards/{id}' ||
//                    $route == 'parkingHistory/{id}' || $route == 'favoriteLocation/{id}' ||
//                    $route == 'searchHistory/{id}' || $route == 'spotDetails/{id}/{spot_id}' ||
//                    $route == 'editSpot/{user_id}/{spot_id}' || $route == 'addSpot/{id}' || $route == 'addSpotFeature/{user_id}/{spot_id}' ||
//                    $route == 'addVehicle/{id}' || $route == 'editVehicle/{user_id}/{vehicle_id}' || $route == 'editCard/{id}/{token}' ||
//                    $route == 'changeAvailability/{id}/{user_id}/{spot_id}' || $route == 'merchantPayments/{id}' ||
//                    $route == 'edituser/{id}' || $route == 'addCard/{id}') {
//                echo '<li style="background-color: #2E2E2E;">'
//                . '<a href="javascript:;">'
//                . '<i class="icon-users"></i>'
//                . '<span class="title" style="font-weight: bold;">' . $user->first_name . ' ' . $user->last_name . '</span>'
//                . '<span class="arrow open"></span>'
//                . '</a>'
//                . '<ul class="sub-menu open" style="display: block; background-color: #424242;">'
//                . '<li ' . $profile_style . ' ' . $edituser_style . '><a href="' . route("view_user", array("id" => $user_id)) . '" id="">Profile</a></li>'
//                . '<li ' . $vehicle_style . ' ' . $addvehicle_style . ' ' . $editvehicle_style . '><a href="' . route("user_vehicles", array("id" => $user_id)) . '" >Vehicles</a></li>'
//                . '<li ' . $spot_style . ' ' . $spotDetails_style . ' ' . $editspot_style . ' ' . $addspot_style . ' ' . $addfeature_style . ' ' . $availability_style . '><a href="' . route("user_parking_spots", array("id" => $user_id)) . '">Parking Spots</a></li>'
//                . '<li ' . $allcard_style . ' ' . $addcard_style . ' ' . $editcard_style . '><a href="' . route("user_credit_cards", array("id" => $user_id)) . '">Credit Cards</a></li>'
//                . '<li ' . $merchant_style . '><a href="' . route("merchant_payments", array("id" => $user_id)) . '">Merchant Payments</a></li>'
//                . '<li ' . $history_style . '><a href="' . route("user_parking_history", array("id" => $user_id)) . '">Parking History</a></li>'
//                . '<li ' . $favorit_style . '><a href="' . route("user_favorite_location", array("id" => $user_id)) . '">Favorite Locations</a></li>'
//                . '<li ' . $search_style . '><a href="' . route("user_search_history", array("id" => $user_id)) . '">Search History</a></li>'
//                . '</ul>'
//                . '</li>';
//            }
            ?>
            <li>
                <a href="<?php echo route("all_user"); ?>">
                    <i class="icon-users"></i>
                    <span class="title">Users</span>
<!--                    <span class="arrow "></span>-->
                </a>
<!--                <ul class="sub-menu">
                    <li>
                        <a href="<?php echo route("add_user"); ?>">
                            Add User</a>
                    </li>
                    <li>
                        <a href="<?php echo route("all_user"); ?>">
                            View All Users</a>
                    </li>
                </ul>-->
            </li>
            <li>
                <a href="javascript:;">
                    <i class="icon-cloud-upload"></i>
                    <span class="title">Videos</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="<?php echo route("add_video"); ?>">
                            Add Video</a>
                    </li>
                    <li>
                        <a href="<?php echo route("all_videos"); ?>">
                            View All Video</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="<?php echo route("goals");?>" >
                    <i class="icon-cloud-upload"></i>
                    <span class="title">Goals</span>
                    
                </a>             
            </li>
             <li>
                <a href="javascript:;">
                    <i class="icon-cloud-upload"></i>
                    <span class="title">Coupons</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="<?php echo route("add_promo_code"); ?>">
                            Add Coupon</a>
                    </li>
                    <li>
                        <a href="<?php echo route("all_promo_codes"); ?>">
                            View All Coupons</a>
                    </li>
                </ul>
            </li>    
            <li>
                <a href="javascript:;">
                    <i class="icon-cloud-upload"></i>
                    <span class="title">Nutrition</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="<?php echo route("add_nutrition"); ?>">
                            Add Nutrition</a>
                    </li>
                    <li>
                        <a href="<?php echo route("all_nutrition"); ?>">
                            View All Nutrition</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="<?php echo route("broadcast_message"); ?>">
                    <i class="icon-cloud-upload"></i>
                    <span class="title">Broadcast Message</span>
                    <span class="arrow "></span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="icon-cloud-upload"></i>
                    <span class="title">FAQs</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="<?php echo route("newFaq") ?>">
                            Add FAQ</a>
                    </li>
                    <li>
                        <a href="<?php echo route("listAllFaq"); ?>">
                            View All FAQs</a>
                    </li>
                    <li>
                        <a href="<?php echo route("newFaqCat") ?>">
                            Add FAQ CAT</a>
                    </li>
                    <li>
                        <a href="<?php echo route("listAllFaqCat"); ?>">
                            View All FAQ CAT</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class="icon-cloud-upload"></i>
                    <span class="title">Exercise</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="<?php echo route("newExercise") ?>">
                            Add Exercise</a>
                    </li>
                    <li>
                        <a href="<?php echo route("listAllExercise"); ?>">
                            View All Exercises</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class="icon-cloud-upload"></i>
                    <span class="title">Plans</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="<?php echo route("newPlan") ?>">
                            Add New Plan</a>
                    </li>
                    <li>
                        <a href="<?php echo route("listAllPlans"); ?>">
                            View All Plans</a>
                    </li>
                </ul>
            </li>

        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>