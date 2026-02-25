<?php

namespace App\Service;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;

class CommandeService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function traiterCommande(Commande $commande)
    {
        $total = 0;

        foreach ($commande->getAchats() as $achat) {

            $achat->calculerMontant();

            $produit = $achat->getProduit();

            // Vérification stock
            if ($achat->getQteAchete() > $produit->getQteStock()) {
                throw new \Exception("Stock insuffisant pour " . $produit->getLibelle());
            }

            // Diminuer stock
            $produit->setQteStock(
                $produit->getQteStock() - $achat->getQteAchete()
            );

            $produit->calculerMontantStock();

            $total += $achat->getMontant();
        }

        $commande->setMontant($total);

        $this->em->persist($commande);
        $this->em->flush();
    }
}