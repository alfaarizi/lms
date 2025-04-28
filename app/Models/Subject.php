<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'name',
        'description',
        'code',
        'credit',
        'teacher_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the teacher who teaches this subject
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Subject>
     */
    public function teacher() {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the students enrolled to this subject
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<User, Subject, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function students() {
        return $this->belongsToMany(User::class, 'subject_user', 'subject_id', 'user_id')
                    ->withTimestamps();
    }

    /**
     * Get the tasks for this subject
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Task, Subject>
     */
    public function tasks() {
        return $this->hasMany(Task::class);
    }

}
