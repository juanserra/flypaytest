<?php

namespace Tests\Unit\Services;

use App\Services\PaymentsService;
use Carbon\Carbon;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Mockery;
use PHPUnit\Framework\TestCase;

class PaymentsServiceTest extends TestCase
{
    public function testCreatePayment()
    {
        $entityManagerMock = Mockery::mock(EntityManager::class)
            ->shouldReceive('persist')
            ->shouldReceive('flush')->andReturn(true)
            ->getMock();

        $carbonMock = Mockery::mock(Carbon::class);

        $paymentsService = new PaymentsService($entityManagerMock, $carbonMock);
        $result = $paymentsService->createPayment([
            'amount' => 10.00,
            'tip' => 0.00,
            'tableNumber' => 17,
            'locationId' => 2,
            'paymentReference' => 'testZxxclHou123b',
            'cardType' => 'fake',
            'customerId' => 46558978552
        ]);

        $this->assertEquals(true, $result);
    }

    public function testGetLastPayments()
    {
        $queryResultMock = Mockery::mock()
            ->shouldReceive('getResult')
            ->andReturn(['mockedResult'])
            ->getMock();

        $queryBuilderMock = Mockery::mock(QueryBuilder::class)
            ->shouldReceive('getQuery')->andReturn($queryResultMock)
            ->shouldReceive('select', 'from', 'where', 'setParameter')
            ->andReturnSelf()
            ->getMock();

        $entityManagerMock = Mockery::mock(EntityManager::class)
            ->shouldReceive('createQueryBuilder')->andReturn($queryBuilderMock)
            ->getMock();

        $carbonMock = Mockery::mock(Carbon::class)
            ->shouldReceive('subHours')->with(24)->andReturnSelf()
            ->shouldReceive('toDateTimeString')
            ->getMock();

        $paymentsService = new PaymentsService($entityManagerMock, $carbonMock);
        $result = $paymentsService->getLastPayments(null);

        $this->assertEquals(['mockedResult'], $result);
    }
}
