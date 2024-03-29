<?php

namespace App\Controller\admin;

use App\Entity\Playlist;
use App\Entity\Formation; 
use App\Form\PlaylistType;
use App\Repository\PlaylistRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class AdminPlaylistsController extends AbstractController
{
    private $playlistRepository;
    private $categorieRepository;

    public function __construct(PlaylistRepository $playlistRepository, CategorieRepository $categorieRepository)
    {
        $this->playlistRepository = $playlistRepository;
        $this->categorieRepository = $categorieRepository;
    }

    /**
     * @Route("/admin/playlists", name="admin.playlists")
     */
    public function index(): Response
    {
        $playlists = $this->playlistRepository->findAll();
        $categories = $this->categorieRepository->findAll();
        return $this->render("admin/admin.playlists.html.twig", [
            'playlists' => $playlists,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/playlist.delete/{id}", name="admin.playlist.delete")
     */
    public function delete(Playlist $playlist, EntityManagerInterface $entityManager): Response
    {
        // Trouver toutes les formations liées à la playlist et les supprimer
        $formations = $entityManager->getRepository(Formation::class)->findBy(['playlist' => $playlist]);
        foreach ($formations as $formation) {
            $entityManager->remove($formation);
        }

        // Après avoir supprimé les formations, supprimer la playlist
        $entityManager->remove($playlist);
        $entityManager->flush();

        // Rediriger vers la page listant les playlists, ou une autre page de votre choix
        return $this->redirectToRoute('admin.playlists');
    }

    /**
     * @Route("/admin/playlist/edit/{id}", name="admin.edit.playlists")
     */
    public function edit(Request $request, Playlist $playlist, EntityManagerInterface $entityManager): Response
    {
        $formPlaylist = $this->createForm(PlaylistType::class, $playlist);
        $formPlaylist->handleRequest($request);

        if ($formPlaylist->isSubmitted() && $formPlaylist->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('admin.playlists');
        }
        $categories = $this->categorieRepository->findAll();
        return $this->render('admin/admin.edit.playlists.html.twig', [
            'formplaylist' => $formPlaylist->createView(),
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/playlist/ajout", name="admin.ajout.playlists")
     */
    public function ajout(Request $request, EntityManagerInterface $entityManager): Response
    {
        $playlist = new Playlist();
        $form = $this->createForm(PlaylistType::class, $playlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($playlist);
            $entityManager->flush();
            return $this->redirectToRoute('admin.playlists');
        }
        $categories = $this->categorieRepository->findAll();
        return $this->render('admin/admin.ajout.playlists.html.twig', [
            'formplaylist' => $form->createView(),
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/playlists/tri/{champ}/{ordre}/{table}", name="admin.playlists.sort")
     */
    public function sort($champ, $ordre, $table = ""): Response
    {
        if ($champ == 'name') {
            $playlists = $this->playlistRepository->findAllOrderByName($ordre);
        } elseif ($champ == 'nbformations') {
            $playlists = $this->playlistRepository->findAllOrderByNbFormations($ordre);
        } else {
            // Gestion si le champ ne correspond à aucun des cas précédents
            $playlists = $this->playlistRepository->findAll();
        }

        $categories = $this->categorieRepository->findAll();
        return $this->render('admin/admin.playlists.html.twig', [
            'playlists' => $playlists,
            'categories' => $categories
        ]);
    }

     /**
     * @Route("/admin/playlists/recherche/{champ}/{table}", name="admin.playlists.findallcontain")
     */
    public function findAllContain($champ, Request $request, $table=""): Response
    {
        $valeur = $request->get("recherche");
        if($table != ""){
            $playlists = $this->playlistRepository->findByContainValueTable($champ, $valeur, $table);
        }else{
            $playlists = $this->playlistRepository->findByContainValueTable($champ, $valeur);
        }
        $categories = $this->categorieRepository->findAll();
        return $this->render("admin/admin.playlists.html.twig", [
            'playlists' => $playlists,
            'categories' => $categories,            
            'valeur' => $valeur,
            'table' => $table
        ]);
    }
}
