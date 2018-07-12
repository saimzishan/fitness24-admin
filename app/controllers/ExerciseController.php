<?php

class ExerciseController extends \BaseController {

    public function index() {
        try {
            $exercise = Exercise::get();

            if(count($exercise)>0) {

                foreach ($exercise as $key => $val) {
                         $exercise[$key]['excerciseVideo'] = ExerciseVideos::where('exerciseID', '=', $val->id)
                        ->join('videos', 'videos.id', '=', 'exercise_videos.videoID')
                        ->select('videos.*' ,'exercise_videos.id as evId')
                        ->get();
                }
                 // return  $exercise;
                return View::make("exercise.index", compact("exercise"));
            }
            else{
                $exercise = Exercise::get();
                return View:: make("exercise.emptyExercise.blade", compact("exercise"));
//                return 'No Exercise Exist in the System';
            }
        }
        catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    public function create($id = false) {
        try {
            $faq = null;
            if ($id) {
                $faq = Exercise::where('id','=',$id)->first();

                // return $faq;
            }
            $videos = UserVideo::all();
            return View :: make("exercise.addNewExercise", compact("videos", "faq" ) );
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }
     public function getAllVideos($id) {
        try {
            $exID = $id;
            $relatedVideoData = ExerciseVideos::where('exerciseID', '=', $id)
                        ->join('videos', 'videos.id', '=', 'videoID')
                        ->select('videos.id')
                        ->get();
             $videos = UserVideo::all();
             // return $relatedVideoData;
             return View :: make("exercise.linkVideoToExercise", compact("videos", "relatedVideoData", 'exID' ) );
           //  return $mainArray;
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }
    public function getAllExercse($id) {
        try {
            $dayID = $id;
            $relatedExData =  PlanDayExercises::where('plandayID', '=', $id)
                        ->join('exercise', 'exercise.id', '=', 'ExerciseID')
                        ->select('exercise.id')
                        ->get();
             $Exercise = Exercise::all();
              // return $Exercise;
             return View :: make("plans.linkExerciseToPlanDay", compact("Exercise", "relatedExData", 'dayID' ) );
           //  return $mainArray;
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

      public function postlinkedVideos($id) {
        $input = Input::all();
       
         $temp = json_decode($input['body']);
           // return $temp->exerciseIDs;
         try { 
             // return $temp;
            \Illuminate\Support\Facades\DB::table('exercise_videos')
                                ->where('exerciseID','=',$id)
                                ->delete();

             // return $temp;
           $dataAray = [];
            for ($i=0; $i<count($temp->exerciseIDs); $i++) {
               array_push($dataAray, 
                            array('videoID'=>$temp->exerciseIDs[$i], 'exerciseID'=>$id)
                        );
            }
            // return  $dataAray;
             $ExVideo = ExerciseVideos::insert($dataAray);
              return  json_encode($ExVideo);
         } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
     }     
      public function postlinkedExs($id) {
        $input = Input::all();
       
         $temp = json_decode($input['body']);
           // return $temp->exerciseIDs;
         try { 
             // return json_encode($temp);
            \Illuminate\Support\Facades\DB::table('plandayexercises')
                                ->where('plandayID','=',$id)
                                ->delete();

             // return $temp;
           
            for ($i=0; $i<count($temp->exerciseIDs); $i++) {
                $dayEx = new PlanDayExercises();

                $dayEx->ExerciseID = $temp->exerciseIDs[$i];
                $dayEx->plandayID = $id;

                $dayEx->save();

            }

         } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
         return json_encode('success');
     }

    public function base64_to_jpeg($base64_string) {
        // open the output file for writing


        // open the output file for writing
                $time = time();
        $random = Str::random(5);
        // $ext_array =explode( ',', $base64_string );
        $imgdata = base64_decode($base64_string);

        // $data = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAA.';
        $pos  = strpos($base64_string, ';');
        $type = explode(':', substr($base64_string, 0, $pos));
        $type = explode('/', $type[1]);

        // return $type;
        $fill = explode( ',', $base64_string );
        $data = base64_decode($fill[1]);
        $name = $random . $time . '.' . $type[1];
        
         $image_destination = CommonHelper::$driver['local_img_path'] . $name;


            $res = file_put_contents($image_destination, $data );

        return $name;
    }

    public function store($id = false) {
        $input = Input::all();
         $temp = json_decode($input['body']);
         try {
            //  return json_encode($temp->title);
             $Exercise = new Exercise();
            if($id) {
                $Exercise= Exercise::where('id','=',$id)
                    ->first();
            }
            $Exercise->title = $temp->title;
            $Exercise->description = $temp->description;
            $Exercise->arabicTitle = $temp->arabicTitle;
            $Exercise->arabicDescription = $temp->arabicDescription;
            $Exercise->duration = $temp->duration;
            $Exercise->workout_time = $temp->workoutTime;

            if($id) {
                $Exercise->update();
            } else {
                       $data = $temp->file;
                    
  //            $time = time();
  //            $random = Str::random(5);
  //            $name = $random.$time.".jpeg";


             $file = $this->base64_to_jpeg($data);
             $Exercise->image = $file;
                $Exercise->save();

                $getID = $Exercise->id;

               $dataAray = [];
                for ($i=0; $i<count($temp->exerciseIDs); $i++) {
                        array_push($dataAray, 
                            array('videoID'=> $temp->exerciseIDs[$i], 'exerciseID'=>$getID)
                        );
                }
                 $dayEx =  ExerciseVideos::insert($dataAray);
            }
        }catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
        return json_encode('success');

    }


    public function getRelatedVideos($id) {

        try {
            $videoData = \Illuminate\Support\Facades\DB::table('exercise_videos')->where('exerciseID','=',$id)
                        ->join('videos', 'videos.id','=','exercise_videos.videoID')
                        ->select('videos.*','exercise_videos.id as exersizeID')
                        ->get();
            $mainArray = [];
            for ($i = 0; $i < count($videoData); $i++ ) {

                $data = [];
                array_push($data, $videoData[$i]->exersizeID);
                array_push($data, $videoData[$i]->title_en);
                array_push($data, $videoData[$i]->title_ar);
                array_push($data, $videoData[$i]->description_en);
                array_push($data, $videoData[$i]->description_ar);
                array_push($data,
                    '<img src="https://s3.amazonaws.com/fitness24-bucket/Images/'.$videoData[$i]->thumb.'" width="80"/>'
                            );
                array_push($data, ' <button type="button" style="text-decoration:none; color: #ff0000" onclick="removeExerciseVideo(this);" id="'.$videoData[$i]->exersizeID.'"  title="Delete">
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
    public function removeExerciseVideo($id)
    {
        try {
            ExerciseVideos::destroy($id);
            return \Illuminate\Support\Facades\Redirect::back()->with('message', "success= Deleted Successfully.");;
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    public function deleteExercise($id)
    {
        try {
            Exercise::destroy($id);
            return \Illuminate\Support\Facades\Redirect::back()->with('message', "success= Deleted Successfully.");;
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }
    public function deleteExerciseOfDay($id)
    {
        try {
            dd($id);
            PlanDayExercises::destroy($id);
            return \Illuminate\Support\Facades\Redirect::back()->with('message', "success= Deleted Successfully.");
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

}