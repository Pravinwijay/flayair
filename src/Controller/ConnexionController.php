<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ConnexionController extends AbstractController
{
    #[Route('/connexion', name: 'app_connexion')]
    public function index(
        Request $request,
        UtilisateurRepository $utilisateurRepository,
        SessionInterface $session
    ): Response {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('mail');
            $password = $request->request->get('mdp');

            // Recherche de l'utilisateur par son email
            $utilisateur = $utilisateurRepository->findOneBy(['mail' => $email]);

            if ($utilisateur) {
                // Vérification si le mot de passe en clair correspond
                if ($password === $utilisateur->getMdp()) {
                    // Vérification de la catégorie de l'utilisateur
                    $categorieUtilisateur = $utilisateur->getCategUtilisateur()->getLibelle();

                    // Stockage des informations dans la session
                    $session->set('utilisateur', [
                        'id' => $utilisateur->getId(),
                        'nom' => $utilisateur->getNom(),
                        'prenom' => $utilisateur->getPrenom(),
                        'email' => $utilisateur->getMail(),
                        'categ_utilisateur' => $categorieUtilisateur,
                    ]);

                    // Redirection en fonction du rôle
                    if ($categorieUtilisateur === 'utilisateur') {
                        
                        return $this->redirectToRoute('app_reservation');
                    } elseif ($categorieUtilisateur === 'administrateur') {
                       
                        return $this->redirectToRoute('app_admin_accueil'); 
                    } else {
                        // Si l'utilisateur n'a pas un rôle reconnu
                        $this->addFlash('error', 'Rôle inconnu');
                    }
                } else {
                    // Si le mot de passe est incorrect
                    $this->addFlash('error', 'Mot de passe incorrect');
                }
            } else {
                // Si l'utilisateur n'existe pas
                $this->addFlash('error', 'Email incorrect');
            }
        }

        // Retourner la vue de connexion
        return $this->render('user/connexion/index.html.twig');
    }
}
