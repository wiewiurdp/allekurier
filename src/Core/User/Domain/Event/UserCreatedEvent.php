<?php

namespace App\Core\User\Domain\Event;

use App\Core\User\Domain\ValueObject\Email;

class UserCreatedEvent extends AbstractUserEvent
{
    public function getEmail(): Email
    {
        return $this->user->getEmail();
    }
}
