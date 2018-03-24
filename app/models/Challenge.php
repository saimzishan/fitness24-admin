<?php

class Challenge extends Eloquent {

    protected $table = 'challenges';
    protected $primaryKey = 'id';
    public $timestamps = false;

     protected $fillable = [
        'Name','No_Of_Levels',        
    ];


    public function getChallenge()
    {
        $result = self::with(['Levels'])
            ->distinct()
            ->get();
        return $result;
    }

    public function Levels()
    {
        return $this->hasMany(new Challengelevels, 'challengeID', 'id');
    }



// public function getTruckListLoad()
//     {
//         $result = self::with(['getchallengeLevelData', 'getChallengeleveldays'])
//             // ->where('id', $id)
//             ->first();
//         return $result;
//     }
    
    
//     public function getchallengeLevelData()
//     {
//         return $this->hasMany('App\Challengelevels','challengeID','id');
//     }
//      public function getChallengeleveldays()
//     {
//         return $this->hasMany('App\Challengeleveldays','challenge_LevelID','id');
//     }

}
