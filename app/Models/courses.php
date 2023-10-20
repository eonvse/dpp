<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Kyslik\ColumnSortable\Sortable;

class courses extends Model
{
    use HasFactory, Sortable;
    protected $fillable = ['idTeachers','idType','idTypeDoc','dateDoc','hours','fullName','progName','idDirections','isFederal','idAutor','idUpdater'];
    protected $primaryKey = 'id';

    public $sortable = ['fullName','progName','dateDoc','updated_at'];

    public function courseType()
    {
        return $this->hasOne(courseType::class,'id','idType');
    }

    public function courseTypeDoc()
    {
        return $this->hasOne(typeDocs::class,'id','idTypeDoc');
    }

    public function courseDirection()
    {
        return $this->hasOne(courseDirections::class,'id','idDirections');
    }

    public function Autor()
    {
        return $this->hasOne(User::class,'id','idAutor');
    }

    public function Updater()
    {
        return $this->hasOne(User::class,'id','idUpdater');
    }

    public function Teacher()
    {
        return $this->belongsTo(teachers::class,'idTeachers','id');
    }


}
