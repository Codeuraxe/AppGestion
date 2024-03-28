<?php

namespace App\Controller\admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\FormationRepository;
use App\Repository\CategorieRepository;
use App\Entity\Formation;
use App\Form\FormationType;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Contrôleur pour les formations d'administration.
 * @Route("/admin")
 */
class AdminFormationsController extends AbstractController
{
    private $formationRepository;
    private $categorieRepository;

    public function __construct(FormationRepository $formationRepository, CategorieRepository $categorieRepository)
    {
        $this->formationRepository = $formationRepository;
        $this->categorieRepository = $categorieRepository;
    }

    /**
     * @Route("", name="admin.formations")
     */
    public function index(): Response
    {
        $formations = $this->formationRepository->findAllOrderBy('title', 'ASC');
        $categories = $this->categorieRepository->findAll();

        return $this->render("admin/admin.formations.html.twig", [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/formation/delete/{id}", name="admin.formation.delete")
     */
    public function delete(Formation $formation, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($formation);
        $entityManager->flush();

        return $this->redirectToRoute('admin.formations');
    }

    /**
     * @Route("/edit/{id}", name="admin.edit.formations")
     */
    public function edit(Request $request, Formation $formations, EntityManagerInterface $entityManager): Response
    {
        $formformation = $this->createForm(FormationType::class, $formations);
        $formformation->handleRequest($request);

        if ($formformation->isSubmitted() && $formformation->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('admin.formations');
        }

        return $this->render('admin/admin.edit.formations.html.twig', [
            'form' => $formformation->createView(),
        ]);
    }

            /**
 * @Route("/ajout", name="admin.ajout.formations")
 */
public function ajout(Request $request, EntityManagerInterface $entityManager): Response
{
    $formations = new Formation();
    $formformation = $this->createForm(FormationType::class, $formations);
    $formformation->handleRequest($request);

    if ($formformation->isSubmitted() && $formformation->isValid()) {
        $entityManager->persist($formations); // Ajoutez cette ligne pour persister l'entité
        $entityManager->flush();
        return $this->redirectToRoute('admin.formations');
    }

    return $this->render('admin/admin.ajout.formations.html.twig', [
        'form' => $formformation->createView(),
    ]);
}

    /**
     * @Route("/formations/tri/{champ}/{ordre}/{table}", name="admin.formations.sort")
     */
    public function sort($champ, $ordre, $table = ""): Response
    {
        $formations = $this->formationRepository->findAllOrderBy($champ, $ordre, $table);
        $categories = $this->categorieRepository->findAll();

        return $this->render('admin/admin.formations.html.twig', [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/formations/recherche/{champ}/{table}", name="admin.formations.findallcontain")
     */
    public function findAllContain($champ, Request $request, $table = ""): Response
    {
        $valeur = $request->get("recherche");
        $formations = $this->formationRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();

        return $this->render('admin/admin.formations.html.twig', [
            'formations' => $formations,
            'categories' => $categories,
            'valeur' => $valeur,
            'table' => $table
        ]);
    }
}