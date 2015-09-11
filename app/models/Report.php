<?php

class Report extends Eloquent {
    
    /**
     * attributes defined as mass assignable (for security)
     * @var array
     */
    protected $fillable = array('description','date');

    /**
     * get the user associated with this report
     * @return model
     */
    public function user(){
        return $this->belongsTo('User');
    }

}