<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use 

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for( $i = 1; $i <= 10; $i++){
        $article = new Article();
        }
        $manager->flush();
    }
}
