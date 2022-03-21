<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'phone', 'birth_date', 'city'];

    public function company (){
        return $this->belongsToMany(Company::class,'user_company','user_id', 'company_id');
    }
}
