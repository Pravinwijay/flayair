<?php

namespace App\Controller;

use App\Repository\AeroportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(AeroportRepository $aeroportRepository, SessionInterface $session): Response
    {
        // if (!$session->has('utilisateur')) {
        //     return $this->redirectToRoute('app_connexion');
        // }

        $aeroports = $aeroportRepository->findAllWithVille();
        return $this->render('user/reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
            'aeroports' => $aeroports
        ]);
    }

    #[Route('/mes-reservations', name: 'mes-reservations')]
    public function mesReservations(SessionInterface $session): Response
    {
        // if (!$session->has('utilisateur')) {
        //     return $this->redirectToRoute('app_connexion');
        // }

        return $this->render('user/mes-reservations/index.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }
}
