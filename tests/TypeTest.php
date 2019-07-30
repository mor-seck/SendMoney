<?php

namespace App\test;

use App\Entity\Type;
use PHPUnit\Framework\TestCase;

class TypeTest extends TestCase{
  public function testFind(){
    $type=new Type('admin');
    $resultat=$type->TypeTest();

    $this->assertSame("admin",$resultat);
  
  }

}