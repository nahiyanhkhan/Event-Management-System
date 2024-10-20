<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Allow mass assignment of the following fields
    protected $fillable = [
        'title',
        'description',
        'date',
        'time',
        'location',
        'category',
    ];
}
