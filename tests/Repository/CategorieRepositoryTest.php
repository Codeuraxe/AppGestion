<?php

namespace App\Tests\Repository;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test d'intégration pour le CategorieRepository
 */
class CategorieRepositoryTest extends KernelTestCase
{
    /**
     * Récupère le repository de Catégorie
     */
    private function getRepository(): CategorieRepository
    {
        self::bootKernel();
        return self::$container->get(CategorieRepository::class);
    }

    /**
     * Teste le nombre de catégories dans la base de données
     */
    public function testCountCategories(): void
    {
        $repository = $this->getRepository();
        $nbCategories = $repository->count([]);
        $this->assertEquals(9, $nbCategories);
    }

    /**
     * Crée une nouvelle instance de Catégorie
     */
    private function createCategory(): Categorie
    {
        return (new Categorie())->setName("Test Catégorie");
    }

    /**
     * Teste l'ajout d'une catégorie
     */
    public function testAddCategory(): void
    {
        $repository = $this->getRepository();
        $nbCategoriesBefore = $repository->count([]);
        
        // Création d'une nouvelle catégorie
        $category = $this->createCategory();
        $repository->add($category, true);
        
        // Vérification si le nombre de catégories a augmenté de 1
        $nbCategoriesAfter = $repository->count([]);
        $this->assertEquals($nbCategoriesBefore + 1, $nbCategoriesAfter, "Erreur lors de l'ajout de catégorie");
    }

    /**
     * Teste la suppression d'une catégorie
     */
    public function testRemoveCategory(): void
    {
        $repository = $this->getRepository();
        $category = $this->createCategory();
        $repository->add($category, true);
        $nbCategoriesBefore = $repository->count([]);
        
        // Suppression de la catégorie ajoutée
        $repository->remove($category, true);
        
        // Vérification si le nombre de catégories a diminué de 1
        $nbCategoriesAfter = $repository->count([]);
        $this->assertEquals($nbCategoriesBefore - 1, $nbCategoriesAfter, "Erreur lors de la suppression de catégorie");
    }

    /**
     * Teste la méthode de tri des catégories
     */
    public function testFindAllOrderBy(): void
    {
        $repository = $this->getRepository();
        $category = $this->createCategory();
        $repository->add($category, true);
        
        // Récupération de toutes les catégories triées par nom
        $categories = $repository->findAllOrderBy("name", "ASC");
        $this->assertCount(10, $categories);
        $this->assertEquals("Android", $categories[0]->getName());
    }

    /**
     * Teste la méthode findAllForOnePlaylist
     */
    public function testFindAllForOnePlaylist(): void
    {
        $repository = $this->getRepository();
        $idPlaylist = 1; // ID de la playlist
        
        // Récupération de toutes les catégories pour une playlist spécifique
        $categories = $repository->findAllForOnePlaylist($idPlaylist);
        
        // Vérification si la liste des catégories n'est pas vide et si chaque élément est bien une instance de Categorie
        $this->assertNotEmpty($categories);
        foreach ($categories as $category) {
            $this->assertInstanceOf(Categorie::class, $category);
        }
    }
}