<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $product = new Product();
            $product->setProductID('P01');
            $product->setName("Iphone $i");
            $product->setPrice(rand(100, 500));
            $product->setImage("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSKJYD-1T1kcwhQHYSvQTuxmg_dS5IiJs6irA&usqp=CAU");
            $manager->persist($product);
        }
        $manager->flush();
    }
}
