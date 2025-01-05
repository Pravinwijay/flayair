<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Aeroport;
use App\Form\AeroportType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/accueil')]

class AccueilController extends AbstractController
{
    #[Route('', name: 'app_admin_accueil', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin/accueil.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

}
