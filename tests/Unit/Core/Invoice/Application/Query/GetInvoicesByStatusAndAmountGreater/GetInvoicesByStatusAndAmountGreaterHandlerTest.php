<?php

declare(strict_types=1);

namespace App\Tests\Unit\Core\Invoice\Application\Query\GetInvoicesByStatusAndAmountGreater;

use App\Core\Invoice\Application\DTO\InvoiceDTO;
use App\Core\Invoice\Application\Query\GetInvoicesByStatusAndAmountGreater\GetInvoicesByStatusAndAmountGreaterHandler;
use App\Core\Invoice\Application\Query\GetInvoicesByStatusAndAmountGreater\GetInvoicesByStatusAndAmountGreaterQuery;
use App\Core\Invoice\Domain\Invoice;
use App\Core\Invoice\Domain\Repository\InvoiceRepositoryInterface;
use App\Core\Invoice\Domain\ValueObject\Amount;
use App\Core\User\Domain\User;
use App\Core\User\Domain\ValueObject\Email;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetInvoicesByStatusAndAmountGreaterHandlerTest extends TestCase
{

    private GetInvoicesByStatusAndAmountGreaterHandler $handler;

    private InvoiceRepositoryInterface|MockObject $invoiceRepository;
    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new GetInvoicesByStatusAndAmountGreaterHandler(
            $this->invoiceRepository = $this->createMock(
                InvoiceRepositoryInterface::class
            )
        );
    }

    public function test_handle_success(): void
    {
        $invoice = $this->createMock(Invoice::class);
        $user = $this->createMock(User::class);

        $invoice->method('getId')->willReturn(1);
        $invoice->method('getUser')->willReturn($user);
        $invoice->method('getAmount')->willReturn(new Amount(12500));
        $user->method('getEmail')->willReturn(new Email('user@example.com'));

        $this->invoiceRepository
            ->expects($this->once())
            ->method('getInvoicesWithGreaterAmountAndStatus')
            ->willReturn([$invoice]);

        $result = $this->handler->__invoke((new GetInvoicesByStatusAndAmountGreaterQuery('new', 12500)));

        $this->assertCount(1, $result);
        $this->assertInstanceOf(InvoiceDTO::class, $result[0]);
        $this->assertEquals(1, $result[0]->id);
        $this->assertEquals('user@example.com', $result[0]->email);
        $this->assertEquals(12500, $result[0]->amount->getValue());
    }

    public function test_handle_invalid_status(): void
    {
        $this->expectException(\ValueError::class);

        $this->handler->__invoke((new GetInvoicesByStatusAndAmountGreaterQuery('not_status', 12500)));
    }
}
