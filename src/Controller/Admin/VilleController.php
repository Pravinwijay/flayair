<?php
namespace App\Controller\Admin;

use App\Entity\Ville;
use App\Form\VilleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/ville')]
class VilleController extends AbstractController
{
    #[Route('', name: 'app_admin_ville_index', methods: ['GET'])]
    public function index(EntityManagerInterface $manager): Response
    {
        $villes = $manager->getRepository(Ville::class)->findAll();

        return $this->render('admin/ville/index.html.twig', [
            'villes' => $villes,
        ]);
    }

    #[Route('/new', name: 'app_admin_ville_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $ville = new Ville();
        $form = $this->createForm(VilleType::class, $ville);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($ville);
            $manager->flush();

            $this->addFlash('success', 'Ville ajoutée avec succès !');
            return $this->redirectToRoute('app_admin_ville_index');
        }

        return $this->render('admin/ville/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_ville_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ville $ville, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(VilleType::class, $ville);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', 'Ville modifiée avec succès !');
            return $this->redirectToRoute('app_admin_ville_index');
        }

        return $this->render('admin/ville/edit.html.twig', [
            'form' => $form->createView(),
            'ville' => $ville,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_ville_delete', methods: ['POST'])]
public function delete(Ville $ville, EntityManagerInterface $manager): Response
{
    // Supprimer l'entité Ville
    $manager->remove($ville);
    $manager->flush();  // Appliquer la suppression

    // Ajouter un message flash pour la confirmation
    $this->addFlash('success', 'Ville supprimée avec succès !');

    // Rediriger vers la liste des villes
    return $this->redirectToRoute('app_admin_ville_index');
}

    
}
