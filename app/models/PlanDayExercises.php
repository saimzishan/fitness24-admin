<?php

class PlanDayExercises extends Eloquent {

    protected $table = 'plandayexercises';
    protected $guarded = array();
    protected $primaryKey = 'id';
    //public $timestamps = false;

    protected $fillable = [
        'plandayID','ExerciseID',
    ];

    public function getExercise($dayID) {
         $result = self::with(['exVideos'])
         	->where('plandayID' , $dayID)
         	->join('exercise','exercise.id','=','plandayexercises.ExerciseID')
         	->join('exercise_videos','exercise_videos.exerciseID','=','plandayexercises.ExerciseID')
         	->select( 'plandayexercises.id', 'plandayexercises.ExerciseID', 'plandayexercises.plandayID','exercise.title','exercise.description','exercise.image', 'exercise_videos.videoID' )
            ->distinct()
            ->get();
        return $result;
    }
    public function exVideos()
    {
        return $this->hasMany(new UserVideo, 'id', 'videoID');
    }

}


