<?php

Class FaqHelper {

    public static function add_faq($inputs, $id = false) {
       //  dd($inputs['arabicQuestion']);
        if ($id) {
           $data = array(
               'catID' => $inputs['category_id'],
               'Question' => $inputs['question'],
               'Answer' => $inputs['ans'],
               'arabicQuestion' => $inputs['arabicQuestion'],
               'arabicAnswer' => $inputs['arabicAnswer'],
           );
           $faq = Faq::find($id);
           $faq->update($data);
       } else {
           $data = array(
               'catID' => $inputs['category_id'],
               'Question' => $inputs['question'],
               'Answer' => $inputs['ans'],
               'arabicQuestion' => $inputs['arabicQuestion'],
               'arabicAnswer' => $inputs['arabicAnswer'],
           );
           $faq = new Faq($data);


           $faq->save();
       }

        return $faq->id;
    }

    public static function add_faqCat($inputs , $id= false ) {
        $userId = Auth::user()->id;
        if($id) {
            $data = array(
                'Name' => $inputs['name'],
                'Description' => $inputs['description'],
                'arabicName' => $inputs['arabicName'],
                'arabicDescription' => $inputs['arabicDescription'],
                'created_By' => $userId,
                'id' => $id,
            );
            $faqCat = FaqCategories::find($id);
            $faqCat->update($data);
        } else {
            $data = array(
                'Name' => $inputs['name'],
                'Description' => $inputs['description'],
                'arabicName' => $inputs['arabicName'],
                'arabicDescription' => $inputs['arabicDescription'],
                'created_By' => $userId,
            );
            $faqCat = new FaqCategories($data);
            $faqCat->save();
        }
        return $faqCat->id;
    }
    public static $faqVAlidations = array(
        'category_id' => 'required',
        'question' => 'required',
        'ans' => 'required',
    );
    public static $faqCatVAlidations = array(
        'name' => 'required',
        'description' => 'required',
    );


    #======================================= End of CommonHelper Class ===============================
}

