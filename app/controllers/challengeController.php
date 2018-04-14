<?php

class challengeController extends \BaseController {

    public function viewAllChallenges() {
        try {
            $plans = new Challenge();
            $plansWithdays = $plans->getChallenge();

   			foreach ($plansWithdays as $key => $val) {

           		foreach ($val->Levels as $ke => $row) {
                     $plansWithdays[$key]->Levels[$ke]['Challengelevelday'] = Challengeleveldays::where('challengeLevelID', '=', $row->id)->get();                           
                   }
            }
             // return $plansWithdays;
            return View:: make("challenges.main", compact("plansWithdays"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

      public function create($id = false) {
        try {
            $faq = null;
            $cNames =  ['name'=> ['--Select--','Push up', 'Sit up', 'Squats'], 'default'=>0];
            if ($id) {
                $temp = new Challenge();
                $faq = Challenge::where('ch_id','=',$id)->first();
            }
            $ex = Exercise::paginate(10);

             // return($cNames['name']);
            return View :: make("challenges.addNewChallenge", compact('ex', 'faq','cNames'));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

     public function store($id = false) {
        $inputData = Request::all();
        // return ($input);
          try {
             $Challenge = new Challenge();  
                $Chaleng = Challenge::where('ch_id','=',$inputData['challengeId'])->first();
             if($Chaleng) {
                // return $Chaleng;
                return \Illuminate\Support\Facades\Redirect::back()->with('message', 'danger= Challenge already exsit' );
             }
            // $inputs = Request::all();

             //...... inserting data in challenge through input.......//
             if ($inputData['challengeId'] == 1 ) {
                $Challenge->Name = 'Push up'; 
             } else if($inputData['challengeId'] == 2) {
                 $Challenge->Name = 'Sit up';
             }else if ($inputData['challengeId'] == 3) {
                 $Challenge->Name = 'Squats';
             }else {
                return \Illuminate\Support\Facades\Redirect::back()->with('message', 'danger= Some thing went wrong, Please try again later' );
             } 
             

             $Challenge->No_Of_Levels = $inputData['No_Of_Levels'];
             $Challenge->ch_id = $inputData['challengeId'];
             
             $Challenge->save();

             $arrayofLevels = [] ;
             
           for ($i = 0; $i < $Challenge->No_Of_Levels ; $i++) { 

            //...... inserting data in Challenge Levels through input.......//
            
                    $Challengelevels = new Challengelevels();

                    $Challengelevels->challengeID = $Challenge->id;
                   
                     $Challengelevels->level = $i+1;

                     $Challengelevels->No_Of_Days = 0;

                     $Challengelevels->save();

                     array_push($arrayofLevels, $Challengelevels);
                }
            return \Illuminate\Support\Facades\Redirect::route('viewAllChallenges')->with('message', 'success= Add Successfully');
         } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }            
     }    

     public function renderNewHtml($id , $chid) {
        $html = '<table class="table table-striped table-bordered table-hover">';

            $html .= '<thead>';
                $html .= '<tr>';
                    $html .= '<th>' .'Secquence'.'</th>';
                    $html .= '<th>' .'Challenge Id'.'</th>';
                    $html .= '<th>' .'No of days'.'</th>';
                $html .= '</tr>';
            $html .= '</thead>';
                $html .= '<tbody>';
                for($i = 1 ; $i <= $id; $i ++) {
                    $html .= '<tr>';
                        $html .= '<td>'.$i.'</td>';
                        $html .= '<td id= "chid'.$i.'">' .$chid.'</td>';
                        $html .= '<td>' .'<div class="input-group" style="width: 80%"><input class="form-control" name="numberOfWeek" id="no_of_days'.$id.'" type="number"></div>'.'</td>';
                        $html .= '</tr>';
                }
            $html .= '</tbody>';
            $html .= '</table>';
            return ($html);

    }
    public function storeLevel() {
        try {
             $inputData = Request::all();
             // return $inputData;
             if($inputData['No_Of_Days'] == '') {
                return \Illuminate\Support\Facades\Redirect::back()->with('message', 'danger= Validation error No of day required' );

             } else if($inputData['No_of_Sets'] <= 0) {
                return \Illuminate\Support\Facades\Redirect::back()->with('message', 'danger= Validation error, No of Sets must be greater then 0 ' );                
             }
              $Chaleng = Challengelevels::where('id','=',$inputData['challgId'])->first();
              if(!$Chaleng) {
                 return \Illuminate\Support\Facades\Redirect::back()->with('message', 'danger= Some thing went wronge' );
              } else {
                $Chaleng->No_Of_Days = $Chaleng->No_Of_Days + $inputData['No_Of_Days'];
                $Chaleng->update();
              }
               for ($i = 1; $i <= $inputData['No_Of_Days'] ; $i++) {
                    $obj = new Challengeleveldays();
                    $obj->challengeLevelID = $inputData['challgId'];
                    $obj->DaySeq = $i;
                    $obj->No_of_Sets = $inputData['No_of_Sets'];
                    $obj->Repetition = 0;
                    $obj->save();
                }   
            return \Illuminate\Support\Facades\Redirect::back()->with('message', 'success= Successfully add..' );
         } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }  
    }

    public function updateDays() {
          try {
             $inputData = Request::all();
             // return $inputData;
               $Chaleng = Challengeleveldays::where('id','=',$inputData['dayID'])->first();
              if(!$Chaleng) {
                 return \Illuminate\Support\Facades\Redirect::back()->with('message', 'danger= Some thing went wronge' );
              } else if($inputData['Repetition'] <= 0) {
                return \Illuminate\Support\Facades\Redirect::back()->with('message', 'danger= Validation error, Repetition must be greater then 0 ' );                
             }
             // return $Chaleng;
               $Chaleng->Repetition = $Chaleng->Repetition + $inputData['Repetition'];
                $Chaleng->update();

         return \Illuminate\Support\Facades\Redirect::back()->with('message', 'success= Successfully updated..' );
         } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }  
    }
    public function deleteChallenge($id) {
         try {
            $preCheck = DB::table('userchallenges')->where('challengeID','=',$id )->get();
            if($preCheck){
                            return \Illuminate\Support\Facades\Redirect::back()->with('message', 'danger= Could not be delete, already assigned to user' );;

            }
            Challenge::destroy($id);
            return \Illuminate\Support\Facades\Redirect::back()->with('message', 'success= Successfully Deleted..' );;
        } catch (Exception $ex) {
        return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    public function updateChallenge() {
         try {
            $inputData = Request::all();

            $challenges = Challenge::find($inputData['challengeID']);
             // return $challenges;

            if(!$challenges ){
                return \Illuminate\Support\Facades\Redirect::back()->with('message', 'danger= Record Not found..' );
            }
            $data = [
                    'No_Of_Levels' => $inputData['No_Of_Levels']
                    ];
            $countCheck = $inputData['No_Of_Levels'] - $challenges->No_Of_Levels;
            $challenges->update($data);
            for ($i = 0; $i < $countCheck;  $i++) { 
            
                    $Challengelevels = new Challengelevels();

                    $Challengelevels->challengeID = $challenges->id;
                   
                     $Challengelevels->level = $i+1;

                     $Challengelevels->No_Of_Days = 0;

                     $Challengelevels->save();
                }
            return \Illuminate\Support\Facades\Redirect::back()->with('message', 'success= Successfully updated..' );    
        } catch (Exception $ex) {
        return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

     public function deleteChallengeLevel($id) {
         try {

                $preCheck = DB::table('userchallengelevels')->where('userchallengeID','=',$id )->get();
            if($preCheck){
                            return \Illuminate\Support\Facades\Redirect::back()->with('message', 'danger= Could not be delete, already assigned to user' );;

            }

             $del = Challengelevels::find($id);
             $temp = Challenge::find($del['challengeID']);
             $temp->No_Of_Levels = $temp->No_Of_Levels - 1;
             $temp->update();

            Challengelevels::destroy($id);
            return \Illuminate\Support\Facades\Redirect::back()->with('message', 'success= Successfully Deleted..' );;
        } catch (Exception $ex) {
        return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    //  public function updateChallengeLevel($id) {
    //      try {
    //         $challengesLevel = Challengelevels::find($id);
    //         if(!$challengesLevel ){
    //             return \Illuminate\Support\Facades\Redirect::back()->with('message', 'danger= Record Not found..' );
    //         }
    //         $data = [
    //                 'level' => $challengesLevel->level + $request->input('level'),
    //                 'No_Of_Days' => $challengesLevel->No_Of_Days + $request->input('No_Of_Days')
    //                 ];
    //         $challengesLevel->update($data);
    //         return \Illuminate\Support\Facades\Redirect::back()->with('message', 'success= Successfully updated..' );  
    //     } catch (Exception $ex) {
    //     return CommonHelper::showException($ex);
    //     } catch (Illuminate\Database\QueryException $ex) {
    //         return CommonHelper::showException($ex);
    //     }
    // }

     public function deleteChallengeLevelDays($id) {
         try {
            $preCheck = DB::table('userchallengeleveldays')->where('user_challenge_LevelID','=',$id )->get();
            if($preCheck){
                            return \Illuminate\Support\Facades\Redirect::back()->with('message', 'danger= Could not be delete, already assigned to user' );;

            }
            $del = Challengeleveldays::find($id);
            $temp = Challengelevels::find($del['challengeLevelID']);
            $temp->No_Of_Days = $temp->No_Of_Days - 1;
             $temp->update();
            
            Challengeleveldays::destroy($id);
            return \Illuminate\Support\Facades\Redirect::back()->with('message', 'success= Successfully Deleted..' );
        } catch (Exception $ex) {
        return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    public function updateChallengeLevelDays() {
         try {
             $inputData = Request::all();
              // return $inputData;
             if($inputData['No_of_Sets'] <= 0) {
                return \Illuminate\Support\Facades\Redirect::back()->with('message', 'danger= Validation error, No of set must be greater then 0 ..' );
             } else if($inputData['Repetition'] <= 0) {
                return \Illuminate\Support\Facades\Redirect::back()->with('message', 'danger= Validation error, Repetition must be greater then 0 ..' );
             }
             $challengesLevelDays = Challengeleveldays::find($inputData['id']);
            if(!$challengesLevelDays ){
                return \Illuminate\Support\Facades\Redirect::back()->with('message', 'danger= Record Not found..' );
            }
            // return $challengesLevelDays;
            $challengesLevelDays->No_of_Sets = $inputData['No_of_Sets']; 
            $challengesLevelDays->Repetition =  $inputData['Repetition'];
            $challengesLevelDays->update();
            return \Illuminate\Support\Facades\Redirect::back()->with('message', 'success= Successfully updated..' );  
        } catch (Exception $ex) {
        return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

}