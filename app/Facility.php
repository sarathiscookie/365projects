<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    //
    protected $guarded = ['id'];

    protected $table = 'facilities';

    public function facilityuser()
    {
        return $this->belongsTo('App\User');
    }

    public function facilityproject()
    {
        return $this->belongsTo('App\Project');
    }
}
