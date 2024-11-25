<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FonctCategController extends AbstractController
{
    #[Route('/fonct/categ', name: 'app_fonct_categ')]
    public function index(): Response
    {
        return $this->render('fonct_categ/index.html.twig', [
            'controller_name' => 'FonctCategController',
        ]);
    }
}
