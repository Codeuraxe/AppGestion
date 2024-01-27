<?php

namespace App\Controller\admin;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class AdminCategoriesController extends AbstractController
{
    private $categorieRepository;

    public function __construct(CategorieRepository $categorieRepository)
    {
        $this->categorieRepository = $categorieRepository;
    }

    /**
     * @Route("/admin/categories", name="admin.categories")
     */
    public function index(): Response
    {
        $categories = $this->categorieRepository->findAll();
        return $this->render("admin/admin.categories.html.twig", [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/categorie/delete/{id}", name="admin.categorie.delete")
     */
    public function delete(Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($categorie);
        $entityManager->flush();
        return $this->redirectToRoute('admin.categories');
    }

    /**
     * @Route("/admin/categorie/ajout", name="admin.ajout.categories")
     */
    public function ajout(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nomCategorie = $request->request->get('nom_categorie');

        if ($nomCategorie) {
            $categorie = new Categorie();
            $categorie->setName($nomCategorie);

            // Vérifier si la catégorie existe déjà
            $existingCategories = $this->categorieRepository->findBy(['name' => $nomCategorie]);

            if (empty($existingCategories)) {
                // Ajouter une nouvelle catégorie
                $entityManager->persist($categorie);
                $entityManager->flush();

                $this->addFlash('success', 'La catégorie a été ajoutée avec succès.');
                return $this->redirectToRoute('admin.categories');
            } else {
                $this->addFlash('danger', 'La catégorie existe déjà.');
            }
        }

        $categories = $this->categorieRepository->findAll();

        return $this->render('admin/admin.categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     *
     * @Route("/admin/categories/tri/{champ}/{ordre}", name="admin.categories.sort")
     * @param type $champ
     * @param type $ordre
     * @return Response
     */
    public function sort($champ, $ordre): Response
    {
        $categories = $this->categorieRepository->findAllOrderBy($champ, $ordre);
        $formations = $this->formationRepository->findAll();
        return $this->render('/admin/admin.categories.html.twig', [
            'formations' => $formations,
            'categories' => $categories,
        ]);
    }
}