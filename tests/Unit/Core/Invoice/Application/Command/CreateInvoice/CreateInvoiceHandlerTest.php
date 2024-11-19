<?php

namespace App\Tests\Unit\Core\Invoice\Application\Command\CreateInvoice;

use App\Core\Invoice\Application\Command\CreateInvoice\CreateInvoiceCommand;
use App\Core\Invoice\Application\Command\CreateInvoice\CreateInvoiceHandler;
use App\Core\Invoice\Domain\Exception\InvalidAmountException;
use App\Core\Invoice\Domain\Invoice;
use App\Core\Invoice\Domain\Repository\InvoiceRepositoryInterface;
use App\Core\Invoice\Domain\ValueObject\Amount;
use App\Core\User\Domain\Exception\InvalidEmailException;
use App\Core\User\Domain\Exception\UserNotFoundException;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\User;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateInvoiceHandlerTest extends TestCase
{
    private UserRepositoryInterface|MockObject $userRepository;

    private InvoiceRepositoryInterface|MockObject $invoiceRepository;

    private CreateInvoiceHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new CreateInvoiceHandler(
            $this->invoiceRepository = $this->createMock(
                InvoiceRepositoryInterface::class
            ),
            $this->userRepository = $this->createMock(
                UserRepositoryInterface::class
            )
        );
    }

    public function test_handle_success(): void
    {
        $user = $this->createMock(User::class);

        $user->expects(self::exactly(2))
            ->method('isActive')
            ->willReturn(true);

        $invoice = new Invoice(
            $user,
            new Amount(12500),
        );

        $this->userRepository->expects(self::once())
            ->method('getByEmail')
            ->willReturn($user);

        $this->invoiceRepository->expects(self::once())
            ->method('save')
            ->with($invoice);

        $this->invoiceRepository->expects(self::once())
            ->method('flush');

        $this->handler->__invoke((new CreateInvoiceCommand('test@test.pl', 12500)));
    }

    public function test_handle_user_not_exists(): void
    {
        $this->expectException(UserNotFoundException::class);

        $this->userRepository->expects(self::once())
            ->method('getByEmail')
            ->willThrowException(new UserNotFoundException());

        $this->handler->__invoke((new CreateInvoiceCommand('test@test.pl', 12500)));
    }

    public function test_handle_invoice_invalid_amount(): void
    {
        $this->expectException(InvalidAmountException::class);

        $this->handler->__invoke((new CreateInvoiceCommand('test@test.pl', -5)));
    }

    public function test_handle_invoice_invalid_email(): void
    {
        $this->expectException(InvalidEmailException::class);

        $this->handler->__invoke((new CreateInvoiceCommand('not_email', 12500)));
    }
}
