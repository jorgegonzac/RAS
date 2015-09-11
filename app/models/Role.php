<?php

class Role extends Eloquent {
    
    /**
     * attributes defined as mass assignable (for security)
     * @var array
     */
    protected $fillable = array('description');


    /**
     * get the privilages associated with this role
     * @return models
     */
    public function privilages() {
        return $this->belongsToMany('Privilege', 'roles_privilages', 'role_id', 'privilege_id');
    }

    /**
     * get the users associated with this role
     * @return models
     */
    public function users() {
        return $this->belongsToMany('User', 'users_roles', 'user_id', 'role_id');
    }


}