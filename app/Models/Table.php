<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = ['parent_id' , 'title_ar' , 'title_en' , 'description_ar' , 'description_en' , 'image' , 'id_videos' , 'status'];

    public function scopeChangeStatus()
    {
        if($this->status == "active"){
            $this->update(['status' => 'inactive']);
        }else{
            $this->update(['status' => 'active']);
        }
    }
}
