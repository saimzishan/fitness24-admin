
<?php

class GoalsController extends \BaseController {

    
    public function goals() {
        try {
            $goals = Goal::get();
            return View :: make("goals.all_goals", compact("goals"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }
    
    public function edit_goal($id) {
        try {
            $goal = Goal::where('id', '=', $id)->first();
            return View :: make("goals.edit_goal", compact("goal"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }
    
    public function update_goal() {
        try {
            $inputs = Input::all();
            $goal = Goal::where('id', '=', $inputs['id'])->first();
            $goal->title_en = $inputs['title_en'];
            $goal->title_ar = $inputs['title_ar'];
            
            return ($goal->save()) 
                ? Redirect::route('goals')->with('message', "success= Goal Updated Successfully.")
                : Redirect::back()->withInput(Input::except('password'))->with('message', "danger= Goal Not Updated, Try again!"); 
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }

    public function makeFaq() {
        try {
            $faq = Faq::get();
            return View :: make("faq.index", compact("faq"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }
    public function makeFaqCat() {
        try {
            $faq = FaqCategories::get();
            return View :: make("faqcat.index", compact("faq"));
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }
    public function addFaq($id = false) {
        try {
            $faq = null;
            if($id) {
                $faq  = DB::table('faq')
                    ->where('id', $id)
                    ->first();
               // dd($faq);
            }
            $faqcategories  = DB::table('faqcategories')
                ->select('id', 'Name')
                ->get();
            // dd($faqcategories);

            foreach ($faqcategories as $category) {
//                dd($category->Name);
                $categories[] = array('title' => $category->Name, 'id' => $category->id);
            }
            // dd($faq);
            return View :: make("faq.addNewFaq" , compact('faq', 'categories') );
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }
    public function addFaqCat($id = false) {
        try {
//            dd($inputs);
            $faq = null;
            if($id) {
                $faq  = DB::table('faqcategories')
                    ->where('id', $id)
                    ->first();
               // dd($faq);
            }
            // dd($faq->Description);
            return View :: make("faqcat.addNewFaqCat")->with('faq' , $faq);
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }
    public function post_faq() {
        try {
            $inputs = Input::all();
             // dd($inputs);
            $validation =  Validator::make($inputs, FaqHelper::$faqVAlidations);
            if ($validation->fails()) {
                // dd($validation->errors());
                return( Redirect::back()->with('message', $validation->errors()) );
            }
            if (!empty($inputs['id'] )) {
                // dd($inputs['id']);
                $add = FaqHelper::add_faq($inputs, $inputs['id'] );
            } else {
                // dd($inputs);
                $add = FaqHelper::add_faq($inputs);
            }

            if(!empty($add)){
                    return Redirect::to('listAllFaq')->with('message', "success= FAQ added Successfully.");
            }
        }
        catch (Exception $ex) {
            return CommonHelper::showException($ex);
        }
    }
    public function deleteFaq($id) {

        $temp = Faq::find($id);
        $temp->delete($id);
        return( Redirect::back()->with('message',"success=Deleted Successfully" ) );
    }
    public function deleteFaqCat($id) {

        $temp = FaqCategories::find($id);
        $temp->delete($id);
        return( Redirect::back()->with('message',"success=Deleted Successfully" ) );
    }
    public function post_faqCat() {
        try {
            $inputs = Input::all();
            // dd($inputs);
            $validation =  Validator::make($inputs, FaqHelper::$faqCatVAlidations);

            if ($validation->fails()) {
                // dd($validation->errors());
                return( Redirect::back()->with('message', $validation->errors()) );
            }
            if(isset($inputs['id']) ){
                $add = FaqHelper::add_faqCat($inputs, $inputs['id']);
            } else {
                $add = FaqHelper::add_faqCat($inputs);
            }

            if(!empty($add)){
                 return Redirect::to('listAllFaqCat')->with('message', "success= FAQ Category added Successfully.");
            }
        }
        catch (Exception $ex) {
            return CommonHelper::showException($ex);
        }
    }
     ////////      Function for Exercise        /////////
    public function newExercise($id = false) {
        try {
//            dd($inputs);
            $faq = null;
            if($id) {
                $faq  = DB::table('faqcategories')
                    ->where('id', $id)
                    ->first();
                // dd($faq);
            }
            // dd($faq->Description);
            return View :: make("faqcat.addNewFaqCat")->with('faq' , $faq);
        } catch (Exception $ex) {
            return CommonHelper::showException($ex);
        } catch (Illuminate\Database\QueryException $ex) {
            return CommonHelper::showException($ex);
        }
    }


}