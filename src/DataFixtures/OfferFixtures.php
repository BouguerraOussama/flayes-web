<?php

namespace App\DataFixtures;

use App\Entity\Funding;
use App\Entity\Offer;

use App\Repository\ProjectRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Validator\Constraints\Date;

class OfferFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10 ;$i++) {
            $faker = Faker\Factory::create();
            $funding = new Funding();

            $funding->setType($faker->randomElement(["Equity","Dept","Revenue"]));
            $funding->setAttribute1($faker->numberBetween(0, 1000));
            $funding->setAttribute2($faker->numberBetween(100, 10000));
            $funding->setAttribute3($faker->numberBetween(100, 10000));
            $funding->setTextattribute($faker->text());
            $funding->setScore($faker->randomFloat(3, 0, 1));

            $offer = new Offer();
            $offer->setTitle($faker->text(100));
            $offer->setDescription($faker->text());
            $offer->setStatus(0);
            $offer->setDateCreated(new \DateTime());
            $offer->setFunding($funding);

            $manager->persist($funding);
            $manager->persist($offer);
        }
        $manager->flush();
    }
}
