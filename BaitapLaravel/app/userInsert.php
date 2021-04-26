<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userInsert extends Model
{
    //
    protected $table = 'user_details';
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user', 'user_name','email', 'address',
    ];
}
