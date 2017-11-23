<?php

class Tower{
  /*
  * The tower as an object
  */
  private $tower0;
  private $tower1;
  private $tower2;
  public $discsCount;
  
  /*
  * INPUT $discsCount: integer number of discs on the tower
  * INPUT facultative $towerArr an array
  */
  public function __construct($discsCount,$towerArr = array()){
    $this->discsCount = $discsCount;
    if(empty($towerArr)){

        //starting position for the tower
        $this->tower0 = array();
        for ( $i = $this->discsCount - 1 ;$i > -1 ; $i-- ){
        $this->tower0[] = $i;
        }
        $this->tower1 = array();
        $this->tower2 = array();
    }else{    
        $this->tower0 = $towerArr[0];
        $this->tower1 = $towerArr[1];
        $this->tower2 = $towerArr[2];
    }
  }
  
  public function __toString(){
      return json_encode($this->get_tower_array());
  }


  /*
  * Return the list of moves available with the actual tower configuration
  */
  public function list_moves_availables(){
    $movesAvailables = array();
    for( $i = 0; $i < 3; $i++ ){
      for( $j = 0; $j < 3; $j++ ){
        $move = Move::make($i,$j);
        if(($move !== false) && ($this->check_if_move_is_available($move))){
          $movesAvailables[] = $move;
        }
      }
    }
    return $movesAvailables;
  }
  
  /*
  * Apply to the current tower the change defined
  * by tlh move object
  */
  public function add_move(Move $move){
    if($this->check_if_move_is_available($move)){
        $towerArr = $this->get_tower_array();
        $towerArr[$move->to][] = end($towerArr[$move->from]);
        array_pop($towerArr[$move->from]);
        return new Tower( $this->discsCount, $towerArr );
    }
    return false;
  }
  
  /*
  * Check if is a winning configuration
  */
  public function is_won(){
    $arr = $this->get_tower_array();
    if ((empty($arr[0]) && empty($arr[1]))
        ||(empty($arr[0]) && empty($arr[2]))){
          return true;
    }
    return false;
  }
  
  public function get_tower_array(){
    return array(
      $this->tower0,
      $this->tower1,
      $this->tower2
    );
  }
  
  private function check_if_move_is_available(Move $move){
    if($move === false){
      return false;
    }
    $fromTower = "tower".$move->from;
    $toTower = "tower".$move->to;
    if( (!empty($this->{$fromTower}))
        &&(   (end($this->{$toTower}) > end($this->{$fromTower}))
              ||(empty ($this->{$toTower}))
          )
    ){
        return true;
    }
    return false;
  }
  

  
}
class Move{

    private static $from0to1 = 0;
    private static $from0to2 = 1;
    private static $from1to0 = 2;
    private static $from1to2 = 3;
    private static $from2to0 = 4;
    private static $from2to1 = 5;
    
    public $from;
    public $to;
    
    private $value;
    
    public function __construct(){
        $this->value = 0;
    }
    
  private function  set_value($value){
    $this->value = $value;
    switch ($value){
      case Move::$from0to1:
        $this->from = 0;
        $this->to = 1;
        break;
      case Move::$from0to2:
        $this->from = 0;
        $this->to = 2;
        break;
      case Move::$from1to0:
        $this->from = 1;
        $this->to = 0;
        break;
      case Move::$from1to2:
        $this->from = 1;
        $this->to = 2;
        break;
      case Move::$from2to0:
        $this->from = 2;
        $this->to = 0;
        break;
      case Move::$from2to1:
        $this->from = 2;
        $this->to = 1;
        break;
      default:
        return false;
        break;
    }
  }
  public function __toString(){
    switch($this->value){
      case Move::$from0to1:
        return "from col 0 to 1";
        break;
      case Move::$from0to2:
        return "from col 0 to 2";
        break;
      case Move::$from1to0:
        return "from col 1 to 0";
        break;
      case Move::$from1to2:
        return "from col 1 to 2";
        break;
      case Move::$from2to0:
        return "from col 2 to 0";
        break;
      case Move::$from2to1:
        return "from col 2 to 1";
        break;
      default:
        return false;
        break;
    }
  }
  public static function make($from,$to){
    $move = new Move();
    if(($from == 0) && ($to == 1))
      $move->set_value(Move::$from0to1);
    elseif(($from == 0) && ($to == 2))
      $move->set_value(Move::$from0to2);
    elseif(($from == 1) && ($to == 0))
      $move->set_value(Move::$from1to0);
    elseif(($from == 1) && ($to == 2))
      $move->set_value(Move::$from1to2);
    elseif(($from == 2) && ($to == 0))
      $move->set_value(Move::$from2to1);
    elseif(($from == 2) && ($to ==1))
      $move->set_value(Move::$from2to1);
    else
      return false;
    
    return $move;
  }
}
class Steps{
  /*
  *Memorise the differents towers configurations
  */
  public $steps;
  public function __construct(){
    $this->steps = array();
  }
  public function add_step(Tower $tower){
    if(in_array($tower,$this->steps)){
      return false;      
    }else{
      $this->steps[] = $tower; 
      return true;
    }
  }
}
