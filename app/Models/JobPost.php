<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'job_posts';

    protected $fillable = [
        'recruiter_id',
        'job_title',
        'job_description',
        'job_requirements',
        'job_location',
        'job_type',
        'salary_range',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Định nghĩa mối quan hệ với model Recruiters
     */
    public function recruiters()
    {
        return $this->belongsTo(Recruiters::class, 'recruiter_id');
    }

    public function candidate_profiles()
    {
        return $this->belongsToMany(CandidateProfiles::class, 'job_applications', 'job_id', 'candidate_id')->withPivot('application_status', 'applied_at', 'deleted_at');
    }
}
