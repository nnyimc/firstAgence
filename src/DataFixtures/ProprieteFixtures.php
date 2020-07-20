<?php

namespace App\DataFixtures;

use App\Entity\Adresse;
use App\Entity\Propriete;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProprieteFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        //Création d'adresses
        for( $i = 0; $i < 100; $i++) {
            $adresse = new Adresse();
            $adresse->setCodePostal(str_replace(' ', '', $faker->postcode));
            $adresse->setRue($faker->streetAddress);
            $adresse->setVille($faker->city);

            //Invocation de l'EntityManager
            $manager->persist($adresse);

            for ($j = 0; $j < 3; $j++) {
                //Test de l'instanciation d'une propriété
                $propriete = new Propriete();
                $propriete->setNom($faker->company);
                $propriete->setDescription($faker->paragraph);
                $propriete->setNbPieces($faker->numberBetween(1, 6));
                $propriete->setNbChambres($faker->numberBetween(1,4));
                $propriete->setSurface(rand(25, 220));
                $propriete->setEtage(rand(0, 12));
                $propriete->setPrix(rand(9000, 1500000));
                $propriete->setAdresse($adresse);

                //Invocation de l'EntityManager
                $manager->persist($propriete);
            }
        }

        $manager->flush();
    }
}
