<?php

class FaqCategories extends Eloquent {

    protected $table = 'faqcategories';
    protected $guarded = array();
    protected $primaryKey = 'id';
    //public $timestamps = false;

    protected $fillable = [
        'Name','Description','created_By','updated_By','arabicName','arabicDescription',
    ];
}


