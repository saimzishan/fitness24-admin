<?php

class PlanDayExerciseController extends \BaseController {

    public function index() {
        try {
            $exercise = PlanDayExercises::get();
            return View :: make("plans.index", compact("exercise"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    public function create($id = false) {
        try {
            $videos = PlanDayExercises::paginate(15);
            return View :: make("exercise.addNewExercise", compact("videos" ) );
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }
    public function store() {
        $input = \Illuminate\Support\Facades\Input::all();
        dd($input);
    }
    public function viewAllPlanDayExercise() {
        try {
            $exercise = PlanDayExercises::get();
//            dd($exercise);
            return View :: make("plans.viewPlanDaysExercises", compact("exercise"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }
    public function renderHtml($id) {
        $html = '<table class="table table-striped table-bordered table-hover">';

            $html .= '<thead>';
                $html .= '<tr>';
                    $html .= '<th>' .'PlanDayID'.'</th>';
                    $html .= '<th>' .'Exercise Title'.'</th>';
                    $html .= '<th>' .'Status'.'</th>';
                    $html .= '<th>' .'Action'.'</th>';
                $html .= '</tr>';
            $html .= '</thead>';
                $html .= '<tbody>';
                for($i = 1 ; $i <= $id *7; $i ++) {
                    $html .= '<tr>';
                        $html .= '<td>'.$i.'</td>';
                        $html .= '<td id= "name'.$i.'">' .' '.'</td>';
                        $html .= '<td id="descrip'.$i.'">' .' '.'</td>';
                        $html .= '<td>' .'<button type="button" data-backdrop="static" data-keyboard="false" id="'.$i.'"  name="name'.$i.'" onclick="pickId(this);" class="btn btn-info" data-toggle="modal" data-target="#myModal"> Add Excersize</button> '.'</td>';
                        $html .= '</tr>';
                }
            $html .= '</tbody>';
            $html .= '</table>';
            return ($html);

    }

}