<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Service\Slugify;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface

{
    private $slugify;

    public function __construct (Slugify $slugify)
    {
       $this->slugify = $slugify;
    }
    public function getDependencies()  
    {
        return [SeasonFixtures::class];
    }
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 50; $i++) {
            $faker  =  Faker\Factory::create('en_EN');
            $episode = new Episode();
            $episode->setTitle($faker->name);
            $episode->setNumber($faker->numberBetween(1,15));
            $episode->setSynopsis($faker->text);
            $episode->setSeason($this->getReference('season_' . rand(0,20)));
            $slug = $this->slugify->generate($episode->getTitle());
            $episode->setSlug($slug);
            $manager->persist($episode);

        }

        $manager->flush();
    }
}
