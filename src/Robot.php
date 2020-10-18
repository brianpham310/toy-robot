<?php

class Robot
{
    const X_MAX = 4;
    const Y_MAX = 4;
    const VALID_DIRECTIONS = ['north', 'east', 'south', 'west'];

    protected $x = null;
    protected $y = null;
    protected $direction_pointer = -1;

    /**
     * Set X
     * @param $x
     */
    public function setX($x)
    {
        $this->x = $x;
    }

    /**
     * Set Y
     * @param $y
     */
    public function setY($y)
    {
        $this->y = $y;
    }

    /**
     * Set direction pointer
     * @param $pointer
     */
    public function setDirectionPointer($pointer)
    {
        $this->direction_pointer = $pointer;
    }

    /**
     * Get robot current direction
     * @return string
     */
    public function getDirection()
    {
        return self::VALID_DIRECTIONS[$this->direction_pointer];
    }

    /**
     * Check if robot is in valid state, which means it has valid coordinates and direction
     * @return bool
     */
    public function isStateValid()
    {
        return $this->isXValid($this->x) && $this->isYValid($this->y) && $this->direction_pointer != -1;
    }

    /**
     * Check if $x is valid
     * @param $x
     * @return bool
     */
    public function isXValid($x)
    {

        return ((filter_var($x, FILTER_VALIDATE_INT) === false || $x < 0 || $x > self::X_MAX) ? false : true);
    }

    /**
     * Check if $y is valid
     * @param $y
     * @return bool
     */
    public function isYValid($y)
    {

        return ((filter_var($y, FILTER_VALIDATE_INT) === false || $y < 0 || $y > self::Y_MAX) ? false : true);
    }

    /**
     * Check if direction is valid
     * @param $direction
     * @return bool
     */
    public function isDirectionValid($direction)
    {
        return in_array(strtolower($direction), self::VALID_DIRECTIONS);
    }

    /**
     * Move a step in the current direction
     * ignore if the move throw robot off the grid
     */
    public function move()
    {
        // calculate the new positions of robot if the move is processed
        $after_moved_x = $this->x;
        $after_moved_y = $this->y;
        $direction = self::VALID_DIRECTIONS[$this->direction_pointer];

        switch ($direction) {
            case 'north':
                $after_moved_y = $this->y + 1;
                break;
            case 'east':
                $after_moved_x = $this->x + 1;
                break;
            case 'south':
                $after_moved_y = $this->y - 1;
                break;
            case 'west':
                $after_moved_x = $this->x - 1;
                break;
            default:
                break;

        }
        // only update the x,y positions if the move doesn't cause robot being off the grid
        if ($this->isXValid($after_moved_x) && $this->isYValid($after_moved_y)) {
            $this->x = $after_moved_x;
            $this->y = $after_moved_y;
        }
    }

    /**
     * Move direction 90 deg to the left
     */
    public function turnLeft()
    {
        $this->direction_pointer = ($this->direction_pointer + count(self::VALID_DIRECTIONS) - 1) % count(self::VALID_DIRECTIONS);
    }

    /**
     * Move direction 90 deg to the right
     */
    public function turnRight()
    {
        $this->direction_pointer = ($this->direction_pointer + 1) % count(self::VALID_DIRECTIONS);
    }

    /**
     * Report current position and direction
     * @return bool
     */
    public function report()
    {
        return $this->x . "," . $this->y . "," . strtoupper(self::VALID_DIRECTIONS[$this->direction_pointer]);
    }

    /**
     * Execute command
     * @param $command
     */
    public function execute($command)
    {
        if (!$this->isStateValid()) {
            return;
        }
        // convert to lowercase
        $command = strtolower($command);
        switch ($command) {
            case 'move':
                $this->move();
                break;
            case 'left':
                $this->turnLeft();
                break;
            case 'right':
                $this->turnRight();
                break;
            case 'report':
                echo($this->report() . "\n");
                break;
            default:
                break;
        }
    }
}
