<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Property;
use Faker\Factory;

class PropertyFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for($i=0; $i<=100; $i++)
        {
            $property=new Property();
            $property->setTitle($faker->words(3, true));
            $property->setDescription($faker->sentences(6, true));
            $property->setSurface($faker->numberBetween(20, 400));
            $property->setRooms($faker->numberBetween(1, 10));
            $property->setBedrooms($faker->numberBetween(1,10));
            $property->setAddress($faker->address);
            $property->setCity($faker->city);
            $property->setPostalCode($faker->postcode);
            $property->setFloor($faker->numberBetween(1,20));
            $property->setHeat($faker->numberBetween(0, count(Property::HEAT)-1));
            $property->setPrice($faker->numberBetween(100000, 1000000));
            $property->setSold(false);
            
            $manager->persist($property);
        }

        $manager->flush();
    }
}
