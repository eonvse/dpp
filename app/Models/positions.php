<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Kyslik\ColumnSortable\Sortable;

class positions extends Model
{
    use HasFactory, Sortable;

    protected $fillable = ['name'];
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $sortable = ['name'];

    public function teachers()
    {
        return $this->belongsTo(teachers::class,'idPositions');
    }


}
