<?php

namespace App\Tests\Validations;

use App\Entity\Formation;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DateValidationsTest extends KernelTestCase
{
    public function getFormation(): Formation
    {
        return (new Formation())
            ->setTitle('Nouvelle formation')
            ->setPublishedAt(new DateTime('2030-01-18'));
    }

    
    public function testValidationDateFormation()
    {
        $formation = $this->getFormation()->setPublishedAt(new DateTime('2030-01-18'));

        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $errors = $validator->validate($formation, null, ['Date']);

        $this->assertCount(1, $errors, 'La date "2030-01-18" devrait générer une erreur de validation.');
        $this->assertEquals('La date ne peut pas être postérieure à aujourd\'hui', $errors[0]->getMessage());
    }
}