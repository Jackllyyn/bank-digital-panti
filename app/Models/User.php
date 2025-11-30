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

// Tambahkan di dalam class User
protected $fillable = [
    'name', 'email', 'password', 'role', 'foto'
];

public function isAdmin()
{
    return $this->role === 'admin';
}

public function isStaff()
{
    return $this->role === 'staff';
}
}
