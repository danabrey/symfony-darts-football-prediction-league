<?php
// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Predictions20172018 extends Fixture
{
    private const PREDICTIONS = [
        [
            "name" => "Dan",
            "predictions" => [
                [
                    "position" => 1,
                    "team" => "MNC"
                ],
            ]
        ]
    ];

    public function load(ObjectManager $manager)
    {
        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setName('product '.$i);
            $product->setPrice(mt_rand(10, 100));
            $manager->persist($product);
        }

        $manager->flush();
    }
}