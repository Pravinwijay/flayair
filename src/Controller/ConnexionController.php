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

            if ($utilisateur) {
              
                if (password_verify($password, $utilisateur->getMdp())) {
                    
                    $categorieUtilisateur = $utilisateur->getCategUtilisateur()->getLibelle();

                    
                    $session->set('utilisateur', [
                        'id' => $utilisateur->getId(),
                        'nom' => $utilisateur->getNom(),
                        'prenom' => $utilisateur->getPrenom(),
                        'email' => $utilisateur->getMail(),
                        'categ_utilisateur' => $categorieUtilisateur,
                    ]);

                    
                    if ($categorieUtilisateur === 'utilisateur') {
                        return $this->redirectToRoute('app_reservation');
                    } elseif ($categorieUtilisateur === 'administrateur') {
                        return $this->redirectToRoute('app_admin_accueil'); 
                    } else {
                        
                        $this->addFlash('error', 'Rôle inconnu');
                    }
                } else {
                   
                    $this->addFlash('error', 'Mot de passe incorrect');
                }
            } else {
                
                $this->addFlash('error', 'Email incorrect');
            }
        }

        
        return $this->render('user/connexion/index.html.twig');
    }
}

