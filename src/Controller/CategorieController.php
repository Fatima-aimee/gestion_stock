<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'list_categorie')]
    public function list(CategorieRepository $repo): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categories' => $repo->findAll()
        ]);
    }

   #[Route('/categorie/add', name: 'add_categorie')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {

            $categorie = new Categorie();
            $categorie->setLibelle($request->request->get('libelle'));

            // On persist d'abord
            $em->persist($categorie);
            $em->flush(); // ici l'id est généré

            // Génération automatique du code
            $categorie->setCode("CAT" . $categorie->getId());

            $em->flush();

            return $this->redirectToRoute('list_categorie');
        }

        return $this->render('categorie/add.html.twig');
    }
}