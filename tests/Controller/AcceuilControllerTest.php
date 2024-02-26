<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;



/**
 * Test de l'accès à la page d'accueil
 * Test Fonctionnel 
 * @author Dream
 */
class AccueilControllerTest extends WebTestCase {
    
   public function testAccesPage(){
       $client = static::createClient();
       $client->request('GET', '/');
       $this->assertResponseStatusCodeSame(Response::HTTP_OK);
   }
}