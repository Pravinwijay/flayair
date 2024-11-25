<?php
// src/Controller/AvionController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Avion;
use App\Repository\AvionRepository;

class AvionController extends AbstractController
{
    #[Route('/avion', name: 'app_avion')]
    public function index(): Response
    {

         // Créer une nouvelle instance d'Avion
         $avion = new Avion();
         // Utiliser le repository pour insérer l'avion
         $avionRepository->save($avion);
        return $this->render('avion/index.html.twig', [
            'controller_name' => 'AvionController',
        ]);
    }

    #[Route('/avion/insert', name: 'app_avion_insert', methods: ['GET', 'POST'])]
    public function insert(Request $request, AvionRepository $avionRepository): Response
    {
        // Si le formulaire est soumis
        if ($request->isMethod('POST')) {
            $modele = $request->request->get('modele');
            $nbPlaces = $request->request->get('nbPlaces');

            // Créer une nouvelle instance d'Avion
            $avion = new Avion();
            $avion->setModele($modele);
            $avion->setNbPlaces($nbPlaces);

            // Utiliser le repository pour insérer l'avion
            $avionRepository->insertAvion($avion);

            // Renvoyer une réponse avec un message de confirmation
            return $this->render('avion/insert.html.twig', [ // Mise à jour du chemin
                'controller_name' => 'AvionController',
                'insertion' => 'L\'avion a été inséré avec succès.'
            ]);
        }

        // Afficher le formulaire d'insertion
        return $this->render('avion/insert.html.twig', [ // Mise à jour du chemin
            'controller_name' => 'AvionController',
        ]);
    }
}
