<?php

namespace App\Events;

use Illuminate\Foundation\Auth\User;

class Premium {

    
    /**
     *
     * @var User
     */
    
    public $user;
    
    public function __construct(User $user) {
        $this->user = $user;
    }

}
