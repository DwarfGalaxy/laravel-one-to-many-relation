<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable=['title','slug','description'];
    public function blog_info(){
        return $this->hasMany(BlogInfo::class);
    }
}
