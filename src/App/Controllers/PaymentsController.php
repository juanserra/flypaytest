<?php

namespace App\Controllers;

use App\Services\PaymentsService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PaymentsController
{
    /**
     * @var PaymentsService
     */
    protected $paymentsService;

    /**
     * PaymentsController constructor.
     *
     * @param PaymentsService $service
     */
    public function __construct(PaymentsService $service)
    {
        $this->paymentsService = $service;
    }

    /**
     * Endpoint to report payments to restaurant manager.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function get(Request $request)
    {
        $restaurantLocationId = $request->get('location_id', null);
        $response = $this->paymentsService->getLastPayments($restaurantLocationId);
        return new JsonResponse($response);
    }

    /**
     * Endpoint to receive and store payment details.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $paymentData = $request->request->all();
        $response = $this->paymentsService->createPayment($paymentData);
        return new JsonResponse($response, 201);
    }
}
