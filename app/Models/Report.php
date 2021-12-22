<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
  public $timestamps  = true;

  protected $table = 'report';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'text', 'user_id', 'report_state', 'report_type'
  ];


  public function reported()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function notifications()
  {
    return $this->hasMany(Notification::class, 'report');
  }

}