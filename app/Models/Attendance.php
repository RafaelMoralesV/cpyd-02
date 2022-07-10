<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    /**
     * Does the model need to manage Timestamps (i.e. created_at and updated_at).
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [
        'classroom',
        'subject',
        'email',
        'entrance',
        'leaving',
    ];

    protected $hidden = ['id'];
}
