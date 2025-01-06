<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Avion;
use App\Form\AvionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/avion')]
class AvionController extends AbstractController
{
    #[Route('', name: 'app_admin_avion', methods: ['GET'])]
    public function index(EntityManagerInterface $manager): Response
    {
        $avions = $manager->getRepository(Avion::class)->findAll();

        return $this->render('admin/avion/index.html.twig', [
            'avions' => $avions,
        ]);
    }

    #[Route('/new', name: 'app_admin_avion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $avion = new Avion();
        $form = $this->createForm(AvionType::class, $avion);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($avion);
            $manager->flush();

            $this->addFlash('success', 'Avion ajouté avec succès !');
            return $this->redirectToRoute('app_admin_avion');
        }

        return $this->render('admin/avion/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_avion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Avion $avion, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(AvionType::class, $avion);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', 'Avion modifié avec succès !');
            return $this->redirectToRoute('app_admin_avion');
        }

        return $this->render('admin/avion/edit.html.twig', [
            'form' => $form->createView(),
            'avion' => $avion,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_avion_delete', methods: ['POST'])]
    public function delete(Request $request, Avion $avion, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$avion->getId(), $request->request->get('_token'))) {
            $manager->remove($avion);
            $manager->flush();

            $this->addFlash('success', 'Avion supprimé avec succès !');
        }

        return $this->redirectToRoute('app_admin_avion');
    }
}
