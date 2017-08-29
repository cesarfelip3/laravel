<?php

namespace App\Models;

use Artesaos\Defender\Role;
use Artesaos\Defender\Traits\HasDefender;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasDefender;

    const SUPERADMIN = 'slc';
    const ADMIN = 'admin';
    const USER = 'user';
    const CLIENT = 'client';

    protected $fillable = [
        'name',
        'email',
        'password',
        'invitation_token',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function getRoleAttribute()
    {
        return $this->roles()->first();
    }

    public function toArray()
    {
        return [
            'id' => (int)$this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => [
                'id' => $this->role->id,
                'name' => $this->role->name
            ],
            'status' => $this->status,
            'pending' => $this->invitation_token != null
        ];
    }
}
