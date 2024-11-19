<?php

namespace App\Core\Invoice\Application\Command\CreateInvoice;

use App\Core\Invoice\Domain\Invoice;
use App\Core\Invoice\Domain\Repository\InvoiceRepositoryInterface;
use App\Core\Invoice\Domain\ValueObject\Amount;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\ValueObject\Email;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateInvoiceHandler
{
    public function __construct(
        private readonly InvoiceRepositoryInterface $invoiceRepository,
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(CreateInvoiceCommand $command): void
    {
        $this->invoiceRepository->save(new Invoice(
            $this->userRepository->getByEmail(
                new Email($command->email),
            ),
            new Amount($command->amount),
        ));

        $this->invoiceRepository->flush();
    }
}
