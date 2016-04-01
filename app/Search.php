<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $guarded = ['id'];

    protected $table   = 'search';
    public $timestamps = false;
}
