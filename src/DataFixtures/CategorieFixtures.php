<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategorieFixtures extends Fixture
{
     public function load(ObjectManager $manager): void
    {
        $categories = [
            'Alimentaire',
            'Informatique',
            'Vêtements',
            'Bureautique'
        ];

        foreach ($categories as $index => $libelle) {

            $categorie = new Categorie();
            $categorie->setLibelle($libelle);

            $manager->persist($categorie);

            // On enregistre une référence pour les autres fixtures
            $this->addReference('categorie_' . $index, $categorie);
        }

        $manager->flush();
    }
}
