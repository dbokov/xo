<?php

// kinda business logic layer

namespace dbokov\xo\components;

use yii\base\Exception;
use yii\web\Session;

class Game
{

    private static $instance;

    // game matrix
    private $field = [];
    private $field_size;

    // line to win
    private $danger_cell;

    private function __construct() {}
    private function __clone() {}

    public static function getInstance()
    {

        if(!is_object(self::$instance))
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function setFieldSize($size)
    {
        $this->field_size = $size;
    }

    private function getGameState()
    {
        $session = \Yii::$app->session;
        $this->field = $session->get('game');
    }

    private function saveGameState()
    {
        $session = \Yii::$app->session;
        $session->set('game',$this->field);
    }

    public function start()
    {

        for($x=0;$x<$this->field_size;$x++)
        {
            for($y=0;$y<$this->field_size;$y++)
            {
                $this->field[$x][$y] = 0;
            }
        }

        $this->saveGameState();

    }

    private function findDiagonal($x,$y,$player)
    {

        // мы знаем первую точку, надо проверить на следующем ряду = y+1, x-1, $x+1

        if(isset($this->field[$x+1][$y+1]) && $this->field[$x+1][$y+1] === $player) return [$x+1,$y+1];
        if(isset($this->field[$x+1][$y-1]) && $this->field[$x+1][$y-1] === $player) return [$x+1,$y-1];
        return false;
    }

    private function checkWin($player)
    {

        //  horizontal

        $found = false;

        for($x=0;$x<$this->field_size;$x++)
        {
            for($y=0;$y<$this->field_size;$y++)
            {
                // первая ступенька
                if($this->field[$x][$y] === $player && !$found)
                {
                    $found = true;
                    $cells_count = 1;

                    if(isset($this->field[$x][$y+1]) && $this->field[$x][$y+1] === $player)
                    {
                        $cells_count++;
                        $this->danger_cell = [$x,$y+2];

                        // вторая ступенька
                        if(isset($this->field[$x][$y+2]) && $this->field[$x][$y+2] === $player)
                        {
                            $cells_count++;
                        }
                    }    else $found = false;
                }

            }
        }

        if(!isset($cells_count)) return false;
        if($cells_count == 3) return true;


        //  vertical

        $found = false;

        for($x=0;$x<$this->field_size;$x++)
        {
            for($y=0;$y<$this->field_size;$y++)
            {
                // первая ступенька
                if($this->field[$x][$y] === $player && !$found)
                {
                    $found = true;
                    $cells_count = 1;

                    if(isset($this->field[$x+1][$y]) && $this->field[$x+1][$y] === $player)
                    {
                        $cells_count++;
                        $this->danger_cell = [$x+2,$y];

                        // вторая ступенька
                        if(isset($this->field[$x+2][$y]) && $this->field[$x+2][$y] === $player)
                        {
                            $cells_count++;
                        }
                    }    else $found = false;
                }

            }
        }

        if(!isset($cells_count)) return false;
        if($cells_count == 3) return true;


        //   diagonal
        $found = false;
        for($x=0;$x<$this->field_size;$x++)
        {
            for($y=0;$y<$this->field_size;$y++)
            {
                // первая ступенька
                if($this->field[$x][$y] === $player && !$found) {
                    $found = true;
                    $cells_count = 1;
                    // еще одна
                    if($cell_data = $this->findDiagonal($x,$y,$player)) {
                        $cells_count++;
                        $this->danger_cells = $cell_data;

                        if($this->findDiagonal($cell_data[0],$cell_data[1],$player)) {
                            $cells_count++;
                        }
                    }
                    else $found = false;
                }
            }
        }


        if(!isset($cells_count)) return false;
        if($cells_count == 3) return true;

    }

    public function doAiTurn()
    {
        $this->getGameState();
        $this->setFieldSize(sizeof($this->field));

        // oh, it's hot!
        if(is_array($this->danger_cell) && ($this->danger_cell[0] < $this->field_size && $this->danger_cell[1] < $this->field_size))
        {
            $x = $this->danger_cell[0];
            $y = $this->danger_cell[1];
        }
        else
        {
            do {
                $x = rand(0,$this->field_size-1);
                $y = rand(0,$this->field_size-1);
            } while ($this->field[$x][$y]);
        }

        return $this->turn($x,$y,'o');
    }

    public function turn($x,$y,$player)
    {

        // refresh field from session
        $this->getGameState();

        $this->setFieldSize(sizeof($this->field));

        // cell is not empty
        if($this->field[$x][$y]) return 'filled';

        // fill the cell
        $this->field[$x][$y] = $player;

        // save new status
        $this->saveGameState();

        // game finished
        if($this->checkWin($player)) return 'win';

        return ['x'=>$x,'y'=>$y];

    }


}