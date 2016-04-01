<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formvalue extends Model
{
    protected $guarded = ['id'];

    protected $table = 'form_values';

    public function formValues()
    {
        return $this->belongsTo('App\Formfield');
    }

}
