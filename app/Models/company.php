<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'company';
    protected $fillable = ['name', 'cnpj'];
    public function address(){
        return $this->hasOne(Address::class,'company_id');
    }
    public function user (){
        return $this->belongsToMany(User::class,'user_company','user_id', 'company_id');
    }
}
