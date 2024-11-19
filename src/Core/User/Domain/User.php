<?php

namespace App\Core\User\Domain;

use App\Common\EventManager\EventsCollectorTrait;
use App\Core\User\Domain\Event\UserCreatedEvent;
use App\Core\User\Domain\ValueObject\Email;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    use EventsCollectorTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true}, nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="email", length=300, nullable=false)
     */
    private Email $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isActive;

    public function __construct(Email $email)
    {
        $this->id = null;
        $this->email = $email;
        $this->isActive = false;

        $this->record(new UserCreatedEvent($this));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }
}
