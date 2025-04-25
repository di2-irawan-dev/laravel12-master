<?php

namespace App\Models;

use App\Enums\NoYes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getInitials(): string
    {
        $words = explode(' ', $this->name);
        if (count($words) <= 2) {
            return strtoupper(implode('', array_map(fn($word) => $word[0], $words)));
        }
        return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
    }

    public function getPathAvatarAttribute(): string
    {
        return $this->avatar
            ? Storage::url($this->avatar)
            : asset('noimage.jpg');
    }

    public function scopeFilter(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function (Builder $q) use ($search) {
            $q->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        });
    }

    public function scopeWithEmailVerified(Builder $query, ?NoYes $verified): Builder
    {
        if ($verified === NoYes::Yes) {
            return $query->whereNotNull('email_verified_at');
        }
        if ($verified === NoYes::No) {
            return $query->whereNull('email_verified_at');
        }
        return $query;
    }

    public function scopeSorted(Builder $query, array $sortBy): Builder
    {
        return $query->orderBy(...array_values($sortBy));
    }
}
