<?php

namespace Eiad\Models;

use Illuminate\Database\Eloquent\Model;


class Material extends Model
{
  protected $table = 'material';
  public $incrementing = false;

  public function getDetails()
  {
    $details = [];
    $details['id'] = $this->id;
    $details['name'] = $this->name;
    $details['brand'] = $this->brand;
    $details['model'] = $this->model;
    $details['lab'] = $this->lab_id;
    return $details;
  }
  public function lab()
  {
    return $this->belongsTo('Eiad\Models\Lab');
  }
}