<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Kyslik\ColumnSortable\Sortable;

class teachers extends Model
{
    use HasFactory, Sortable;

    protected $fillable = ['name','surname','patronymic','idPositions','idInstitutions','idType','dateDoc','idUser','idAutor','idUpdater'];
    protected $primaryKey = 'id';

    public $sortable = ['surname','name'];

    public function courses()
    {
        return $this->hasMany(courses::class,'idTeachers','id');
    }

    public function institution()
    {
        return $this->hasOne(institutions::class,'id','idInstitutions');
    }

    public function position()
    {
        return $this->hasOne(positions::class,'id','idPositions');
    }

    public function document()
    {
        return $this->hasOne(typeDocs::class,'id','idType');
    }

    public function User()
    {
        return $this->hasOne(User::class,'id','idUser');
    }


    public function Autor()
    {
        return $this->hasOne(User::class,'id','idAutor');
    }

    public function Updater()
    {
        return $this->hasOne(User::class,'id','idUpdater');
    }

}
