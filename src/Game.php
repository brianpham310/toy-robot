<?php


class Game
{
    protected $robot;

    function __construct($robot = null)
    {
        $this->robot = $robot ?? new Robot();
    }

    public function getRobot()
    {
        return $this->robot;
    }

    /**
     * Place robot on the grid
     * @param $positionInstruction
     */
    public function initialize($positionInstruction)
    {
        $positionInstruction = strtolower($positionInstruction);
        // split the command to 2 parts, the second part contains x,y, and direction
        $instructionParts = preg_split('#\s+#', $positionInstruction, null, PREG_SPLIT_NO_EMPTY);

        // make sure the place instruction have 2 parts
        if (count($instructionParts) == 2) {
            // get the params for robot
            $positionParams = explode(",", $instructionParts[1]);
            // make sure we have only 3 params X, Y, and direction
            if (count($positionParams) == 3) {
                // check if x,y and position are valid
                if ($this->robot->isXValid($positionParams[0]) && $this->robot->isYValid($positionParams[1]) &&
                    $this->robot->isDirectionValid($positionParams[2])) {
                    $this->robot->setX($positionParams[0]);
                    $this->robot->setY($positionParams[1]);
                    $this->robot->setDirectionPointer(array_search($positionParams[2], Robot::VALID_DIRECTIONS));
                }
            }
        }
    }

    /**
     * Start the game
     */
    public function start()
    {
        // intro
        echo "         --------------------------------------------------------------------\n
        |                                                                   |\n
        |                         WELCOME TO TOY ROBOT                      |\n
        |                                                                   |\n
        | To start creating a robot use the command: PLACE X,Y,DIRECTION    |\n
        | where DIRECTION must be one of NORTH, EAST, SOUTH OR WEST. X and  |\n 
        | Y must be a number between 0 and 4.                               |\n
        | 
        | There must be a space between PLACE and X. There must not be any  |\n
        | spaces between ','.                                               |\n
        | Other commands:                                                   |\n
        | MOVE   move robot 1 step forward in the current direction         |\n
        | LEFT   rotate robot 90 degree to the left of current direction    |\n
        | RIGHT  rotate robot 90 degree to the right of current direction   |\n
        | REPORT print out current position and direction of robot          |\n
        | The commands can be in either uppercase or lowercase.             |\n
        --------------------------------------------------------------------\n";

        // an infinite loop to get user input from the command line
        do {
            // get user command
            $handle = fopen("php://stdin", "r");
            $line = fgets($handle);
            $command = trim($line);
            // check if it's an initialization command
            if (stripos($command, 'place') !== false) {
                $this->initialize($command);
            } else {
                $this->robot->execute($command);
            }
        } while (true);
    }
}