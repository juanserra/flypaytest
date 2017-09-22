<?php

namespace Tests\Unit\Services;

use App\Controllers\PaymentsController;
use App\Services\PaymentsService;
use App\Validators\PaymentsValidator;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class PaymentsControllerTest extends TestCase
{
    public function testGet()
    {
        $requestMock = Mockery::mock(Request::class)
            ->shouldReceive('get')->andReturn(null)
            ->getMock();

        $paymentsServiceMock = Mockery::mock(PaymentsService::class)
            ->shouldReceive('getLastPayments')->with(null)->andReturn(['testPayments'])
            ->getMock();

        $paymentsValidatorMock = Mockery::mock(PaymentsValidator::class);

        $paymentsController = new PaymentsController($paymentsServiceMock, $paymentsValidatorMock);
        $response = $paymentsController->get($requestMock);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertContains('testPayments', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCreate()
    {
        $requestParamsMock = Mockery::mock()
            ->shouldReceive('all')
            ->andReturn([
                'amount' => 10.00,
                'tip' => 0.00,
                'tableNumber' => 17,
                'locationId' => 2,
                'paymentReference' => 'testZxxclHou123b',
                'cardType' => 'fake',
                'customerId' => 456
            ])
            ->getMock();

        $requestMock = Mockery::mock(Request::class);
        $requestMock->request = $requestParamsMock;

        $paymentsServiceMock = Mockery::mock(PaymentsService::class)
            ->shouldReceive('createPayment')->andReturn(true)
            ->getMock();

        $paymentsValidatorMock = Mockery::mock(PaymentsValidator::class)
            ->shouldReceive('validateCreatePaymentRequest')->andReturn(true)
            ->getMock();

        $paymentsController = new PaymentsController($paymentsServiceMock, $paymentsValidatorMock);
        $response = $paymentsController->create($requestMock);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
    }
}
