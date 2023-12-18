<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property int id
 * @property string name
 * @property string description
 * @property string image_path
 * @property string scheduled_at Timestamp
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 * --- relations ---
 * @property-read Collection<User> users
 */
class Activity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'image_path',
        'scheduled_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'id',
        'name',
        'description',
        'image_path',
        'scheduled_at',
        'created_at',
        'updated_at',
        'deleted_at',
        // relations
        'users'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // dates
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     *
     * @return array
     */
    public static array $rules = [
        'name' => ['required', 'string', 'max:100'],
        'description' => ['required', 'string', 'max:255'],
        'upload_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png'],
        'scheduled_at' => ['required', 'date'],
        'users' => ['nullable', 'array', 'exists:users,id']
    ];

    /**
     * @param Builder $query
     * @param User $user
     * @return Builder
     */
    public function scopeUser(Builder $query, User $user): Builder
    {
        if ($user->hasRole('admin')) {
            return $query;
        }

        if ($user->hasRole('user')) {
            $query->whereHas('users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            });
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @param array $dateRange
     * @return Builder
     */
    public function scopeScheduledAt(Builder $query, array $dateRange): Builder
    {
        return $query->whereBetween('scheduled_at', [$dateRange[0], $dateRange[1]]);
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
