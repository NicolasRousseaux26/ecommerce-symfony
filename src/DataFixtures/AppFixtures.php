<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $categories = [];
        for ($i = 0; $i < 5; ++$i) {
            $category = new Category();
            $category->setName('Catégorie '.$i);
            $category->setSlug('categorie-'.$i);
            $manager->persist($category);
            $categories[] = $category;
        }

        $colors = ['Bleu', 'Rouge', 'Vert'];
        for ($i = 0; $i < 100; ++$i) {
            $product = new Product();
            $product->setName('Produit '.$i);
            $product->setSlug('produit-'.$i);
            $product->setDescription($faker->text);
            $product->setPrice($faker->numberBetween(9900, 999900));
            $product->setCreatedAt($faker->dateTimeBetween('-30 days'));
            $product->setIsHeartStroke($faker->boolean);
            $product->setColors($faker->randomElements($colors, rand(0, count($colors))));
            $product->setImage(null);
            $product->setDiscount($faker->numberBetween(0, 90));
            $product->setCategory($faker->randomElement($categories));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
