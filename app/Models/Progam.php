<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progam extends Model
{
    protected $table= 'programs';

    protected $fillable = [
        'name',
        'description'
    ];

    

}
