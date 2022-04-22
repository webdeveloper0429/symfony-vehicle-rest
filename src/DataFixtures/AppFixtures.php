<?php

namespace App\DataFixtures;

use App\Entity\Vehicle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $faker;
    
    public function __construct() {

        $this->faker = Factory::create();
        $this->faker->addProvider(new \Faker\Provider\Fakecar($this->faker));
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 50; $i++) {
            $fakeCar = $this->faker->vehicleArray();
            
            $product = new Vehicle();
            $product->setDateAdded($this->faker->dateTimeBetween('-1 week'));
            $product->setType($this->faker->randomElement([Vehicle::TYPE_NEW, Vehicle::TYPE_USED]));
            $product->setMsrp($this->faker->randomFloat(2, 10000, 1000000));
            $product->setYear($this->faker->biasedNumberBetween(1998,2017, 'sqrt'));
            $product->setMake($fakeCar['brand']);
            $product->setModel($fakeCar['model']);
            $product->setMiles($this->faker->randomNumber(5, false));
            $product->setVin($this->faker->vin());
            $product->setDeleted(false);
            $manager->persist($product);
        }
        
        $manager->flush();
    }
}
