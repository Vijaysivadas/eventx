<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    //
    protected $table = 'applications';
    protected $fillable = [
        'user_id',
        'event_id',
        'job_id',
        'type',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define relationship to Event model
    public function event()
    {
        return $this->belongsTo(Events::class, 'event_id');
    }

    // Define relationship to Job model
    public function job()
    {
        return $this->belongsTo(Jobs::class, 'job_id');
    }
}
