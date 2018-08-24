<?

namespace Eiad\Models;

use Illuminate\Database\Eloquent\Model;


class LabClass extends Model
{
  protected $table = 'lab_class';
  public $incrementing = false;

  public function asEvent()
  {
    $event = [];
    $event['id'] = $this->id;
    $event['lab_id'] = $this->lab_id;
    $event['title'] = $this->name;
    $event['start'] = $this->starts_at;
    $event['end'] = $this->ends_at;

    $days = [];
    $exploded = explode(',', $this->days);
    foreach ($exploded as $day) {
      $days[] = (int)$day;
    }
    $event['dow'] = $days;

    return $event;
  }

}