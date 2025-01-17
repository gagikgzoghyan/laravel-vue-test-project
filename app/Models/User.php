<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int id
 * @property string first_name
 * @property string last_name
 * @property string email
 * @property Carbon created_at
 * @property Carbon updated_at
 * --- custom attributes ---
 * @property string full_name
 * --- relations ---
 * @property-read Collection<Role> roles
 * @property-read Collection<Activity> activities
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles;

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
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'id',
        'first_name',
        'last_name',
        'email',
        'password',
        'created_at',
        'updated_at',
        // custom attributes
        'full_name',
        // relations
        'roles',
        'activities',
    ];

    /**
     * The appended attributes
     *
     * @var array<int, string>
     */
    protected $appends = ['full_name'];

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
        'password' => 'hashed',
        // dates
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @return BelongsToMany
     */
    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class);
    }
}
