<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = ['parent_id' , 'is_parent' , 'title_ar' , 'title_en' , 'description_ar' , 'description_en' , 'image' , 'id_videos' , 'status'];

    protected $casts = [
        'id_videos' => 'array'
    ];

    public function weekDay()
    {
        return $this->hasMany(Table::class , 'parent_id' , 'id')->where('is_parent' , 'inparent')->with('dayTable');
    }

    public function dayTable()
    {
        return $this->hasMany(Table::class , 'parent_id' , 'id')->where('is_parent' , 'exercise');
    }

    public function scopeChangeStatus()
    {
        if($this->status == "active"){
            $this->update(['status' => 'inactive']);
        }else{
            $this->update(['status' => 'active']);
        }
    }
}
