<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/reservation')]
class ReservationController extends AbstractController
{
    #[Route('', name: 'app_admin_reservation', methods: ['GET'])]
    public function index(EntityManagerInterface $manager): Response
    {
        $reservations = $manager->getRepository(Reservation::class)->findAll();

        return $this->render('admin/reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route('/new', name: 'app_admin_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($reservation);
            $manager->flush();

            return $this->redirectToRoute('app_admin_reservation');
        }

        return $this->render('admin/reservation/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', 'Réservation modifiée avec succès !');
            return $this->redirectToRoute('app_admin_reservation');
        }

        return $this->render('admin/reservation/edit.html.twig', [
            'form' => $form->createView(),
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_reservation_delete', methods: ['POST'])]
    public function delete(Reservation $reservation, EntityManagerInterface $manager): Response
    {
        $manager->remove($reservation);
        $manager->flush();

        $this->addFlash('success', 'Réservation supprimée avec succès !');
        return $this->redirectToRoute('app_admin_reservation');
    }
}
