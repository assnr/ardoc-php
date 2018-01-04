<?php
namespace MyGreatNS\Elsewhere;

/**
* A description
* @author Yves ASTIER <contact@yves-astier.com>
* @version 1.0
*
* @newUsage(keyParameter="text value", 150, otherKey=true, otherKeyAgain=false)
* @NS\newUsage(keyParameter="text value", 150, otherKey=true, otherKeyAgain=false)
*/
class MyClass{
    /**
    * @param int $param A parameter description
    */
  public function getSomething(int $param = 20){ /*...*/ }
}
