<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function friendsTo()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
            ->withPivot(['id','accepted'])
            ->withTimestamps();
    }
 
    public function friendsFrom()
    {
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id')
            ->withPivot(['id','accepted'])
            ->withTimestamps();
    }

    //I send them request and they havn't accepted it yet

    public function sentFriendRequest()
    {
        return $this->friendsTo()->wherePivot('accepted', false);
    }
    
    //who send me request and i havn't accepted their friend request yet
    public function recievedFriendRequest()
    {
        return $this->friendsFrom()->wherePivot('accepted', false);
    }
    
    //who accepted my friend request
    public function acceptedMyFriendRequest()
    {
        return $this->friendsTo()->wherePivot('accepted', true);
    }
    
    //i have accepted their requests
    public function acceptedOtherMyFriendRequest()
    {
        return $this->friendsFrom()->wherePivot('accepted', true);
    }

    // public function friends()
    // {
    //     return $this->acceptedMyFriendRequest()->merge($this->acceptedOtherMyFriendRequest);
    // }
}
