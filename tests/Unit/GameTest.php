<?php

use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
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
        $robot = new Robot();
        $this->game = new Game($robot);
    }

    /**
     *  Test invalid robot place commands
     */
    public function testInvalidRobotInitializations()
    {
        // X position must be a number
        $this->game->initialize('PLACE x,0,north');
        $this->assertFalse($this->game->getRobot()->isStateValid());

        $this->game->initialize('PLACE 0,a,north');
        $this->assertFalse($this->game->getRobot()->isStateValid());

        // X position must be a integer number
        $this->game->initialize('PLACE 1.2,0,north');
        $this->assertFalse($this->game->getRobot()->isStateValid());

        // Y position must be a integer number
        $this->game->initialize('PLACE 0,5.3,north');
        $this->assertFalse($this->game->getRobot()->isStateValid());

        // x must be an integer between 0 and 4
        $this->game->initialize('PLACE-1,2,north');
        $this->assertFalse($this->game->getRobot()->isStateValid());
        $this->game->initialize('PLACE 5,2,north');
        $this->assertFalse($this->game->getRobot()->isStateValid());

        // y must be an integer between 0 and 4
        $this->game->initialize(2, -4, 'north');
        $this->assertFalse($this->game->getRobot()->isStateValid());
        $this->game->initialize('PLACE 2,6,north');
        $this->assertFalse($this->game->getRobot()->isStateValid());

        // directions must be either north, west, south, east
        $this->game->initialize('PLACE 2,3,up');
        $this->assertFalse($this->game->getRobot()->isStateValid());
    }

    /**
     * Test if Robot can be placed correctly on the grid
     */
    public function testRobotCanbeInitializedSuccesfully()
    {
        $this->game->initialize('PLACE 2,3,east');
        $this->assertTrue($this->game->getRobot()->isStateValid());

        $this->game->initialize('PLACE 0,0,south');
        $this->assertTrue($this->game->getRobot()->isStateValid());

        $this->game->initialize('PLACE 4,4,west');
        $this->assertTrue($this->game->getRobot()->isStateValid());

        $this->game->initialize('PLACE 1,1,north');
        $this->assertTrue($this->game->getRobot()->isStateValid());
    }
}