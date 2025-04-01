<?php

namespace App\DataFixtures;

use App\Entity\ServiceLog;
use App\Tests\Factory\ServiceLogFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ServiceLogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ServiceLogFactory::createMany(300);
    }
}
