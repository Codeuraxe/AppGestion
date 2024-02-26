<?php
namespace App\Tests;

use App\Entity\Formation;
use App\Entity\Environnement;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * Description of DateTest
 *
 * @author Dream
 */
class DateTest extends TestCase {
    
    public function testGetPublishedAtString(){
        $formation = new Formation();
        $formation->setPublishedAt(new DateTime("2024-02-04"));
        $this->assertEquals("04/02/2024", $formation->getPublishedAtString());
    }
}