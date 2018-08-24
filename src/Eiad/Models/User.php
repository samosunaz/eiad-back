<?php
namespace Eiad\Models;

use Illuminate\Database\Eloquent\Model;


class User extends Model
{
  protected $table = 'user';
  public $incrementing = false;
  
  public function getDetails()
  {
    $details = [];
    $details['id'] = $this->id;
    $details['first_name'] = $this->first_name;
    $details['last_name'] = $this->last_name;
    $details['email'] = $this->email;
    $details['roles'] = $this->roles->map(function ($role, $key) {
      return $role->type;
    });
    return $details;
  }

  public function roles()
  {
    return $this->belongsToMany('\Eiad\Models\Role');
  }
}