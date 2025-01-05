<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Avion;
use App\Form\AvionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/avion')]

class AvionController extends AbstractController
{
    #[Route('', name: 'app_admin_avion', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin/avion/index.html.twig', [
            'controller_name' => 'avionController',
        ]);
    }

    #[Route('/new', name: 'app_admin_avion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $avion = new avion();
        $form = $this->createForm(avionType::class, $avion);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($avion);
            $manager->flush();

            return $this->redirectToRoute('app_admin_avion');
        }

        return $this->render('admin/avion/new.html.twig', [
            'form' => $form,
        ]);
    }
}
