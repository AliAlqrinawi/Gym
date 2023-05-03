<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    use HasFactory;

    protected $fillable = ['title_ar' , 'title_en' , 'sud_title_ar' , 'sud_title_en' , 'description_ar', 'description_en' , 'image' , 'layout'];

}
