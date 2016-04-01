<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formfield extends Model
{
    protected $guarded = ['id'];

    protected $table = 'form_fields';

    public function projectID()
    {
        return $this->belongsTo('App\Project');
    }

    public function formGroupDetails()
    {
        return $this->belongsTo('App\Formgroup');
    }
}
