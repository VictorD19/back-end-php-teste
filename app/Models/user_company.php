<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Company extends Model
{
    protected $table = 'user_company';
    use HasFactory;
    protected $fillable = ['user_id', 'company_id'];
    protected $hidden =['pivot'];


}
