<?php
namespace App\Controller;

use App\Repository\AeroportRepository;
use App\Repository\ReservationRepository;  // Ajout du repository des réservations
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(AeroportRepository $aeroportRepository, SessionInterface $session): Response
    {
        // Vérifier si l'utilisateur est connecté
        $utilisateurId = $session->get('utilisateur')['id'] ?? null;
        if (!$utilisateurId) {
            // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
            return $this->redirectToRoute('app_connexion');
        }

        // Récupérer tous les aéroports avec leurs villes
        $aeroports = $aeroportRepository->findAllWithVille();
        return $this->render('user/reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
            'aeroports' => $aeroports
        ]);
    }

    #[Route('/mes-reservations', name: 'mes-reservations')]
    public function mesReservations(ReservationRepository $reservationRepository, SessionInterface $session): Response
    {
        // Vérifier si l'utilisateur est connecté
        $utilisateurId = $session->get('utilisateur')['id'] ?? null;
        if (!$utilisateurId) {
            // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
            return $this->redirectToRoute('app_connexion');
        }

        // Récupérer les réservations de l'utilisateur connecté
        $reservations = $reservationRepository->findBy(['utilisateur' => $utilisateurId]);

        return $this->render('user/mes-reservations/index.html.twig', [
            'controller_name' => 'ReservationController',
            'reservations' => $reservations
        ]);
    }
}
