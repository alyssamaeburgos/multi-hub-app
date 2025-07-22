<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',  // ✅ Add this to allow mass assignment
        'title',
        'description',
        'deadline',
        'status',
    ];

    protected $casts = [
        'start' => 'datetime:Y-m-d H:i:s',
        'deadline' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
