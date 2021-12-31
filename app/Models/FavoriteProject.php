<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteProject extends Model
{
    use HasCompositePrimaryKey;
    public $timestamps  = false;

    protected $table = 'favoriteprojects';

    protected $primaryKey = ['user_id', 'project_id'];

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
       'user_id', 'project_id'
    ];
}
