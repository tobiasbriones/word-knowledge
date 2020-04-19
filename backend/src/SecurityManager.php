<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

class SecurityManager {
  
  public static function changeDecBase($number, $newBase) {
    $residues = array();
    $quotient = $number;
    $result = "";
    
    while ($quotient >= $newBase) {
      $result .= "Div $quotient / $newBase<br>";
      $residues[] = $quotient % $newBase;
      $result .= "res " . $quotient % $newBase . "<br>";
      $quotient = floor($quotient / $newBase);
    }
    $residues[] = $quotient;
    $length = count($residues) - 1;
    
    for ($i = $length; $i >= 0; $i--) {
      $result .= $residues[$i];
    }
    return $result;
  }
  
}
