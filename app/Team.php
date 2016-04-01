<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    //
    //
    protected $guarded = ['id'];

    protected $table   = 'facility_teams';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function teamfacility()
    {
        return $this->belongsTo('App\Facility');
    }
}
