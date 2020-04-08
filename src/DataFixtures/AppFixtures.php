<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $categories = [];
        for ($i=0; $i < 20; $i++) { 
            $category = new Category();
            $category->setName($faker->word());

            $manager->persist($category);
            $categories[] = $category;
        }
        for ($j=0; $j < 70; $j++) { 
            $product = new Product();

            $product->setName($faker->word())
                ->setDescription($faker->text())
                ->setPrice($faker->randomFloat(2,1, 150))
                ->addCategory($categories[$faker->numberBetween(0, count($categories) -1)]);
            for ($i=0; $i < $faker->numberBetween(0,5); $i++) { 
                $product->addCategory($categories[$faker->numberBetween(0, count($categories) -1)]);
            }
            $manager->persist($product);
        }

        $manager->flush();
    }
}
