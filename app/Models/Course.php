<?php

namespace App\Models;

use App\Models\User;
use App\Models\Sales;
use App\Models\Workshop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    public function workshop()
    {
        return $this->belongsTo(Workshop::class, 'workshop_id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'course_user');
    }
    
    public function sales()
    {
        return $this->belongsToMany(Sales::class, 'course_sales');
    }
}
