<?php

namespace App\Controllers;

use App\Services\PaymentsService;
use App\Validators\PaymentsValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PaymentsController
{
    /**
     * @var PaymentsService
     */
    protected $paymentsService;

    /**
     * @var PaymentsValidator
     */
    protected $paymentsValidator;

    /**
     * PaymentsController constructor.
     *
     * @param PaymentsService $service
     * @param PaymentsValidator $validator
     */
    public function __construct(PaymentsService $service, PaymentsValidator $validator)
    {
        $this->paymentsService = $service;
        $this->paymentsValidator = $validator;
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

        if (!$this->paymentsValidator->validateCreatePaymentRequest($paymentData)) {
            return new JsonResponse('Invalid parameters.', 422);
        }

        $response = $this->paymentsService->createPayment($paymentData);
        return new JsonResponse($response, 201);
    }
}
