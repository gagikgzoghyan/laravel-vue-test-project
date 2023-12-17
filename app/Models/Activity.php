<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property int id
 * @property string name
 * @property string description
 * @property string image_path
 * @property string scheduled_at Timestamp
 * @property string created_at Timestamp
 * @property string updated_at Timestamp
 * @property string deleted_at Timestamp
 * --- relations ---
 * @property Collection users
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
    public static $rules = [
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
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $dateRange
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeScheduledAt(Builder $query, array $dateRange)
    {
        return $query->whereBetween('scheduled_at', [$dateRange[0], $dateRange[1]]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
