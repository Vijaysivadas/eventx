<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    //
    protected $table = 'jobposts';
    public function event()
    {
        return $this->belongsTo(Events::class, 'event_id');
    }
}
