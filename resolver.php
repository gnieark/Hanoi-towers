<?php

$discCount = 3;
//load the class
include("class.towers.php");

$tower = new Tower($discCount);
$steps = new Steps(array());
$steps->add_step($tower);

resolveHanoi($tower,$steps);

function resolveHanoi(Tower $tower, Steps $steps){
    $result = false;
    
    if($tower->is_won()){
      echo "\nSolution founded. Reverse these steps:\n".$tower;
      return true;
    }
    $availablesMoves = $tower->list_moves_availables();
    //take only the moves who will generate a new unknowed Tower
    
    foreach($availablesMoves as $move){
      $newTower = $tower->add_move($move);
      $newSteps = $steps;
 
      if($newSteps->add_step($newTower)){
        $r = resolveHanoi($newTower,$newSteps);
        if($r){
          $result = true;
          echo "\n".$tower;
        }
      }
    }
    return $result;
}
