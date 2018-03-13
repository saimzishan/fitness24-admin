<?php

class Plan extends Eloquent {

    protected $table = 'plans';
    protected $primaryKey = 'id';
    //public $timestamps = false;

    protected $fillable = [
        'description','gender','level','number_of_weeks','arabicDescription',
    ];
    public function getPlans()
    {
        $result = self::with(['plandays'])
            ->distinct()
            ->get();
        return $result;
    }

    public function plandays()
    {
        return $this->hasMany(new PlanDays, 'planID', 'id');
    }
}


