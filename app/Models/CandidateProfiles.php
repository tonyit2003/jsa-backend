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
    ];

    /**
     * Định nghĩa mối quan hệ với model User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
