<?php

namespace Tests\Unit;

use App\Comment;
use App\Events\Premium;
use App\User;
use Badge\Badge;
use Badge\Notifications\BadgeUnlocked;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use function event;
use function factory;


class BadgeTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;
    
    /*public function testFakeThings(){
        Badge::create(['name' => 'Pipelette', 'action' => 'comment', 'action_count' => 2]);
        $this->assertEquals(1, Badge::count());
    }*/
    
    public function testUnlockBadgeAutomatically(){
        Badge::create(['name' => 'Pipelette', 'action' => 'comments', 'action_count' => 2]);
        $user = factory(User::class)->create();
        factory(Comment::class, 3)->create(['user_id' => $user->id]);
        $this->assertEquals(1, $user->badges()->count());
    }
    
    public function testDontUnlockBadgeForNotEnoughAction(){
        Badge::create(['name' => 'Pipelette', 'action' => 'comments', 'action_count' => 2]);
        $user = factory(User::class)->create();
        factory(Comment::class)->create(['user_id' => $user->id]);
        $this->assertEquals(0, $user->badges()->count());
    }
    
     public function testUnlockDoubleBadge(){
        Badge::create(['name' => 'Pipelette', 'action' => 'comments', 'action_count' => 2]);
        $user = factory(User::class)->create();
        factory(Comment::class, 2)->create(['user_id' => $user->id]);
        $this->assertEquals(1, $user->badges()->count());
        Comment::first()->delete();
        factory(Comment::class, 2)->create(['user_id' => $user->id]);
        $this->assertEquals(1, $user->badges()->count());
    }
    
    public function testNotificationSent(){
        Notification::fake();
        Badge::create(['name' => 'Pipelette', 'action' => 'comments', 'action_count' => 2]);
        $user = factory(User::class)->create();
        factory(Comment::class, 3)->create(['user_id' => $user->id]);
        Notification::assertSentTo([$user], BadgeUnlocked::class);
        
    }
    
    public function testUnlockPremiumBadge(){
        $user = factory(User::class)->create();
        Badge::create(['name' => 'Premium', 'action' => 'premium', 'action_count' => 0]);
        event(new Premium($user));
        $this->assertEquals(1, $user->badges()->count());
    }
}

