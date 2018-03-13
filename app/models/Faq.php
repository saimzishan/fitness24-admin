<?php

class Faq extends Eloquent {

    protected $table = 'faq';
    protected $guarded = array();
    protected $primaryKey = 'id';
    //public $timestamps = false;

    protected $fillable = [
        'catID','Question','Answer','like_count','dislike_count','Status','arabicQuestion','arabicAnswer',
    ];
}


