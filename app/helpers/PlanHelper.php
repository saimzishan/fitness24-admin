<?php

Class PlanHelper{

    public static function add_plan($inputs, $id = false) {
       //  dd($inputs['arabicQuestion']);
        if ($id) {
           $data = array(
               'description' => $inputs->description,
               'gender' => $inputs->gender,
               'level' => $inputs->level,
               'arabicDescription' => $inputs->arabicDescription,
               'number_of_weeks' => $inputs->number_of_weeks,

           );
            $plan = Plan::find($id);
            $plan->update($data);
       } else { 
           $data = array(
               'description' => $inputs->description,
               'gender' => $inputs->gender,
               'level' => $inputs->level,
               'arabicDescription' => $inputs->arabicDescription,
               'number_of_weeks' => $inputs->number_of_weeks,
           );
           $plan= new Plan($data);

            $plan->save();
       }

        return $plan;
    }

    public static $PlanVAlidations = array(
        'description' => 'required',
        'gender' => 'required| min: 1',
        'level' => 'required| min: 1',
    );



    #======================================= End of CommonHelper Class ===============================
}

