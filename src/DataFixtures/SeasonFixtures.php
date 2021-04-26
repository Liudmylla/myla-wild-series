<?php


namespace App\DataFixtures;


use App\Entity\Season;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()  
    {
        return [ProgramFixtures::class];
    }
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 30; $i++) {
            $faker  =  Faker\Factory::create('en_EN');
            $season = new Season();
            $season->setNumber($faker->numberBetween(1,8));
            $season->setDescription($faker->text);
            $season->setYear($faker->year);
            $season->setDescription($faker->text);
            $season->setProgram($this->getReference('program_' . rand(0,4)));
            $this->addReference('season_' . $i, $season);
            $manager->persist($season);

        }

        $manager->flush();
    }
}
