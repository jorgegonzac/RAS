<?php

class Ticket extends Eloquent {
    
    /**
     * attributes defined as mass assignable (for security)
     * @var array
     */
    protected $fillable = array('place','check_in','check_out','latitude','longitude');

    /**
     * get the user associated with this ticket
     * @return model
     */
    public function user(){
        return $this->belongsTo('User');
    }

}