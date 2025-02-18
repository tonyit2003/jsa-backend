<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'id',
        'full_name',
        'email',
        'password',
        'phone_number',
        'user_type',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
