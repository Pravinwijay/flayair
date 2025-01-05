<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Aeroport;
use App\Form\AeroportType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/aeroport')]

class AeroportController extends AbstractController
{
    #[Route('', name: 'app_admin_aeroport', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin/aeroport/index.html.twig', [
            'controller_name' => 'AeroportController',
        ]);
    }

    #[Route('/new', name: 'app_admin_aeroport_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $aeroport = new Aeroport();
        $form = $this->createForm(AeroportType::class, $aeroport);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($aeroport);
            $manager->flush();

            return $this->redirectToRoute('app_admin_aeroport');
        }

        return $this->render('admin/aeroport/new.html.twig', [
            'form' => $form,
        ]);
    }
}
