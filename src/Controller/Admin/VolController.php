<?php

namespace App\Controller\Admin;

use App\Entity\Vol;
use App\Form\VolType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/vol')]
class VolController extends AbstractController
{
    #[Route('', name: 'app_admin_vol', methods: ['GET'])]
    public function index(EntityManagerInterface $manager): Response
    {
        // Récupérer tous les vols de la base de données
        $vols = $manager->getRepository(Vol::class)->findAll();

        // Rendre la vue avec les vols
        return $this->render('admin/vol/index.html.twig', [
            'vols' => $vols,
        ]);
    }

    #[Route('/new', name: 'app_admin_vol_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $vol = new Vol();
        $form = $this->createForm(VolType::class, $vol);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($vol);
            $manager->flush();

            return $this->redirectToRoute('app_admin_vol');
        }

        return $this->render('admin/vol/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_vol_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vol $vol, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(VolType::class, $vol);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', 'Vol modifié avec succès !');
            return $this->redirectToRoute('app_admin_vol');
        }

        return $this->render('admin/vol/edit.html.twig', [
            'form' => $form->createView(),
            'vol' => $vol,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_vol_delete', methods: ['POST'])]
    public function delete(Vol $vol, EntityManagerInterface $manager): Response
    {
        // Supprimer le vol sans vérifier CSRF
        $manager->remove($vol);
        $manager->flush();

        $this->addFlash('success', 'Vol supprimé avec succès !');

        return $this->redirectToRoute('app_admin_vol');
    }
}
