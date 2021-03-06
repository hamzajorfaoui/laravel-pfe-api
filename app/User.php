<?php

namespace App;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id'
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
    
    public function prof()
    {
        return $this->hasOne('App\Prof', 'user_id', 'id');
    }
        public function etudiant()
    {
        return $this->hasOne('App\Etudiant', 'user_id', 'id');
    }
     public function admin()
    {
        return $this->hasOne('App\Admin', 'user_id', 'id');
    }

    public function emploiExamens()
    {
        return $this->hasMany('App\EmploiExamen');
    }

    public function verifications()
    {
        return $this->hasMany('App\Verification');
    }

    public function emploiTemps()
    {
        return $this->hasMany('App\EmploiTemp');
    }

    public function annonces()
    {
        return $this->hasMany('App\Annonce');
    }

    public function actualites()
    {
        return $this->hasMany('App\Actualite');
    }


    


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
