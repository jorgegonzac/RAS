<?php

class Privilege extends Eloquent {
    
    /**
     * attributes defined as mass assignable (for security)
     * @var array
     */
    protected $fillable = array('description', 'code');

    /**
     * get the roles associated with this privilege
     * @return models
     */
    public function roles() {
        return $this->belongsToMany('Role', 'roles_privilages', 'role_id', 'privilages_id');
    }


}