<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'cnpj','address_id'];
    public function address(){
        return $this->hasOne(Company::class,'address_id');
    }

}