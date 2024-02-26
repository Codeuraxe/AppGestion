<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class FormationControllerTest extends WebTestCase
{
    private const FORMATIONSPATH = '/formations';
    
    /**
     * Teste l'accès à la page des formations
     */
    public function testAccesPageFormations()
    {
        $client = static::createClient();
        $client->request('GET', self::FORMATIONSPATH);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    
    /**
     * Teste le tri ascendant selon le nom des playlists
     */
    public function testTriAscendantPlaylists()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/tri/name/ASC/playlist');
        $this->assertSelectorTextContains('th', 'formation');
        $this->assertCount(5, $crawler->filter('th'));
        $this->assertSelectorTextContains('h5', 'Bases de la programmation n°74 - POO : collections');
    }
    
    /**
     * Teste le tri ascendant selon le titre des formations
     */
    public function testTriAscendantFormations()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/tri/title/ASC');
        $this->assertSelectorTextContains('th', 'formation');
        $this->assertCount(5, $crawler->filter('th'));
        $this->assertSelectorTextContains('h5', 'Android Studio (complément n°1) : Navigation Drawer et Fragment');
    }
    
    /**
     * Teste le tri ascendant selon la date de publication
     */
    public function testTriAscendantDate()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', 'formations/tri/publishedAt/ASC');
        $this->assertSelectorTextContains('th', 'formation');
        $this->assertCount(5, $crawler->filter('th'));
        $this->assertSelectorTextContains('h5', 'Cours UML (1 à 7 / 33) : introduction');
    }
    
    /**
     * Teste le filtrage des formations selon la valeur recherchée
     */
    public function testFiltreFormations()
    {
        $client = static::createClient();
        $client->request('GET', '/formations'); 
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'UML'
        ]);
        $this->assertCount(10, $crawler->filter('h5'));
        $this->assertSelectorTextContains('h5', 'UML');
    }
    
    /**
     * Teste le filtrage des playlists selon la valeur recherchée
     */
    public function testFiltrePlaylists()
    {
        $client = static::createClient();
        $client->request('GET', '/formations/recherche/name/playlist'); 
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'eclipse'
        ]);
        $this->assertCount(9, $crawler->filter('h5'));
        $this->assertSelectorTextContains('h5', 'Eclipse');
    }
    
    /**
     * Teste le filtrage des catégories selon la valeur recherchée
     */
    public function testFiltreCategories()
    {
        $client = static::createClient();
        $client->request('GET', '/formations/recherche/id/categories'); 
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'java'
        ]);
        $this->assertCount(7, $crawler->filter('h5'));
        $this->assertSelectorTextContains('h5', 'TP Android n°5 : code du controleur et JavaDoc');
    }
    
    /**
     * Teste le lien qui redirige l'utilisateur vers la page de détail de la formation
     */
    public function testLienDetailFormation()
    {
        $client = static::createClient();
        $client->request('GET', '/formations');
        $client->clickLink("image formation");
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/formations/formation/1', $uri);
    }
}