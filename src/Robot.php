<?php

/**
 * This class represents a robot on a virtual square table top of size BOARD_SIZE.
 * The robot has an X and Y position and a direction that it is facing.
 *
 * You can use the functions to set the place and direction of the robot,
 * and to get it to move.
 *
 * The robot will not respond to commands until it has been explicitly placed,
 * and will ignore move commands that would send it off the edge of the board.
 */
class Robot {
  private const DIRECTIONS = ['NORTH', 'EAST', 'SOUTH', 'WEST'];
  private const BOARD_SIZE = 5;

  private $x = 0;
  private $y = 0;
  private $direction = 0;
  private $placed = false;

  /**
   * Set the position of the robot and direction it is facing.
   *
   * @param int $x
   * @param int $y
   * @param string $facing - one of NORTH, EAST, SOUTH, WEST
   * @return mixed: boolean true, or message string
   */
  public function place($x, $y, string $facing) {
    $messages = '';
    if (!is_numeric($x) || (int)$x != $x || $x < 0 || $x >= Robot::BOARD_SIZE) {
      $messages .= "The X location must be an integer between 0 and " . (Robot::BOARD_SIZE-1) . ".\n";
    }
    if (!is_numeric($y) || (int)$y != $y || $y < 0 || $y >= Robot::BOARD_SIZE) {
      $messages .= "The Y location must be an integer between 0 and " . (Robot::BOARD_SIZE-1) . ".\n";
    }
    $direction = array_search(strtoupper($facing), Robot::DIRECTIONS);
    if ($direction === false) {
      $messages .= "The direction must be one of: NORTH, EAST, SOUTH, WEST.\n";
    }
    if (strlen($messages)) {
      return $messages;
    }

    $this->x = intval($x);
    $this->y = intval($y);
    $this->direction = $direction;
    $this->placed = true;
    return true;
  }

  /**
   * Move the robot one place in the direction it is facing, if it is not
   * already at the edge of the board.
   *
   * @return boolean
   */
  public function move() {
    if (!$this->placed) {
      return false;
    }
    switch ($this->direction) {
      case 0:
        if ($this->y < Robot::BOARD_SIZE-1) {
          $this->y++;
        }
        break;
      case 1:
        if ($this->x < Robot::BOARD_SIZE-1) {
          $this->x++;
        }
        break;
      case 2:
        if ($this->y > 0) {
          $this->y--;
        }
        break;
      case 3:
        if ($this->x > 0) {
          $this->x--;
        }
        break;
      default:
        throw new Exception("Direction $this->direction is not a valid direction.");
    }
    return true;
  }

  /**
   * Turn the robot to the left
   *
   * @return boolean
   */
  public function left() {
    if (!$this->placed) {
      return false;
    }
    if ($this->direction == 0) {
      $this->direction = 3;
    } else {
      $this->direction--;
    }
    return true;
  }

  /**
   * Turn the robot to the right
   *
   * @return boolean
   */
  public function right() {
    if (!$this->placed) {
      return false;
    }
    $this->direction = ++$this->direction % 4;
    return true;
  }

  /**
   * Return a string representing the position of the robot on the table top.
   *
   * @return mixed: string, or boolean false if not placed on the table top
   */
  public function report() {
    if (!$this->placed) {
      return false;
    }
    return "I am at $this->x, $this->y, facing " . Robot::DIRECTIONS[$this->direction];
  }
}