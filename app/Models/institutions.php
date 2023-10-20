<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class institutions extends Model
{
    use HasFactory;
    protected $fillable = ['name','fullname','idModerator'];
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function moderator()
    {
        return $this->hasOne(User::class,'id','idModerator');
    }

    
}
