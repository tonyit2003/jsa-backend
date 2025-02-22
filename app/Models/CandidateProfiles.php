<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateProfiles extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'candidate_profiles';

    protected $fillable = [
        'user_id',
        'resume',
        'skills',
        'experience',
        'education',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Định nghĩa mối quan hệ với model User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function job_posts()
    {
        return $this->belongsToMany(JobPost::class, 'job_applications', 'candidate_id', 'job_id')->withPivot('application_status', 'applied_at', 'deleted_at');
    }
}
