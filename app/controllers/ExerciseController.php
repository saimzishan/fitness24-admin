<?php

class ExerciseController extends \BaseController {

    public function index() {
        try {
            $exercise = Exercise::get();

            if(count($exercise)>0) {

                foreach ($exercise as $key => $val) {
                         $exercise[$key]['excerciseVideo'] = ExerciseVideos::where('exerciseID', '=', $val->id)
                        ->join('videos', 'videos.id', '=', 'exercise_videos.videoID')
                        ->select('videos.*')
                        ->get();
                }
                 // return  $exercise;
                return View:: make("exercise.index", compact("exercise"));
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
           
            for ($i=0; $i<count($temp->exerciseIDs); $i++) {
                $ExVideo = new ExerciseVideos();

                $ExVideo->videoID = $temp->exerciseIDs[$i];
                $ExVideo->exerciseID = $id;

                $ExVideo->save();

            }

         } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
         return json_encode('success');
     }

    public function base64_to_jpeg($base64_string,$dirPath, $output_file) {
        // open the output file for writing

        if(!is_dir($dirPath)){
            mkdir($dirPath, 0777, true);
        }
        $ifp = fopen( $output_file, 'wb' );

        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64_string );

        // we could add validation here with ensuring count( $data ) > 1
        fwrite( $ifp, base64_decode( $data[ 1 ] ) );

        // clean up the file resource
        fclose( $ifp );

        return $output_file;
    }

    public function store($id = false) {
        $input = Input::all();
         // return $input;
         $temp = json_decode($input['body']);
         try {
            //  return json_encode($temp->title);
             $Exercise = new Exercise();
            if($id) {
                $Exercise= Exercise::where('id','=',$id)
                    ->first();
            }
              $data = $temp->file;

             $time = time();
             $random = Str::random(5);
             $name = $random.$time.".jpeg";



             $file = $this->base64_to_jpeg($data, public_path('uploads/'), public_path('uploads/'.$name));

            $Exercise->image = $name;
            $Exercise->title = $temp->title;
            $Exercise->description = $temp->description;
            $Exercise->arabicTitle = $temp->arabicTitle;
            $Exercise->arabicDescription = $temp->arabicDescription;
            $Exercise->duration = $temp->duration;
            $Exercise->workout_time = $temp->workoutTime;

            if($id) {
                $Exercise->update();
            } else {
                $Exercise->save();

                $getID = $Exercise->id;

                for ($i=0; $i<count($temp->exerciseIDs); $i++)
                {
                    $ExVideo = new ExerciseVideos();

                    $ExVideo->videoID = $temp->exerciseIDs[$i];
                    $ExVideo->exerciseID = $getID;

                    $ExVideo->save();

                }
            }
    } catch (Exception $ex) {
        return ($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return ($ex);
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
            return \Illuminate\Support\Facades\Redirect::back();
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
            return \Illuminate\Support\Facades\Redirect::back();
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

}