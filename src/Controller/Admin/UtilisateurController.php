<?php
namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/utilisateur')]
class UtilisateurController extends AbstractController
{
    #[Route('', name: 'app_admin_utilisateur', methods: ['GET'])]
    public function index(EntityManagerInterface $manager): Response
    {
        $utilisateurs = $manager->getRepository(Utilisateur::class)->findAll();

        return $this->render('admin/utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurs,
        ]);
    }

    #[Route('/new', name: 'app_admin_utilisateur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($utilisateur);
            $manager->flush();

            $this->addFlash('success', 'Utilisateur ajouté avec succès !');
            return $this->redirectToRoute('app_admin_utilisateur');
        }

        return $this->render('admin/utilisateur/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

