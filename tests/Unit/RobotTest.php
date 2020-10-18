<?php

use PHPUnit\Framework\TestCase;

final class RobotTestTest extends TestCase
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
     * Test if Robot ignore command if them will place the robot off the grid
     */
    public function testIgnoreMoveCommandIfItThrowsRobotOffGrid()
    {
        $expected_state = [];
        //start at 0,0,south
        $this->game->initialize('PLACE 0,0,south');
        $this->robot->move();
        $this->assertEquals('0,0,SOUTH', $this->robot->report());

        //start at 0,0,west
        $this->game->initialize('PLACE 0,0,west');
        $this->robot->move();
        $this->assertEquals('0,0,WEST', $this->robot->report());

        // start at 0,4,north
        $this->game->initialize('PLACE 0,4,north');
        $this->robot->move();
        $this->assertEquals('0,4,NORTH', $this->robot->report());

        // start at 0,4,west
        $this->game->initialize('PLACE 0,4,west');
        $this->robot->move();
        $this->assertEquals('0,4,WEST', $this->robot->report());

        // start at 4,4,north
        $this->game->initialize('PLACE 4,4,north');
        $this->robot->move();

        $this->assertEquals('4,4,NORTH', $this->robot->report());
        // start at 4,4,east
        $this->game->initialize('PLACE 4,4,east');
        $this->robot->move();
        $this->assertEquals('4,4,EAST', $this->robot->report());

        // start at 4,0,est
        $this->game->initialize('PLACE 4,0,east');
        $this->robot->move();
        $this->assertEquals('4,0,EAST', $this->robot->report());
        // start at 4,0,south
        $this->game->initialize('PLACE 4,0,south');
        $this->robot->move();
        $this->assertEquals('4,0,SOUTH', $this->robot->report());
    }

    /**
     * Test if Robot can be move
     */
    public function testRobotCanMove()
    {
        // test north movement
        $this->game->initialize('PLACE 2,2,north');
        $this->robot->move();
        $this->assertEquals('2,3,NORTH', $this->robot->report());

        // test east movement
        $robot = $this->game->initialize('PLACE 2,2,east');
        $this->robot->move();
        $this->assertEquals('3,2,EAST', $this->robot->report());

        // test south movement
        $this->game->initialize('PLACE 2,2,south');
        $this->robot->move();
        $this->assertEquals('2,1,SOUTH', $this->robot->report());

        // test west movement
        $this->game->initialize('PLACE 2,2,west');
        $this->robot->move();
        $this->assertEquals('1,2,WEST', $this->robot->report());
    }

    /**
     * Test if Robot can turn left
     */
    public function testRobotCanTurnLeft()
    {
        $this->game->initialize('PLACE 2,2,north');
        // turn robot left and check for direction
        $this->robot->turnLeft();
        $this->assertEquals($this->robot->getDirection(), 'west');

        $this->robot->turnLeft();
        $this->assertEquals($this->robot->getDirection(), 'south');

        $this->robot->turnLeft();
        $this->assertEquals($this->robot->getDirection(), 'east');

        $this->robot->turnLeft();
        $this->assertEquals($this->robot->getDirection(), 'north');
    }

    /**
     * Test if Robot can turn right
     */
    public function testRobotCanTurnRight()
    {
        $this->game->initialize('PLACE 2,2,north');

        // turn robot right and check for direction
        $this->robot->turnRight();
        $this->assertEquals($this->robot->getDirection(), 'east');

        $this->robot->turnRight();
        $this->assertEquals($this->robot->getDirection(), 'south');

        $this->robot->turnRight();
        $this->assertEquals($this->robot->getDirection(), 'west');

        $this->robot->turnRight();
        $this->assertEquals($this->robot->getDirection(), 'north');
    }
}
