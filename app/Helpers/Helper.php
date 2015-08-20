<?php namespace App\Helpers;

use Illuminate\Support\Facades\Facade;

class Helper extends Facade {

  protected static function getFacadeAccessor() { return 'helper'; }

  // user_response, answer
  public static function deepCompare($objectA, $objectB) {
    // check member length
    if (count($objectA) != count($objectB)) {
      return false;
    }

    // check member
    for ($i = 0; $i < count($objectA); $i++) {
      $a = $objectA[$i];
      $b = $objectB[$i];

      if (count($a->members) != count($b->members)) {
        return false;
      } else {
        for ($j = 0; $j < count($b->members); $j++) {
          $bm = $b->members[$j];
          if ( !in_array($bm, $a->members) ) {
            return false;
          }
        }
      }
    }

    return true;
  }

}
