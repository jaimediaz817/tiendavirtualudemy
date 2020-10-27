<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // TODO: agregamos el mutador como una propiedad más del objeto:
    protected $appends = ['fullname'];

    // TODO: mutadores:
    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    // Definiendo relaciones
    public function file()
    {
        // modelo al que se irá a relacionar y campo por el cual se dá la relación
        return $this->belongsTo(File::class, 'file_id');
    }
}
