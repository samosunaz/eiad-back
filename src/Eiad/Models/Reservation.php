<?php

namespace Eiad\Models;

use Illuminate\Database\Eloquent\Model;


class Reservation extends Model
{
  protected $table = 'reservation';

  public function material()
  {
    return $this->hasOne('Eiad\Models\Material');
  }

}