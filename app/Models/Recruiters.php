<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recruiters extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'recruiters';

    protected $fillable = [
        'user_id',
        'company_name',
        'company_description',
        'company_website',
    ];

    /**
     * Định nghĩa mối quan hệ với model User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
