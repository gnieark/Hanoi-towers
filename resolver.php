<?php

$discCount = 6;
//load the class
include("class.towers.php");


$tower = new Tower($discCount);
echo "1".$tower."\n";
$move = new Move();
$move->make("0 to 1");
$tower = $tower->add_move($move);
echo "2".$tower."\n";
/*
resolveHanoi($tower);

function resolveHanoi($tower){
    
    //out of recursif if
    $availablesMoves = $tower->list_moves_availables();
    
    //don't take moves that will generate an ever used tower configuration
    $useful_moves = array();
    foreach($availablesMoves as $move){
        
    }


}
*/
