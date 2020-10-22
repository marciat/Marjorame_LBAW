<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'first_name', 'last_name', 'email', 'date_of_birth'
    ];

    protected $table = 'user';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    public function admin() {
        return $this->hasOne('App\Admin', 'user_id', 'id');
    }

    public function buyer(){
        return $this->hasOne('App\Buyer', 'user_id', 'id');
    }

    public function getPhoto(){
        $profile_picture = Profile_picture::findOrFail($this->buyer->picture_id);
        $photo = Photo::findOrFail($profile_picture->photo_id);

        return $photo->src;
    }

    /**
     * check if a user is active, only ones that can login
     * User can be in 4 states: 'Active', 'Banned', 'Deactivated', 'Deleted'
     */
    public function active(){
        if($this->buyer){
            return (strcasecmp($this->buyer->status, 'Active') == 0);
        }else{
            return true;
        }
    }


}
