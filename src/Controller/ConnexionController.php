<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ConnexionController extends AbstractController
{
    #[Route('/', name: 'app_connexion')]
    public function index(
        Request $request,
        UtilisateurRepository $utilisateurRepository,
        SessionInterface $session
    ): Response {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('mail');
            $password = $request->request->get('mdp');

            $utilisateur = $utilisateurRepository->findOneBy(['mail' => $email]);

            if ($utilisateur && $password === $utilisateur->getMdp()) {
                if ($utilisateur->getCategUtilisateur()->getLibelle() === 'utilisateur') {
                    $session->set('utilisateur', [
                        'id' => $utilisateur->getId(),
                        'nom' => $utilisateur->getNom(),
                        'prenom' => $utilisateur->getPrenom(),
                        'email' => $utilisateur->getMail(),
                        'categ_utilisateur' => $utilisateur->getCategUtilisateur()->getLibelle(),
                    ]);
                    return $this->redirectToRoute('app_reservation');
                } else {
                    $this->addFlash('error', 'Email ou mot de passe incorrect.');
                }
            }else {
                dump($utilisateur); 
                dump($password); 
            }
        }
        return $this->render('user/connexion/index.html.twig');
    }
}
