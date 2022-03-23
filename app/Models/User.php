<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'phone', 'birth_date', 'city'];
    protected $hidden =['pivot'];

    public function companys (){
        return $this->belongsToMany(Company::class);
    }
}
