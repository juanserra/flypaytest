<?php

namespace App\Services;

use App\Models\Payment;
use Carbon\Carbon;
use Doctrine\ORM\EntityManager;

class PaymentsService
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var Carbon
     */
    protected $carbon;

    /**
     * PaymentsService constructor.
     *
     * @param EntityManager $entityManager
     * @param Carbon $carbon
     */
    public function __construct(EntityManager $entityManager, Carbon $carbon)
    {
        $this->entityManager = $entityManager;
        $this->carbon = $carbon;
    }

    /**
     * Stores payment in the database.
     *
     * @param array $data
     */
    public function createPayment(array $data)
    {
        $payment = new Payment($data);
        $this->entityManager->persist($payment);
        return $this->entityManager->flush();
    }

    /**
     * Get payments processed in the last 24 hours.
     *
     * @param int $locationId
     * @return array
     */
    public function getLastPayments($locationId)
    {
        $startDate = $this->carbon->subHours(24)->toDateTimeString();

        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('p')
            ->from(Payment::class, 'p')
            ->where('p.processedAt > :start')
            ->setParameter('start', $startDate);

        // Return payments for all locations
        if (is_null($locationId)) {
            return $queryBuilder->getQuery()->getResult();
        }

        // Return payments for specific location
        $queryBuilder->andWhere('p.locationId = :locationId')
            ->setParameter('locationId', $locationId);

        return $queryBuilder->getQuery()->getResult();
    }
}
