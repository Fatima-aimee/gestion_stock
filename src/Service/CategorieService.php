<?php

namespace App\Service;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;

class CategorieService
{
    private CategorieRepository $repository;

    public function __construct(CategorieRepository $repository)
    {
        $this->repository = $repository;
    }

    public function ajouter(string $libelle): void
    {
        $categorie = new Categorie($libelle);
        $this->repository->save($categorie);

        echo "Catégorie ajoutée avec succès.\n";
    }

    public function lister(): void
    {
        $categories = $this->repository->findAll();

        foreach ($categories as $cat) {
            echo $cat["id"] . " - " . $cat["libelle"] . "\n";
        }
    }
}