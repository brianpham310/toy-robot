1. This program is in PHP so it's required to have PHP installed in your machine and php is in your path.
   The program source code is in 'src' directory and unit test is in 'tests' directory. 
   This program is designed to run in the terminal.
   To run the program, open a terminal window and cd to the root directory of the project and run : php -f src/main.php. 
   The main window will show all commands and how to send them to the Toy Robot.
   Commands can be in lowercase or uppercase.

2. To run Unit tests. First you need to install PHPunit using composer. Cd to the root directory and run: composer install. It will install php unit package and its dependencies. After that to execute unit test run:
./vendor/bin/phpunit --bootstrap vendor/autoload.php tests
This will run all tests under tests directory.
