<?php

namespace App\Tests\Entity;

use App\Entity\Serie;
use PHPUnit\Framework\TestCase;

class SerieTest extends TestCase
{
    public function testSetterName(): void
    {
        $serie = new Serie();
        $serie->setName("Test");

        $this->assertEquals("Test", $serie->getName(), "Setter Name not working !");
    }
}
