<?php

namespace App\DataFixtures;

use App\Entity\Vehicle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $faker;

    public function __construct()
    {

        $this->faker = Factory::create();
        $this->faker->addProvider(new \Faker\Provider\Fakecar($this->faker));
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 50; $i++) {
            $fakeCar = $this->faker->vehicleArray();

            $vehicle = new Vehicle();
            $vehicle->setDateAdded($this->faker->dateTimeBetween('-1 week'));
            $vehicle->setType($this->faker->randomElement([Vehicle::TYPE_NEW, Vehicle::TYPE_USED]));
            $vehicle->setMsrp($this->faker->randomFloat(2, 10000, 1000000));
            $vehicle->setYear($this->faker->biasedNumberBetween(1998, 2017, 'sqrt'));
            $vehicle->setMake($fakeCar['brand']);
            $vehicle->setModel($fakeCar['model']);
            $vehicle->setMiles($this->faker->randomNumber(5, false));
            $vehicle->setVin($this->faker->vin());
            $vehicle->setDeleted(false);
            $manager->persist($vehicle);
        }

        $manager->flush();
    }
}
