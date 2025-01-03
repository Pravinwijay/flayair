<?php

namespace App\Controller;

use App\Repository\VolRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VolController extends AbstractController
{
    #[Route('/vol', name: 'app_vol')]
    public function index(VolRepository $volRepository): Response
    {
        $vols = $volRepository->findAll();
        return $this->render('vol/index.html.twig', [
            'controller_name' => 'VolController',
            'vols'=> $vols
        ]);
    }
}
