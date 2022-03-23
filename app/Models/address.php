<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'address';
    protected $hidden = ['created_at','id','updated_at','company_id'];

    protected $fillable = [ 'street','city','state','company_id'];
    
}
