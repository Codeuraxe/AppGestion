<?php

namespace App\Tests\Repository;

use App\Entity\Playlist;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test d'intégration pour le PlaylistRepository
 */
class PlaylistRepositoryTest extends KernelTestCase
{
    /**
     * Récupère le repository de Playlist
     */
    public function getRepository(): PlaylistRepository
    {
        self::bootKernel();
        return self::$container->get(PlaylistRepository::class);
    }

    /**
     * Teste le nombre total de playlists dans la base de données
     */
    public function testCountPlaylists(): void
    {
        $repository = $this->getRepository();
        $nbPlaylists = $repository->count([]);
        $this->assertEquals(27, $nbPlaylists);
    }

    /**
     * Crée une nouvelle instance de Playlist
     * @return Playlist
     */
    private function createPlaylist(): Playlist
    {
        return (new Playlist())
            ->setName("Test Playlist")
            ->setDescription("Description");
    }

    /**
     * Teste l'ajout d'une playlist
     */
    public function testAddPlaylist(): void
    {
        $repository = $this->getRepository();
        $playlist = $this->createPlaylist();
        $nbPlaylistsBefore = $repository->count([]);
        $repository->add($playlist, true);
        $nbPlaylistsAfter = $repository->count([]);
        $this->assertEquals($nbPlaylistsBefore + 1, $nbPlaylistsAfter, "Erreur lors de l'ajout de playlist");
    }

    /**
     * Teste la suppression d'une playlist
     */
    public function testRemovePlaylist(): void
    {
        $repository = $this->getRepository();
        $playlist = $this->createPlaylist();
        $repository->add($playlist, true);
        $nbPlaylistsBefore = $repository->count([]);
        $repository->remove($playlist, true);
        $nbPlaylistsAfter = $repository->count([]);
        $this->assertEquals($nbPlaylistsBefore - 1, $nbPlaylistsAfter, "Erreur lors de la suppression de playlist");
    }

    /**
     * Teste le tri des playlists par nom dans l'ordre spécifié
     */
    public function testFindAllOrderByName(): void
    {
        $repository = $this->getRepository();
        $playlist = $this->createPlaylist();
        $repository->add($playlist, true);
        $playlists = $repository->findAllOrderByName("ASC");
        $this->assertCount(28, $playlists);
        $this->assertEquals("Bases de la programmation (C#)", $playlists[0]->getName());
    }

    /**
     * Teste le tri des playlists par nombre de formations dans l'ordre spécifié
     */
    public function testFindAllOrderByNbFormations(): void
    {
        $repository = $this->getRepository();
        $playlist = $this->createPlaylist();
        $repository->add($playlist, true);
        $playlists = $repository->findAllOrderByNbFormations("ASC");
        $this->assertCount(28, $playlists);
        $this->assertEquals("Test Playlist", $playlists[0]->getName());
    }

    /**
     * Teste la recherche de playlists contenant une valeur spécifique dans un champ spécifique
     */
    public function testFindByContainValue(): void
    {
        $repository = $this->getRepository();
        $playlist = $this->createPlaylist();
        $repository->add($playlist, true);
        $playlists = $repository->findByContainValue("name", "Java");
        $this->assertCount(2, $playlists);
        $this->assertEquals("Eclipse et Java - Test Ajout", $playlists[0]->getName());
    }

    /**
     * Teste la recherche de playlists contenant une valeur spécifique dans un champ spécifique d'une autre table
     */
    public function testFindByContainValueTable(): void
    {
        $repository = $this->getRepository();
        $playlist = $this->createPlaylist();
        $repository->add($playlist, true);
        $playlists = $repository->findByContainValueTable("name", "Java", "categorie");
        $this->assertCount(3, $playlists);
        $this->assertEquals("Eclipse et Java - Test Ajout", $playlists[0]->getName());
    }
}