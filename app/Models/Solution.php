<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'content',
        'earned_points',
        'evaluation_time',
        'task_id',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'evaluation_time' => 'datetime',
    ];

    /**
     * Get the task that the solution belongs to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Task, Solution>
     */
    public function task() {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the student who submitted the solution
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Solution>
     */
    public function student() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
