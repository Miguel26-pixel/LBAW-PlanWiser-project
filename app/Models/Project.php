<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
  public $timestamps  = true;

  protected $table = 'projects';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'title', 'description', 'public', 'active'
  ];

  public function teamMembers()
  {
    return $this->belongsToMany(User::class, 'project_id');
  }

  public function invites()
  {
    return $this->belongsToMany(Client::class, 'invite', 'project_id', 'client_id')->withPivot('accept');
  }

  public function tasks()
  {
    return $this->hasMany(Task::class, 'projects');
  }

  public function getReadableDueDate()
  {
    if ($this->due_date != null) {
      return date("D, j M Y", strtotime($this->due_date));
    }
    return null;
  }


  public function getMemberCount()
  {
    return count($this->teamMembers);
  }


  public function getPendingInvites() {
    return $this->invites()->where('accept', null)->get();
  }
}