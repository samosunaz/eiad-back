<?php

namespace Eiad\Models;

use Illuminate\Database\Eloquent\Model;


class Lab extends Model
{
  protected $table = 'lab';
  public $incrementing = false;

  public function materials()
  {
    return $this->hasMany('Eiad\Models\Material');
  }

  public function labClasses()
  {
    return $this->hasMany('Eiad\Models\LabClass');
  }

}