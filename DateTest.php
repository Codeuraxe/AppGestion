<?php

namespace App\Tests;

use App\Entity\Formation;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * 
 *
 * @author Dream
 */
class DateTest extends TestCase {
    
    public function testGetPublishedAtString(){
       $formation = new Formation();
       $formation->setPublishedAt(new DateTime("2021-01-04"));
       $this->assertEquals("04/01/2021", $formation->getPublishedAtString());
    }
}