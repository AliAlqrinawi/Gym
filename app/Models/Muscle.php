<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Muscle extends Model
{
    use HasFactory;
    protected $table = 'exercises';

    protected $fillable = ['title_ar' , 'title_en' , 'image' , 'status'];

    public function scopeChangeStatus()
    {
        if($this->status == "active"){
            $this->update(['status' => 'inactive']);
        }else{
            $this->update(['status' => 'active']);
        }
    }
}
