<?php

class Exercise extends Eloquent {

    protected $table = 'exercise';
    protected $primaryKey = 'id';
    //public $timestamps = false;

    protected $fillable = [
        'title','Ex_Description','arabicTitle','image','arabicDescription','duration','workout_time',
    ];

    public function excer($id)
    {
        $result = self::with(['video'])
        	->where('id','=', $id)
        	->select('id')
            ->first();
        return $result;
    }

    public function video() {
        return $this->hasMany(new ExerciseVideos ,'exerciseID', 'id');
    }

}


