<?php

namespace App\Tests\Repository;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FormationRepositoryTest extends KernelTestCase {
  
    // Méthode pour récupérer le repository de Formation
    public function recupRepository(): FormationRepository{
        self::bootKernel(); 
        $repository = self::getContainer()->get(FormationRepository::class); 
        return $repository;
    }
    
    // Teste le nombre total de formations 
    public function testNbFormations(){
        $repository = $this->recupRepository();
        $nbFormations = $repository->count([]); 
        $this->assertEquals(237, $nbFormations); 
    }
    
    // Crée une nouvelle instance de Formation
    public function newFormation(): Formation{
        $formation = (new Formation())
                ->setTitle("formation")
                ->setDescription("description")
                ->setPublishedAt(new DateTime("2024/02/09"));
        return $formation;
    }   
    
    // Teste l'ajout d'une nouvelle formation 
    public function testAddFormation(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $nbFormations = $repository->count([]); 
        $repository->add($formation, true); 
        $this->assertEquals($nbFormations + 1, $repository->count([]), "erreur lors de l'ajout"); // Vérifie si le nombre de formations a augmenté de 1
    }
     
    // Teste la suppression d'une formation de la base de données
    public function testRemoveFormation(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation, true); 
        $nbFormations = $repository->count([]); 
        $repository->remove($formation, true); 
        $this->assertEquals($nbFormations - 1, $repository->count([]), "erreur lors de la suppression"); 
    }
    
    // Teste la méthode findAllOrderBy
    public function testFindAllOrderBy(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation, true); 
        $formations = $repository->findAllOrderBy("title", "ASC"); 
        $nbFormations = count($formations); 
        $this->assertEquals(238, $nbFormations); 
        $this->assertEquals("Android Studio (complément n°1) : Navigation Drawer et Fragment", $formations[0]->getTitle()); 
    }
    
    // Teste la méthode findAllOrderByTable
    public function testFindAllOrderByTable(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation, true); 
        $formations = $repository->findAllOrderByTable("name", "ASC", "playlist"); 
        $nbFormations = count($formations); 
        $this->assertEquals(237, $nbFormations); 
        $this->assertEquals("Bases de la programmation n°74 - POO : collections", $formations[0]->getTitle()); 
    }
    
    // Teste la méthode findByContainValue
    public function testFindByContainValue(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation, true);

        // Recherche les formations qui contiennent "C#" dans leur titre
        $formations = $repository->findByContainValue("title", "C#");

        // Vérifie le nombre de formations trouvées
        $this->assertCount(11, $formations);

        // Vérifie le titre de la première formation trouvée
        $this->assertEquals("C# : ListBox en couleur", $formations[0]->getTitle());
    }
    
    // Teste la méthode findByContainValueTable
    public function testFindByContainValueTable(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation, true);
        $formations = $repository->findByContainValueTable("name", "MCD exercices d'examen (sujets EDC BTS SIO)", "playlist");
        $nbFormations = count($formations);
        $this->assertEquals(8, $nbFormations);
        $this->assertEquals("Exercice MCD (correction MCD sujet EDC cas aeroplan 2014 BTS SIO)", $formations[0]->getTitle());
    }

    // Teste le tri des formations selon la date la plus récente de publication
    public function testFindAllLasted()
    {
        $repository = $this->recupRepository();
        $formation = (new Formation())->setPublishedAt(new DateTime("2023-01-16 13:33:39"));
        $repository->add($formation, true);
        $formations = $repository->findAllLasted(1);
        $this->assertCount(1, $formations);
        $this->assertEquals(new DateTime("2023-01-16 13:33:39"), $formations[0]->getPublishedAt());
    }
    
    // Teste si la fonction récupère les formations d'une playlist selon son id
    // Et réalise le tri ascendant
    public function testFindAllForOnePlaylist()
    {
        // Récupération du repository
        $repository = $this->recupRepository();
        
        // Création d'une nouvelle formation
        $formation = $this->newFormation();
        $repository->add($formation, true);
        
        // Récupération des formations pour une playlist spécifique (id = 1)
        $formations = $repository->findAllForOnePlaylist(1);
        
        // Vérification du nombre de formations récupérées
        $nbFormations = count($formations);
        $this->assertEquals(8, $nbFormations);
        
        // Vérification du titre de la première formation
        $this->assertEquals("Eclipse n°1 : installation de l'IDE", $formations[0]->getTitle());
    }
}