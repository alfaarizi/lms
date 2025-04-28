<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'neptun',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the subjects taught by this teacher
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Subject, User>
     */
    public function taughtSubjects() {
        return $this->hasMany(Subject::class, 'teacher_id');
    }

    /**
     * Get the subjects taken by this student
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Subject, User, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function enrolledSubjects() {
        return $this->belongsToMany(Subject::class, 'subject_user', 'user_id', 'subject_id')
                    ->withTimestamps();
    }

    /**
     * Get solutions submitted by this student
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Solution, User>
     */
    public function solutions() {
        return $this->hasMany(Solution::class);
    }

    /**
     * Check if user is a teacher
     * @return bool
     */
    public function isTeacher() {
        return $this->role === 'teacher';
    }

    public function isStudent() {
        return $this->role === 'student';
    }
}
