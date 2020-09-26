<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    public static function boot () {

        parent::boot();

        static::creating(function(User $user){

            $slug = \Str::slug($user->nombres. " " . $user->apellidos);
			
			$count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
			
			$user->slug = $count ? "{$slug}-{$count}" : $slug;

        });
    }
    
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'identificacion','nombres', 'apellidos', 'direccion', 'telefono', 'email', 'username','password','imagen', 'slug'
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

    //public static function navigation (){
    	//return auth()->check() ? auth()->user()->role->nombre : 'guest';
    //}

    public function role (){
        return $this->belongsTo(Role::class);
    }

    public function cliente (){
        return $this->hasOne(Cliente::class);
    }

    public function imagene (){
        return $this->morphOne('App\Imagene','imageable');
    }
}
