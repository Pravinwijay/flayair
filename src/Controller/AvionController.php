<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Avion;
use App\Repository\AvionRepository;

class AvionController extends AbstractController
{
    #[Route('/avion/insert', name: 'app_avion_insert', methods: ['GET', 'POST'])]
    public function insert(Request $request, AvionRepository $avionRepository): Response
    {
        if ($request->isMethod('POST')) {
            // Récupérer les données du formulaire
            $modele = $request->request->get('modele');
            $nbPlaces = $request->request->get('nbPlaces');

            // Créer une nouvelle instance d'Avion
            $avion = new Avion();
            $avion->setModele($modele);
            $avion->setNbPlaces($nbPlaces);

            // Utiliser le repository pour sauvegarder l'avion
            $avionRepository->save($avion);  // Le repository appelle EntityManager pour persister l'entité

            // Message de confirmation
            return $this->render('avion/insert.html.twig', [
                'controller_name' => 'AvionController',
                'insertion' => 'L\'avion a été inséré avec succès.'
            ]);
        }

        // Si aucune donnée n'est soumise, afficher le formulaire
        return $this->render('avion/insert.html.twig', [
            'controller_name' => 'AvionController',
        ]);
    }
}
