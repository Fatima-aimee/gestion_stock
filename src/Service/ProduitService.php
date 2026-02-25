<?php

namespace App\Service;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;

use Exception;
class ProduitService
{
    private ProduitRepository $repository;
    private CategorieRepository $categorieRepository;

    public function __construct(ProduitRepository $repository, CategorieRepository $categorieRepository)
    {
        $this->repository = $repository;
        $this->categorieRepository = $categorieRepository;
    }

    public function ajouter($lib,$prix,$qte,$cat){
        if(empty($lib)||empty($prix)||empty($qte)) throw new Exception("Champs obligatoires");
        $this->repository->save(new Produit($lib,$prix,$qte,$cat));
    }
    public function lister(){ return $this->repository->findAll(); }
}