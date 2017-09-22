<?php

namespace App\Models;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity
 * @ORM\Table(name="payments")
 */
class Payment implements JsonSerializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tip;

    /**
     * @ORM\Column(type="integer", name="table_number")
     */
    private $tableNumber;

    /**
     * @ORM\Column(type="integer", name="location_id")
     */
    private $locationId;

    /**
     * @ORM\Column(type="string", length=30, name="payment_reference")
     */
    private $paymentReference;

    /**
     * @ORM\Column(type="string", length=10, name="card_type")
     */
    private $cardType;

    /**
     * @ORM\Column(type="datetime", name="processed_at", options={"default": 0})
     */
    private $processedAt;

    /**
     * @ORM\Column(type="integer", name="customer_id")
     */
    private $customerId;

    /**
     * @ORM\Column(type="string", length=30, name="customer_device", nullable=true)
     */
    private $customerDevice;

    /**
     * Payment constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->amount = $data['amount'];
        $this->tip = $data['tip'];
        $this->tableNumber = $data['tableNumber'];
        $this->locationId = $data['locationId'];
        $this->paymentReference = $data['paymentReference'];
        $this->cardType = $data['cardType'];
        $this->customerId = $data['customerId'];
        $this->customerDevice = isset($data['customerDevice']) ? $data['customerDevice'] : null;
        $this->processedAt = new DateTime("now");
    }

    /**
     * Define how the model should be serialized.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'amount'=> $this->amount,
            'tip' => $this->tip,
            'tableNumber' => $this->tableNumber,
            'locationId' => $this->locationId,
            'paymentReference' => $this->paymentReference,
            'cardType' => $this->cardType,
            'processedAt' => $this->processedAt,
            'customerId' => $this->customerId,
            'customerDevice' => $this->customerDevice
        ];
    }
}
