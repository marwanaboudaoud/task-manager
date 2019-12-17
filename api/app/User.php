<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as AuthenticatableClass;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends AuthenticatableClass implements JWTSubject
{
    use Notifiable;
    use Authenticatable;
    use CanResetPassword;

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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function note()
    {
        return $this->hasOne('App\Note');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    /**
     * This is the meeting list that the user is the creator of
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function meetingList()
    {
        return $this->hasMany('App\MeetingList');
    }

    /**
     * This is the pivot relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function meetingLists()
    {
        return $this->belongsToMany('App\MeetingList', 'meeting_list_member')
            ->as('meetingList')
            ->withTimestamps();
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
