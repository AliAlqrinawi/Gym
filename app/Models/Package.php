<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = ['title_ar' , 'title_en' , 'description_en' , 'description_ar' , 'title_duration_ar' , 'title_duration_en' , 'options' , 'duration' , 'price' , 'status'];

    protected $casts = [
        'options' => 'array'
    ];
    public function scopeChangeStatus()
    {
        if($this->status == "active"){
            $this->update(['status' => 'inactive']);
        }else{
            $this->update(['status' => 'active']);
        }
    }
}
