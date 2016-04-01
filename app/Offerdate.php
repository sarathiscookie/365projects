<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offerdate extends Model
{
    protected $guarded = ['id', 'offer_id'];

    protected $table = 'offer_dates';

    public $timestamps = false;

    public function offer()
    {
        return $this->belongsTo('App\Offer');
    }
}
