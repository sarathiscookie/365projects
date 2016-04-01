<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formgroup extends Model
{
    protected $guarded = ['id'];

    protected $table = 'form_groups';

    public function projectId()
    {
        return $this->belongsTo('App\Project');
    }
}
