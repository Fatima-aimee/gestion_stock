<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Achat;
use App\Repository\ProduitRepository;
use App\Repository\AchatRepository;
use App\Repository\CommandeRepository;
use App\Service\CommandeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommandeController extends AbstractController
{
    #[Route('/', name: 'list_commande')]
    public function list(CommandeRepository $repo): Response
    {
        return $this->render('commande/index.html.twig', [
            'commandes' => $repo->findAll()
        ]);
    }

    #[Route('/commande/add', name: 'add_commande')]
    public function add(
        Request $request,
        ProduitRepository $repo,
        CommandeService $service
    ): Response {

        if ($request->isMethod('POST')) {

            $commande = new Commande();

            foreach ($request->request->all('produits') as $data) {

                if (!isset($data['id']) || empty($data['quantite'])) {
                    continue;
                }

                $produit = $repo->find($data['id']);

                $achat = new Achat();
                $achat->setProduit($produit);
                $achat->setQteAchete((int)$data['quantite']);
                $achat->setPrixUnitaire($produit->getPrix());

                $commande->addAchat($achat);
            }

            $service->traiterCommande($commande);

            return $this->redirectToRoute('list_commande');
        }

        return $this->render('commande/add.html.twig', [
            'produits' => $repo->findAll()
        ]);
    }
}