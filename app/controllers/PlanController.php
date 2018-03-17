<?php

class PlanController extends \BaseController {

    public function index() {
        try {
            $plans = new Plan();
            $plansWithdays = $plans->getPlans();

            //  return  $plansWithdays;

            // $exercisesWithVideo = new PlanDayExercises();
             // return $exercisesWithVideo;
            foreach ($plansWithdays as $key => $val) {

                    foreach ($val->plandays as $ke => $row) {
                     $plansWithdays[$key]->plandays[$ke]['dayExercise'] = PlanDayExercises::where('plandayID', '=', $row->id)
                                                                            ->join('exercise', 'exercise.id', '=', 'ExerciseID')
                                                                            ->select('exercise.id as ExerciseID', 'plandayexercises.*')
                                                                          ->get();

                        foreach ($row->dayExercise as $k => $r) { 
                            $plansWithdays[$key]->plandays[$ke]->dayExercise[$k]['exVideos'] = ExerciseVideos::where('ExerciseID', '=', $r->ExerciseID)
                                ->join('videos', 'videos.id', '=', 'exercise_videos.videoID')
                                ->get();
                            }                                                     
                    }
            }

            // return $plansWithdays;
            // $exercise = Plan::get();
            return View :: make("plans.index", compact("plansWithdays"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    public function create($id = false) {
        try {
            $faq = null;
            if ($id) {
                $temp = new Plan();
                $faq = Plan::where('id','=',$id)->first();
            }
            $ex = Exercise::paginate(10);

            // return($ex);
            return View :: make("plans.addNewPlan", compact('ex', 'faq'));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }
    public function store($id = false) {

        $input = \Illuminate\Support\Facades\Input::all();

        $temp = json_decode($input['body']);
         //return json_encode($temp->mainData); 
        if($id) {
            // return json_encode($temp);
            $planDays = PlanHelper::add_plan($temp, $id);
            $c = 0;
        } else {
            $check = Plan::where('level','=',$temp->level)
                ->where('gender','=',$temp->gender)
                ->first();

            if ($check) {
                return 0;
            }
            $addPlan = PlanHelper::add_plan($temp);
            $totalDays = $addPlan->number_of_weeks *7;
            $planDays = '';
            $c = 0;

         $CreatedplanDaysArray = [];
            if ($addPlan) {
                // adding plan days
                for ($i = 1; $i <= $totalDays; $i++ ) {
                    $planDays = new PlanDays();

                    $planDays->planID = $addPlan->id;
                    $planDays->dayID = $i;
                    DB::beginTransaction();
                      try 
                      { 
                       

                       $planDays->save();

                        $tempPlanDay = $planDays;
                        array_push($CreatedplanDaysArray, $tempPlanDay->id);


                        DB::commit();
                     } 
                     
                     catch (\Exception $e) {
                        DB::rollback();
                        $c = 1;
                    }  
                } 

                 // dd($temp);

                // adding plan days Excercises
                for ($i = 0; $i < count($temp->mainData) ; $i++ ) {
                   $planDayExcer = new PlanDayExercises();

                    $planDayExcer->ExerciseID = $temp->mainData[$i]->exercizeId;
                    $planDayID = $temp->mainData[$i]->DayId;
                    $planDayIDtemp = $planDayID -1;
                    // dd($planDayID);
                    $planDayExcer->plandayID = $CreatedplanDaysArray[$planDayIDtemp];


                     // DB::beginTransaction();
                     //  try 
                     //  { 
                        $planDayExcer->save();

                     //    DB::commit();
                     // } catch (\Exception $e) {
                     //    return $e;
                     //    DB::rollback();
                        $c = 1;
                    // }  
                }      
            }
        }
        if ($c === 0) {
            return $planDays;
        } else {
             return 1;
        }
       
    }
    public function destroy($id)
    {
        try {
            Plan::destroy($id);
            return \Illuminate\Support\Facades\Redirect::back();
        } catch (Exception $ex) {
        return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }



    public function renderPlanDays($id) {
        try {
            $daysData = PlanDays::where('planID','=',$id)->get();
            $mainArray = [];
            // return count($daysData);
            for ($i = 0; $i < count($daysData); $i++ ) {

                $data = [];
                array_push($data, $daysData[$i]->id);
                array_push($data, $daysData[$i]->dayID);
                array_push($data, ' <button type="button" style="text-decoration:none; color: #ff0000" onclick="deletePlandays(this);" id="'.$daysData[$i]->id.'"  title="Delete">
                                       Remove<div class="fa fa-trash-o"></div>
                                    </button>
                                    ' );
                array_push($mainArray, $data);

            }
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
        return $mainArray;
    }

    public function destroyPlandays($id) {
        try {
            PlanDays::destroy($id);
            return \Illuminate\Support\Facades\Redirect::back();
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }
}