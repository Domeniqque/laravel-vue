<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['description', 'completed'];

    public function getCreatedAtAttribute($date)
    {
        return date('d/m/Y H:m', strtotime($date));
    }

    public function getUpdatedAtAttribute($date)
    {
        return date('d/m/Y H:m', strtotime($date));
    }
}
