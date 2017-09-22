<?php

namespace Tests\Functional;

use App\Models\Payment;
use Silex\WebTestCase;
use Silex\Application;

class PaymentsTest extends WebTestCase
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $db;

    /**
     * Creates the application.
     *
     * @return Application
     */
    public function createApplication()
    {
        $app = new Application();
        require __DIR__ . '/../../resources/config/testing.php';
        require __DIR__ . '/../../src/app.php';
        return $app;
    }

    /**
     * Set up database schema before running the tests.
     */
    public function setUp()
    {
        parent::setUp();
        $this->db = $this->app['db'];
        $this->db->exec(file_get_contents(__DIR__.'/../../resources/sql/schema.sql'));
    }

    /**
     * Drop database changes after test has run.
     */
    public function tearDown()
    {
        $this->db->exec('DROP table payments');
    }

    /**
     * Add some fake payments to the database for testing.
     */
    public function createFakePayments()
    {
        $payments = [
            [
                'amount' => 10.00,
                'tip' => 0.00,
                'tableNumber' => 17,
                'locationId' => 1,
                'paymentReference' => 'testPaymentLocation1',
                'cardType' => 'visa',
                'customerId' => '987554658'
            ],
            [
                'amount' => 35.20,
                'tip' => 1.00,
                'tableNumber' => 8,
                'locationId' => 2,
                'paymentReference' => 'testPaymentLocation2',
                'cardType' => 'fake',
                'customerId' => '1465889723'
            ]
        ];

        $entityManager = $this->app['orm.em'];

        foreach ($payments as $paymentDetails) {
            $payment = new Payment($paymentDetails);
            $entityManager->persist($payment);
            $entityManager->flush();
        }
    }

    /**
     * Ensure user can get payments for all locations.
     */
    public function testGetPaymentsForAllLocations()
    {
        $this->createFakePayments();
        $client = $this->createClient();
        $client->request('GET', 'api/payments');

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertContains('testPaymentLocation1', $client->getResponse()->getContent());
        $this->assertContains('testPaymentLocation2', $client->getResponse()->getContent());
    }

    /**
     * Ensure user can get payments for a specific location only.
     */
    public function testGetPaymentsForSpecificLocation()
    {
        $this->createFakePayments();

        $client = $this->createClient();
        $client->request('GET', 'api/payments', ['location_id' => 1]);

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertContains('testPaymentLocation1', $client->getResponse()->getContent());
        $this->assertNotContains('testPaymentLocation2', $client->getResponse()->getContent());
    }

    /**
     * Ensure a payment POST request will succeed with the correct payment details.
     */
    public function testCanPostPaymentWithCorrectParameters()
    {
        $client = $this->createClient();
        $client->request('POST', 'api/payments', [
            'amount' => 10.00,
            'tip' => 0.00,
            'tableNumber' => 17,
            'locationId' => 2,
            'paymentReference' => 'testZxxclHou123b',
            'cardType' => 'fake',
            'customerId' => '1466587723'
        ]);

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    /**
     * Ensure a payment POST will fail without the correct payment details.
     */
    public function testCanNotPostPaymentWithIncorrectParameters()
    {
        $client = $this->createClient();
        $client->request('POST', 'api/payments', [
            'incorrect' => 'data'
        ]);

        $this->assertEquals(422, $client->getResponse()->getStatusCode());
    }
}
