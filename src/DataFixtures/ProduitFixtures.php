<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\DataFixtures\CategorieFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProduitFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {

            $produit = new Produit();
            $produit->setLibelle('Produit ' . $i);
            $produit->setPrix(rand(1000, 10000));
            $produit->setQteStock(rand(5, 50));

            // On récupère une catégorie aléatoire
            $categorie = $this->getReference('categorie_' . rand(0, 3), Categorie::class);

            $produit->setCategorie($categorie);

            $manager->persist($produit);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategorieFixtures::class,
        ];
    }
}