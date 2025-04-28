<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'points',
        'due_date',
        'subject_id',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    /**
     * Get the subject that the task belongs to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Subject, Task>
     */
    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the solutions for this tasj
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Solution, Task>
     */
    public function solutions() {
        return $this->hasMany(Solution::class);
    }

}
