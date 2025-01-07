<?php 
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(Request $request): Response
    {
       
        if ($request->isMethod('POST')) {
            $nom = $request->request->get('nom');
            $prenom = $request->request->get('prenom');
            $email = $request->request->get('mail');
            $password = $request->request->get('mdp');

           
            if (empty($nom) || empty($prenom) || empty($email) || empty($password)) {
                $this->addFlash('error', 'Tous les champs doivent être remplis.');
                return $this->redirectToRoute('app_inscription');
            }

           
            $pdo = new \PDO('mysql:host=localhost;dbname=flyair;charset=utf8', 'root', 'myrootpass2024*');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            
            $stmt = $pdo->prepare("SELECT id FROM categ_utilisateur WHERE libelle = :libelle");
            $stmt->bindParam(':libelle', $libelle);
            $libelle = 'utilisateur'; 
            $stmt->execute();
            $categUtilisateur = $stmt->fetchColumn();

           
            if (!$categUtilisateur) {
                $this->addFlash('error', 'Catégorie "utilisateur" introuvable.');
                return $this->redirectToRoute('app_inscription');
            }

            
            $stmt = $pdo->prepare("INSERT INTO utilisateur (nom, prenom, mail, mdp, categ_utilisateur_id) VALUES (:nom, :prenom, :mail, :mdp, :categ_utilisateur_id)");
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':mail', $email);
            $stmt->bindParam(':mdp', $hashedPassword);
            $stmt->bindParam(':categ_utilisateur_id', $categUtilisateur); 

            
            try {
                $stmt->execute();
                
                $this->addFlash('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
                return $this->redirectToRoute('app_connexion');
            } catch (\PDOException $e) {
                $this->addFlash('error', 'Une erreur est survenue lors de l\'inscription : ' . $e->getMessage());
                return $this->redirectToRoute('app_inscription');
            }
        }

        return $this->render('user/inscription/index.html.twig');
    }
}



