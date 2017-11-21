<?php

$discCount = 6;
//load the class
include("class.towers.php");


$tower = new Tower($discCount);
$steps = new Steps();
/*
echo "1".$tower."\n";
$move = Move::make(0,2);
$tower = $tower->add_move($move);
echo "2".$tower."\n";
print_r($tower->list_moves_availables());
*/

resolveHanoi($tower);

function resolveHanoi(Tower $tower, Steps $steps){

    $steps->add_step($tower);
    $availablesMoves = $tower->list_moves_availables();
    
    //take only the moves who will generate a new unknowed Tower
    $uniquesAvailableMoves = array(); 
    foreach($availablesMoves as $move){
      $newTower = $tower-> add_move($move);
      //to do check if unique ************************************************
    }
    
    
    
    //don't take moves that will generate an ever used tower configuration
    $useful_moves = array();
    foreach($availablesMoves as $move){
        
    }


}
