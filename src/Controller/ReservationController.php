<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Utilisateur;
use App\Repository\AeroportRepository;
use App\Repository\ReservationRepository;
use App\Repository\VolRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(
        AeroportRepository $aeroportRepository,
        SessionInterface $session,
        VolRepository $volRepository,
        Request $request
    ): Response {
        $utilisateurId = $session->get('utilisateur')['id'] ?? null;
        if (!$utilisateurId) {
            return $this->redirectToRoute('app_connexion');
        }

        $aeroports = $aeroportRepository->findAllWithVille();
        $vols = [];
        $fromAirport = null;
        $toAirport = null;

        if ($request->isMethod('POST')) {
            $fromId = $request->request->get('from');
            $toId = $request->request->get('to');

            if ($fromId && $toId) {
                $fromAirport = $aeroportRepository->find($fromId);
                $toAirport = $aeroportRepository->find($toId);

                if ($fromAirport && $toAirport) {
                    $vols = $volRepository->findBy([
                        'aeroportDepart' => $fromAirport,
                        'aeroportArrive' => $toAirport,
                    ]);
                }
            }
        }
        return $this->render('user/reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
            'aeroports' => $aeroports,
            'vols' => $vols,
            'fromAirport' => $fromAirport,
            'toAirport' => $toAirport,
        ]);
    }

    #[Route('/mes-reservations', name: 'mes-reservations')]
    public function mesReservations(
        ReservationRepository $reservationRepository,
        SessionInterface $session
    ): Response {
        $utilisateurId = $session->get('utilisateur')['id'] ?? null;
        if (!$utilisateurId) {
            return $this->redirectToRoute('app_connexion');
        }

        $reservations = $reservationRepository->findBy(['utilisateur' => $utilisateurId]);

        return $this->render('user/mes-reservations/index.html.twig', [
            'controller_name' => 'ReservationController',
            'reservations' => $reservations,
        ]);
    }

    #[Route('/reservation/confirmer', name: 'reservation_confirmer', methods: ['POST'])]
    public function confirmerReservation(
        Request $request,
        SessionInterface $session,
        VolRepository $volRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $utilisateurId = $session->get('utilisateur')['id'] ?? null;
        $utilisateur = $entityManager->getRepository(Utilisateur::class)->find($utilisateurId);

        if (!$utilisateurId) {
            return $this->redirectToRoute('app_connexion');
        }

        $volId = $request->request->get('volId');
        $vol = $volRepository->find($volId);

        if (!$vol) {
            $this->addFlash('error', 'Vol introuvable.');
            return $this->redirectToRoute('app_reservation');
        }

        $reservation = new Reservation();
        $reservation->setUtilisateur($utilisateur); 
        $reservation->setVol($vol);

        $entityManager->persist($reservation);
        $entityManager->flush();

        $this->addFlash('success', 'Réservation confirmée avec succès.');

        return $this->redirectToRoute('mes-reservations');
    }

    #[Route('/reservation/delete/{id}', name: 'reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reservation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
            $this->addFlash('success', 'La réservation a été annulée avec succès.');
        }

        return $this->redirectToRoute('mes_reservations');
    }

}
