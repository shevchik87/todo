<?php

namespace App\DataFixtures;

use App\Domain\Todo\Command\Create\TaskCreateCommand;
use App\Domain\Todo\Command\Create\TaskCreateHandler;
use App\Domain\Todo\Entity\UserEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $createHandler;

    public function __construct(TaskCreateHandler $handler)
    {
        $this->createHandler = $handler;
    }


    public function load(ObjectManager $manager)
    {
        for ($i=1; $i<=2; $i++) {
            $user = new UserEntity();
            $user
                ->setId($i)
                ->setToken('token'.$i)
                ->setUserName('user'.$i);
            $manager->persist($user);
        }

        $manager->flush();
        $this->createTasks();
    }

    /**
     * @throws \App\Domain\Todo\Exception\DomainException
     */
    protected function createTasks()
    {
        for ($i=0; $i<5; $i++) {
            $command = new TaskCreateCommand(1, 'Test task - '.$i, date('Y-m-d'));
            $this->createHandler->execute($command);
        }
    }

}
