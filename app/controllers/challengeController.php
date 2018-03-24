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
            return View:: make("challenges.index", compact("plansWithdays"));
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
                $faq = Challenge::where('id','=',$id)->first();
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
                $Chaleng = Challenge::where('id','=',$inputData['challengeId'])->first();
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
}