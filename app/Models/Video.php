<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ['title_ar' , 'title_en' , 'sex' ,
    'fitness_level' , 'type' , 'video' , 'alternative_video' ,
    'exercise_id' , 'image' , 'status' , 'is_+18'];

    public function scopeChangeStatus()
    {
        if($this->status == "active"){
            $this->update(['status' => 'inactive']);
        }else{
            $this->update(['status' => 'active']);
        }
    }
}
