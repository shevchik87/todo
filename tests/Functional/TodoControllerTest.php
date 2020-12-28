<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Domain\Todo\Entity\ActivityEntity;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class TodoControllerTest extends WebTestCase
{
    private $client;

    protected static $application;

    /**
     * @var EntityManager
     */
    private $em;

    public function setUp()
    {
        $this->client = new Client(
            [
                'base_uri' => 'http://todo-nginx/api/v1/',
                'headers'=>['Authorization' => 'Bearer token1'],
                'http_errors' => false,
            ]);

        $kernel = $this->createKernel();
        $kernel->boot();
        $this->loadFixtures($kernel);
        $this->em = $kernel->getContainer()->get('doctrine')->getManager();
    }

    protected function loadFixtures($kernel)
    {
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => 'doctrine:fixtures:load',
            // (optional) define the value of command arguments
            '--no-interaction' => true,
            '--purge-with-truncate' => true,
            // (optional) pass options to the command
        ]);

        // You can use NullOutput() if you don't need the output
        $output = new BufferedOutput();
        $application->run($input, $output);
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
     * @param int $taskId
     * @param int $code
     * @throws GuzzleException
     * @dataProvider taskCompleteProvider
     */
    public function testCompleteTask(int $taskId, int $code)
    {
        $response = $this->client->request('PATCH', sprintf('tasks/%d/complete', $taskId));
        $this->assertEquals($code,  $response->getStatusCode());
    }

    /**
     * @param string $name
     * @param $data
     * @param $code
     * @throws GuzzleException
     * @dataProvider taskCreateProvider
     */
    public function testCreateTask(string $name, $data, $code)
    {
        $response = $this->client->request(
            'POST',
            'tasks',
            [
                'json' => ['content' => $name, 'due_date' => $data]
            ]
        );
        $this->assertEquals($code,  $response->getStatusCode());

        if ($response->getStatusCode() < 400) {
            $data = json_decode($response->getBody()->getContents(), true);
            $data = $data['result'];
            $events = $this->em->getRepository(ActivityEntity::class)->getByTaskId($data['id']);
            $this->assertEquals(1, count($events));

        }
    }

    public function taskCreateProvider()
    {
        return [
            ['Test task', date('Y-m-d'), 200],
            ['Test task2', '2020-12-12', 400]
        ];
    }

    public function taskCompleteProvider()
    {
        return [
            [1, 200],
            [456, 404]
        ];
    }


}
