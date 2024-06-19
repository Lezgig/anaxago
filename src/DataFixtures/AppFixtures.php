<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;


use App\Entity\Task;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
 
        $numberOfTaks = 10;
        $numberOfUsers = 2;
        for ($i = 0; $i < $numberOfTaks; $i++) {
                $user = new User();
                $user->setEmail('user' . $i . '@example.com');
                $user->setLastName('user' . $i);
                $user->setFirstName('user' . $i);
                $user->setRoles( $i % $numberOfUsers == 0 ? ['ROLE_ADMIN'] : ['ROLE_USER']);
                $manager->persist($user);
                $task = new Task();
                $task->setTitle('Task ' . $i);
                $task->setDescription('Content ' . $i);
                $task->setCreatedAt(new \DateTimeImmutable());
                $task->setStatus($i % $numberOfUsers == 0 ?  "PENDING" : "COMPLETED");
                $task->setUser($user);
                $manager->persist($task);
                $manager->flush();

        }

    }
}
