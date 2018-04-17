## Robot Programming Example

___

### Requirements:
This application is designed to run using php 7.1 or later, with Composer available. PHPUnit is installed as part of the installation instructions below.

### Installation
CD to the root folder, and use `composer install`

### Automated Tests
There is a script called `test.sh` in the root folder. Make sure it is executable and you can run that using `./test.sh` to run all the tests.

The tests themselves are in the tests/RobotTest.php file.

### Commandline Execution
There is a script called `cli.sh` in the root folder. Make sure it is executable and you can run it to either enter commands interactively or run a command file.

> **Help**
> To see the commandline help, execute the command `./cli.sh --help` from the project root folder.

#### Interactive Commands

You can run commands interactively by running `./cli.sh` from the project root folder.

Just type in the commands, for instance:
> place 3, 3, north
> move
> report

The interactive interface has history turned on so you should be able to use the up arrow to select previous commands, so save you having to retype them.

**Quitting**
You can quit the interactive session by typing `quit` or `exit` (or just pressing control-c).

#### Running A Command File
You can create files with commands in them and run the entire file. The commands are the same as what you would write in the interactive session (see the help for details).

To run a command file just use `./cli.sh --file=FILENAME`.

**Example Command Files**
There are three example command files provided which do the basic testing as per the requirements document. You can run these by issuing the following commands:
```
./cli.sh --file=test_a
./cli.sh --file=test_b
./cli.sh --file=test_c
```

___

## Requirements Document

The following is the requirements document that this project is built to satisfy.

**Toy Robot Simulator**

Description:
- The application is a simulation of a toy robot moving on a square tabletop, of dimensions 5 units x 5 units.
- There are no other obstructions on the table surface.
- The robot is free to roam around the surface of the table, but must be prevented from falling to destruction. Any movement that would result in the robot falling from the table must be prevented, however further valid movement commands must still be allowed.

Create an application that can read in commands of the following form – 
> PLACE X,Y,F
> MOVE
> LEFT
> RIGHT
> REPORT

- **PLACE** will put the toy robot on the table in position X,Y and facing NORTH, SOUTH, EAST or WEST. 
- The origin (0,0) can be considered to be the SOUTH WEST most corner.
- The first valid command to the robot is a PLACE command, after that, any sequence of commands may be issued, in any order, including another PLACE command. The application should discard all commands in the sequence until a valid PLACE command has been executed.
- **MOVE** will move the toy robot one unit forward in the direction it is currently facing.
- **LEFT** and **RIGHT** will rotate the robot 90 degrees in the specified direction without changing the position of the robot.
- **REPORT** will announce the X,Y and F of the robot. This can be in any form, but standard output is sufficient.
- A robot that is not on the table can choose the ignore the MOVE, LEFT, RIGHT and REPORT commands.
- Input can be from a file, or from standard input, as the developer chooses.
- Provide test data to exercise the application.

**Constraints:**
The toy robot must not fall off the table during movement. This also includes the initial placement of the toy robot. Any move that would cause the robot to fall must be ignored.

**Example Input and Output:**
a)
> PLACE 0,0,NORTH
> MOVE
> REPORT

_Output:_ 0,1,NORTH

b)
> PLACE 0,0,NORTH
> LEFT
> REPORT

_Output:_ 0,0,WEST

c)
> PLACE 1,2,EAST
> MOVE
> MOVE
> LEFT
> MOVE
> REPORT

_Output:_ 3,3,NORTH


- There must be a way to supply the application with input data via text file.

- The application must run and you should provide sufficient evidence that your solution is complete by, as a minimum, indicating that it works correctly against the supplied test data.

- The submission should be production quality PHP code. We are not looking for a gold plated solution, but the code should be maintainable and extensible.

- You may not use any external libraries to solve this problem, but you may use external libraries or tools for building or testing purposes. Specifically, you may use unit testing libraries or build tools.

- You should provide a readme file, detailing installation and execution instruction as well as a brief summary of assumptions and design decisions made.

- The submission should be provided via GitHub, Bitbucket or some other online version control system

