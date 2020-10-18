<?php

namespace Feature;

use Robot;
use Game;
use PHPUnit\Framework\TestCase;

class RobotTest extends TestCase
{
    /**
     * @var Robot
     */
    protected $robot;

    /**
     * @var Game
     */
    protected $game;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->robot = new Robot();
        $this->game = new Game($this->robot);
    }

    /**
     * Test if robot's position is correct after executing a sequence of commands
     */
    public function testIfRobotPositionIsCorrectAfterExecutingASequenceOfCommands()
    {
        /*    PLACE 0,0,NORTH
              MOVE
              REPORT
              expect  0,1,NORTH
        */
        $this->game->initialize('PLACE 0,0,NORTH');
        $this->robot->move();
        $this->assertEquals('0,1,NORTH', $this->robot->report());

        /*    PLACE 0,0,NORTH
              LEFT
              REPORT
              expect  0,1,WEST
        */
        $this->game->initialize('PLACE 0,0,NORTH');
        $this->robot->turnLeft();
        $this->assertEquals('0,0,WEST', $this->robot->report());

        /*    PLACE 1,2,EAST
              MOVE
              MOVE
              LEFT
              MOVE
              REPORT
              expect 3,3,NORTH
        */
        $this->game->initialize('PLACE 1,2,EAST');
        $this->robot->move();
        $this->robot->move();
        $this->robot->turnLeft();
        $this->robot->move();
        $this->assertEquals('3,3,NORTH', $this->robot->report());
    }
}