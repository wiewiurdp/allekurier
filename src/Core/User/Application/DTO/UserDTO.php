<?php

declare(strict_types=1);

namespace App\Core\User\Application\DTO;

use App\Core\User\Domain\ValueObject\Email;

class UserDTO
{
    public function __construct(
        public readonly int $id,
        public readonly Email $email,
    ) {}
}
