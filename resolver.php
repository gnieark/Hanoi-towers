<?php
/*
* Hanoi towers ' resolver
* Copyright (C) 2017 Gnieark https://blog-du-grouik.tinad.fr/
* licensed under the terms of the GNU General Public V3. See License file.
*/

$discCount = 6;
//load the class
include("inc.php");

$tower = new Tower($discCount);
$steps = new Steps(array());
$steps->add_step($tower);

resolveHanoi($tower,$steps);

function resolveHanoi(Tower $tower, Steps $steps){
    $result = false;
    
    if($tower->is_won()){
      echo "a winning suite was found:\n";
      foreach($steps->steps as $oneTower){
        echo $oneTower."\n";
      }
      return true;
    }
    $availablesMoves = $tower->list_moves_availables();
    
    foreach($availablesMoves as $move){
      $newTower = $tower->add_move($move);
      $newSteps = $steps;
 
      if($newSteps->add_step($newTower)){
        $r = resolveHanoi($newTower,$newSteps);
        if($r){
          $result = true;
        }
      }
    }
    return $result;
}