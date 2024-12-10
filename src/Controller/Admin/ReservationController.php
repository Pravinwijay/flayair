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
    public function index(): Response
    {
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'reservationController',
        ]);
    }

    #[Route('/new', name: 'app_admin_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $reservation = new reservation();
        $form = $this->createForm(reservationType::class, $reservation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($reservation);
            $manager->flush();

            return $this->redirectToRoute('app_admin_reservation');
        }

        return $this->render('reservation/new.html.twig', [
            'form' => $form,
        ]);
    }
}
