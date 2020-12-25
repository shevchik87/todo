<?php

namespace App\DataFixtures;

use App\Domain\Todo\Entity\UserEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
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
    }
}
