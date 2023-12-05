<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $faker = \Faker\Factory::create('fr_FR');
        // create 3 category with faker librairie
        for($i=1; $i<=3;$i++){
            $category = new Category();
            $category->setTitle('eque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...')
                     ->setDescription("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.");
            $manager->persist($category);

            for( $j = 1; $j <= mt_rand(4, 6); $j++){
                $article = new Article();
                $p = '</p><p>';
                // $content = $faker->paragraphs(5);
                $article->setTitle('eque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...')
                        ->setContent("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.")
                        ->setImage('https://static.aujardin.info/cache/th/img9/gaillardia-fleur-600x450.jpg')
                        ->setCreatedAt(new \DateTimeImmutable())
                        ->setCategory($category);
                $manager->persist($article);

                // add comments to our article
                        for($k = 1; $k <= mt_rand(4, 6); $k++){
                            $comment = new Comment();
                            // $content = $faker->paragraphs(2);
                            $now = new \Datetime();
                            // $intervall = $now->diff($article->getCreatedAt());
                            // $days = $intervall->days;
                            // $minimum = '-' . $days;  // -100 days
                            $comment->setAuthor("Nom de l'article $k")
                                    ->setContent("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.")
                                    ->setCreatedAt(new \Datetime())
                                    ->setArticle($article);

                            $manager->persist($comment);
                        }

                
                }
        }
        // create between 4 and 6 article with faker librairie

       
        $manager->flush();
    }
    }

