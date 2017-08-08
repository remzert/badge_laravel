<?php

namespace Badge;

use Badge\Badge;

trait Badgeable{
    
    public function badges(){
        return $this->belongsToMany(Badge::class);
    }
}

