<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    protected $fillable = [
        'user_type',
        'franchise_id',
        'username',
        'password',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'is_active',
        'is_deleted'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Specify the guard for the User model
    protected $guard_name = 'api';

    // Define the relationship with the Franchise model
    public function franchiseId()
    {
        //if logged in user role is admin, then return logged in user id,
        //else return franchise_id of logged in user
        return $this->user_type == 1 ? $this->id : $this->franchise_id;
    }
}
