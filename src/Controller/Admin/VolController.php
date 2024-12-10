<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Vol;
use App\Form\VolType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/vol')]

class VolController extends AbstractController
{
    #[Route('', name: 'app_admin_vol', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('vol/index.html.twig', [
            'controller_name' => 'volController',
        ]);
    }

    #[Route('/new', name: 'app_admin_vol_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $vol = new vol();
        $form = $this->createForm(volType::class, $vol);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($vol);
            $manager->flush();

            return $this->redirectToRoute('app_admin_vol');
        }

        return $this->render('vol/new.html.twig', [
            'form' => $form,
        ]);
    }
}
