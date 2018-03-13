<?php

class PlanDaysController extends \BaseController {

    public function index() {
        try {
            $exercise = Exercise::get();
            return View :: make("exercise.index", compact("exercise"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }
    public function viewAllPlanDays() {
        try {
            $exercise = PlanDays::get();
            return View :: make("plans.viewPlanDays", compact("exercise"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    public function create($id = false) {
        try {
            $videos = UserVideo::paginate(15);
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
}