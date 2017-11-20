<?php

class Tower{
  private $tower0;
  private $tower1;
  private $tower2;
  public $discsCount;
  
  /* on the hannoi tower
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
  to rewrite with move object
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
  */
  private function get_tower_array(){
    return array(
      $this->tower0,
      $this->tower1,
      $this->tower2
    );
  }
  private function check_if_move_is_available(Move $move){
    $fromTower = "tower".$move->from;
    $toTower = "tower".(string)$move->to;
    echo "kk$toTower\n".$move."|";
    print_r($this->{$toTower});
    //echo end($this->$toTower)."|". end($this->$fromTower);
    
    if(($move!==false) || (empty($this->$fromTower)) || (end($this->$toTower) < end($this->$fromTower))){
      return false;
    }
    return true;
  }
  
  public function add_move(Move $move){
    if($this->check_if_move_is_available($move)){
        $towerArr = $this->get_tower_array();
        $towerArr[$move->to][] = end($towerArr[$move->from]);
        array_pop($towerArr[$move->from]);
        return new Tower( $this->discsCount, $towerArr );
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
    
    public function __construst(){
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
  public static function make($str){
        $move = new Move();
        switch((string)$str){
          case "0 to 1":
            $move->set_value(Move::$from0to1);
            break;
          case "0 to 2":
            $move->set_value(Move::$from0to2);
            break;
          case "1 to 0":
            $move->set_value(Move::$from1to0);
            break;
          case "1 to 2":
            $move->set_value(Move::$from1to2);
            break;
          case "2 to 0":
            $move->set_value(Move::$from2to0);
            break;
          case "2 to 1":
            $move->set_value(Move::$from2to1);
            break;
          default:
            return false;
            break;
        }
        return $move;
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
  
  public function add_step(Tower $tower){
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
