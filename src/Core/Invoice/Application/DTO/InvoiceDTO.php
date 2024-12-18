<?php

namespace App\Core\Invoice\Application\DTO;

use App\Core\Invoice\Domain\ValueObject\Amount;
use App\Core\User\Domain\ValueObject\Email;

class InvoiceDTO
{
    public function __construct(
        public readonly int $id,
        public readonly Email $email,
        public readonly Amount $amount
    ) {}
}
