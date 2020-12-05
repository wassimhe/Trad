<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use app\Entity\Article;
use app\Entity\Category;
use app\Entity\Comment;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       
        $faker = \Faker\Factory::create('fr_FR'); // create a French faker
        $faker_ar = \Faker\Factory::create('ar_SA');
        for($j=0; $j<3 ; $j++)
    {
            $category = new Category();
            $category->setTitle($faker->sentence())
                     ->setDescription($faker->paragraph());
            $manager->persist($category);
        
        for($i=0 ; $i<= mt_rand(4, 6) ; $i++)
        {
            $article = new Article();
            $content = '<p>' . join( $faker->paragraphs(5), '</p><p>') . '</p>';
            $article->setTitle($faker_ar->sentence())
                    ->setContent($content)
                    ->setImage($faker->ImageUrl())
                    ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                    ->setCategory($category)  ;

            $manager->persist($article);

            for ($k=0; $k < mt_rand(4, 10) ; $k++) 
            {
                $comment = new Comment();
                $content = '<p>' . join( $faker_ar->paragraphs(2), '</p><p>') . '</p>';
               
                $days = (new \DateTime())->diff($article->getCreatedAt())->days;
                
                $comment->setAuthor($faker_ar->name())
                        ->setContent($content)
                        ->setCreatedAt($faker->dateTimeBetween('-' . $days .'days'))
                        ->setArticle($article);
                $manager->persist($comment);
                # code...
            }
        }
    }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
