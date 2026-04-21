<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\LogsAllActivities;
use Database\Factories\UserFactory;
use Filament\Notifications\Notification;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles;
    use SoftDeletes;

    use SoftDeletes;
    // use LogsAllActivities;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'login_attempt',
        'is_locked',
        'password',
        'last_login',
        'last_login_from',
        'avatar',
        'is_active',
        'assign_company',
        'remark',
        'role',
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
            'is_active' => 'boolean',
            'is_locked' => 'boolean',
            'login_attempt' => 'integer',
        ];
    }

    // public function roles(): BelongsTo
    // {
    //     return $this->belongsTo(Role::class, 'role');
    // }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($this->is_locked) {
            Notification::make()
                ->title('Access Denied')
                ->body('Your account is locked, please contact your system administrator')
                ->danger()
                ->persistent()
                ->send();

            return false;
        }

        return true;
    }

    protected static function booted()
    {
        static::deleted(function ($user) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
        });
    }

    // protected $with = [
    //     'companyList'
    // ];
    public function companyList(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'assign_company');
    }
}
