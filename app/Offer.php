<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'facility_id'];

    //protected $dates = ['published_at', 'unpublished_at']; //For run normal carbon functions

    public function facilitiesId()
    {
        return $this->belongsTo('App\Facility');
    }
}
