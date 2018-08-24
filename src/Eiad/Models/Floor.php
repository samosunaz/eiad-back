<?

namespace Eiad\Models;

use Illuminate\Database\Eloquent\Model;


class Floor extends Model
{
  protected $table = 'floor';
  public $incrementing = false;

  public function labs()
  {
    return $this->hasMany('Eiad\Models\Lab');
  }
}