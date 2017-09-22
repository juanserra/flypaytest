<?php

namespace App\Validators;

use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class PaymentsValidator
{
    /**
     * @var RecursiveValidator
     */
    protected $validator;

    /**
     * PaymentsValidator constructor.
     *
     * @param RecursiveValidator $validator
     */
    public function __construct(RecursiveValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Validates parameters for create payment request.
     *
     * @param array $data
     * @return bool
     */
    public function validateCreatePaymentRequest(array $data)
    {
        $constraint = new Constraints\Collection([
            'fields' => [
                'amount' => new Constraints\NotBlank(),
                'tableNumber' => new Constraints\GreaterThan(0),
                'locationId' => new Constraints\GreaterThan(0),
                'paymentReference' => new Constraints\NotBlank(),
                'cardType' => new Constraints\NotBlank(),
                'customerId' => new Constraints\NotBlank()
            ],
            'allowExtraFields' => true
        ]);

        $errors = $this->validator->validate($data, $constraint);
        return count($errors) == 0;
    }
}