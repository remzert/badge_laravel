<?php

namespace Badge;

use Badge\Notifications\BadgeUnlocked;

    
    
class BadgeSubscriber
 {
        
        /**
         *
         * @var Badge 
         */
         
        private $badge;
    
        public function __construct(Badge $badge){
            $this->badge = $badge;
        }
        
        /**
        * Register the listeners for the subscriber.
        *
        * @param  Dispatcher  $events
         */
        public function subscribe($events)
        {
            $events->listen('eloquent.saved: App\Comment', [$this, 'onNewComment']);
            $events->listen('App\Events\Premium', [$this, 'onPremium']);
        }
        
        public function notifyBadgeUnlock($user, $badge ){
            if($badge){
                 $user->notify(new BadgeUnlocked($badge));
            }
        }
        
        
        public function onNewComment($comment){
            $user = $comment->user;
            $comments_count= $user->comments()->count();
            $badge = $this->badge->unlockActionFor($user, 'comments', $comments_count);
            $this->notifyBadgeUnlock($user, $badge);
           
        }
        
        public function onPremium($event){
            //var_dump($arg);
            $badge = $this->badge->unlockActionFor($event->user, 'premium');
            $this->notifyBadgeUnlock($event->user, $badge);
        }
 }
