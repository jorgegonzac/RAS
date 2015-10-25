<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;
     use SoftDeletingTrait;

    /**
     * The deleted_at attribute must be protected
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    /**
     * The attributes included in the model's JSON form.
     * @var array
     */
    protected $fillable = array('first_name', 'last_name', 'room_number', 'career', 'username', 'email', 'user_id');


    /**
     * encrypts and saves user password
     * @param [string]
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password']  = Hash::make($value);
    }

    /**
     * Get the associated tickets with this user
     * @return [models]
     */
    public function tickets()
    {
        return $this->hasMany('Tickets');        
    }

    /**
     * Get the associated disciplinary reports with this user
     * @return [models]
     */
    public function reports()
    {
        return $this->hasMany('Reports');        
    }

    /**
     * Get the roles associated with this user
     * @return [models]
     */
    public function roles() 
    {
        return $this->belongsToMany('Role', 'users_roles', 'user_id', 'role_id');
    }
}