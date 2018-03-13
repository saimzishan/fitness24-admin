<?php

class ExerciseVideos extends Eloquent {

    protected $table = 'exercise_videos';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'videoID','exerciseID','name',
    ];

    public function relatedVideos($id)
    {
          return $this->hasMany(new ExerciseVideos ,'id');
    }

    public function exerciseVideo() {
        return $this->hasMany(new UserVideo ,'id', 'videoID');
    }

}


