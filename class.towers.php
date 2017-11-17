<?php

class Towers{
  private $tower0;
  private $tower1;
  private $tower2;
  public $discsCount;
  
  /* on the hannoi tower
  */
  public function __construct($discsCount,$towerArr){
    $this->discsCount = $discsCount;
  
    //starting position for the tower
    $this->tower0 = array();
    for ( $i = $this->discsCount - 1 ;$i > -1 ; $i++ ){
      $this->tower0[] = $i;
    }
    $this->tower1 = array();
    $this->tower2 = array();
  }
  
  
  public function move_disc($from,$to){
    //checks for the hanois rules
    if(
      ($from == $to)
      ||(!in_array($from,array(0,1,2)))
      ||(!in_array($to,array(0,1,2)))
      ){
      return false;
    }
    $fromTower = "tower".$from;
    $toTower = "tower".$to;
    
    //the disc must be putted on a bigger one
    if((empty($this->$fromTower)) || (end($this->$toTower) < end($this->$fromTower))){
      return false;
    }
    
    //move the disc:
    $this->$toTower[] = end($this->$fromTower);
    array_pop($this->$fromTower);
    
    return true;
  }
  
  private function check_if_move_is_available($from,$to){
    $fromTower = "tower".$from;
    $toTower = "tower".$to;
    if(($from == $to) || (empty($this->$fromTower)) || (end($this->$toTower) < end($this->$fromTower))){
      return false;
    }
    return true;
  }
  
  public function __toString(){
      return json_encode($this->get_tower_array();
  }

  
  public function list_moves_availables(){
    $moves = array(
      array('from'  => 0, 'to'  => 1),
      array('from'  => 0, 'to'  => 2),
      array('from'  => 1, 'to'  => 0),
      array('from'  => 1, 'to'  => 2),
      array('from'  => 2, 'to'  => 0),
      array('from'  => 2, 'to'  => 1)
    );
    $movesAvailables = array();
    
    foreach($moves as $move){
      if ($this->check_if_move_is_available($move['from'],$move['to'])){
        $movesAvailables[] = $move;
      }
    }
    return $movesAvailables;
  }
  
  public function get_tower_array(){
    return array(
      $this->tower0,
      $this->tower1,
      $this->tower2
    );
  }
  
  public function add_move(Move $move){
  
  }
  
}
class Move{

    private static $from0to1 = 0;
    private static $from0to2 = 1;
    private static $from1to0 = 2;
    private static $from1to2 = 3;
    private static $from2to0 = 4;
    private static $from2to1 = 5;
    
    private $from;
    private $to;
    
    private $value;
    
    public function __construst(){
        $this->value = 0;
    }
    
    private function  set_value($value){
        $this->value = $value();
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
}

class Steps{
  /*
  *Memorise the differents towers configurations
  */
  private $steps;
  public function __construct($steps){
    $this->steps = array();
  }
  
  public function add_step(Towers $tower){
    //3 tours contenant au max n valeurs de 0à n-1*
    //a way to convert the tower to a simple integer (long)
    $arr = $tower->get_tower_array();
    $tower0 = int_val(base_convert(implode("",$arr[0]),$tower->discsCount,10));
    $tower1 = int_val(base_convert(implode("",$arr[1]),$tower->discsCount,10));
    $tower2 = int_val(base_convert(implode("",$arr[2]),$tower->discsCount,10));
    
    $towerValue = $tower0 * pow( 10, 2 * $tower->count) +  $tower1 * pow( 10,  $tower->count) + $tower2;
    if(in_array($towerValue,$this->steps)){
      return false;
    }else{
      $this->steps[] = $towerValue; 
    }
  }
}
