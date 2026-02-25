<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'list_produit')]
    public function list(ProduitRepository $repo): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $repo->findAll()
        ]);
    }

    #[Route('/produit/add', name: 'add_produit')]
    public function add(
        Request $request,
        EntityManagerInterface $em,
        CategorieRepository $catRepo
    ): Response {

        if ($request->isMethod('POST')) {

            $produit = new Produit();
            $produit->setLibelle($request->request->get('libelle'));
            $produit->setPrix((float)$request->request->get('prix'));
            $produit->setQteStock((int)$request->request->get('qteStock'));

            $categorie = $catRepo->find($request->request->get('categorie'));
            $produit->setCategorie($categorie);

            // Calcul automatique
            $produit->calculerMontantStock();

            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('list_produit');
        }

        return $this->render('produit/add.html.twig', [
            'categories' => $catRepo->findAll()
        ]);
    }
}