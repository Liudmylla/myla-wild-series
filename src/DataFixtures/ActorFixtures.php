<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()  
    {
        return [ProgramFixtures::class];
    }
    const ACTORS = [
        'Steve McQueen',
        'Al Pacino',
        'Paul Newman',
        'Robert De Niro',
        'John Wayne',
        'Clint Eastwood',
        'Marlon Brando'
    ];
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);


        foreach (self::ACTORS as $key=>$actorName){  

            $actor = new Actor();  
    
            $actor->setName($actorName);  

            for($i=0;$i<rand(1,4);$i++){
                $actor->addProgram($this->getReference('program_' . rand(0,4)));
            }
    
            $manager->persist($actor);  

             
        }  

        $manager->flush();
    }
   
}
