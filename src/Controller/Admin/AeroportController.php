<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Aeroport;
use App\Form\AeroportType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/aeroport')]
class AeroportController extends AbstractController
{
    #[Route('', name: 'app_admin_aeroport', methods: ['GET'])]
    public function index(EntityManagerInterface $manager): Response
    {
        // Récupérer tous les aéroports pour les afficher
        $aeroports = $manager->getRepository(Aeroport::class)->findAll();

        return $this->render('admin/aeroport/index.html.twig', [
            'aeroports' => $aeroports,
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

            $this->addFlash('success', 'Aéroport ajouté avec succès !');
            return $this->redirectToRoute('app_admin_aeroport');
        }

        return $this->render('admin/aeroport/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_aeroport_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Aeroport $aeroport, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(AeroportType::class, $aeroport);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', 'Aéroport modifié avec succès !');
            return $this->redirectToRoute('app_admin_aeroport');
        }

        return $this->render('admin/aeroport/edit.html.twig', [
            'form' => $form->createView(),
            'aeroport' => $aeroport,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_aeroport_delete', methods: ['POST'])]
    public function delete(Aeroport $aeroport, EntityManagerInterface $manager): Response
    {
        $manager->remove($aeroport);
        $manager->flush();

        $this->addFlash('success', 'Aéroport supprimé avec succès !');
        return $this->redirectToRoute('app_admin_aeroport');
    }
}
