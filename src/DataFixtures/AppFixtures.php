<?php

namespace App\DataFixtures;

use App\Entity\Serie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture// implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $this->addSeries($manager);
    }

    private function addSeries(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {

            $serie = new Serie();
            $serie
                ->setBackdrop($faker->realText(10))
                ->setDateCreated(new \DateTime())
                ->setGenres($faker->randomElement(["Western", "SF", "Drama", "Comedy"]))
                ->setName($faker->realText(10))
                ->setNbLike($faker->numberBetween(0, 500))
                ->setFirstAirDate($faker->dateTimeBetween("-6 year"));
            $serie
                ->setLastAirDate($faker->dateTimeBetween($serie->getFirstAirDate()))
                ->setPopularity($faker->numberBetween(0, 9999))
                ->setVote($faker->numberBetween(0, 10))
                ->setPoster($faker->text(20))
                ->setStatus($faker->randomElement(["ended", "returning", "canceled"]))
                ->setTmdbId(12345);

            $manager->persist($serie);
        }
        $manager->flush();

    }

//    public function getDependencies(): array
//    {
//        return [
//            AppFixtures::class
//        ];
//    }
}
