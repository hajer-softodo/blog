<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for( $i = 1; $i <= 10; $i++){
        $article = new Article();
        $article->setTitle("Titre de l'article N $i")
                ->setContent("<p>contenue de l'article n $i</p>")
                ->setImage("http://placehold.it/350x150")
                ->setCreatedAt("contenue de l'article");
        }
        $manager->flush();
    }
}
