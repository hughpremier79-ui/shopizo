<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'status',
        'plan',
        'plan_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'plan_expires_at' => 'date',
        'password' => 'hashed',
    ];

    public function store()
    {
        return $this->hasOne(Store::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isVendor()
    {
        return $this->role === 'vendor';
    }

    public function isPremium()
    {
        return $this->plan === 'premium' && $this->plan_expires_at && $this->plan_expires_at->isFuture();
    }

    public function isStandard()
    {
        return $this->plan === 'standard' && $this->plan_expires_at && $this->plan_expires_at->isFuture();
    }

    public function isFree()
    {
        return $this->plan === 'free' || !$this->plan_expires_at || $this->plan_expires_at->isPast();
    }

    public function maxProducts()
    {
        if ($this->isPremium() || $this->isStandard()) {
            return 999999;
        }
        return 5;
    }

    public function canAddProduct()
    {
        $currentProducts = $this->store ? $this->store->products()->count() : 0;
        return $currentProducts < $this->maxProducts();
    }
}