<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PaymentsController
{
    /**
     * Endpoint to report payments to restaurant manager.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function get(Request $request)
    {
        return new JsonResponse(null);
    }

    /**
     * Endpoint to receive and store payment details.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        return new JsonResponse(null);
    }
}
