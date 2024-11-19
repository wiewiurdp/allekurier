<?php

namespace App\Core\Invoice\Domain\Event;

use App\Core\User\Domain\ValueObject\Email;

class InvoiceCreatedEvent extends AbstractInvoiceEvent
{
    public function getUserEmail(): Email
    {
        return $this->invoice->getUser()->getEmail();
    }
}
