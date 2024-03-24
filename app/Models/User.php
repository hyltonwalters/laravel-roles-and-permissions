<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'email_verified_at',
        'remember_token',
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

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'roles_user');
    }

    public function locations(): HasMany
    {
        return $this->hasMany(UserLocation::class);
    }

    //    Check if a user has any specific role
    public function hasRole($roles): bool
    {
        return $this->roles->whereIn('name', $roles)->isNotEmpty();
    }

    //    Check if a role has a single permission
    public function hasPermission(string $permission): bool
    {
        return $this->roles->flatMap->permissions->contains('name', $permission);
    }

    //    Check if a role has multiple permissions
    public function hasAnyPermission(array $permissions): bool
    {
        return $this->roles->flatMap->permissions->whereIn('name', $permissions)->isNotEmpty();
    }

    /**
     * Creating a get attribute 'role_names' to display
     * all the user roles in a CSV format
     */
    public function getRoleNamesAttribute(): Collection
    {
        return $this->roles->map(function ($role) {
            return ucwords(str_replace('-', ' ', $role->name));
        });
    }
}
