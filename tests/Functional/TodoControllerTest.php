<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TodoControllerTest extends WebTestCase
{
    private $client;

    public function setUp()
    {
        $this->client = new Client(['base_uri' => 'http://127.0.0.1:8080/api/v1/','headers'=>['Authorization' => 'Bearer token1']]);
    }

    /**
     * @throws GuzzleException
     */
    public function testGetTask()
    {
        $response = $this->client->request('GET', 'tasks/1');

        $this->assertEquals(200,  $response->getStatusCode());
    }

    /**
     * @throws GuzzleException
     */
    public function testCompleteTask()
    {
        $response = $this->client->request('PATCH', 'tasks/1/complete');
        $this->assertEquals(200,  $response->getStatusCode());
    }

    public function testCreateTask()
    {
        $response = $this->client->request(
            'POST',
            'tasks',
            [
                'json' => ['content' => 'Test task', 'due_date' => date('Y-m-d') ]
            ]
        );

        $this->assertEquals(200,  $response->getStatusCode());
    }


}
