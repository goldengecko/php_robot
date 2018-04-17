<?php
require_once 'autoload.php';

// Utility
function startsWith($haystack, $needle) {
  return substr($haystack, 0, strlen($needle)) === $needle;
}

$shortopts  = "h::f::";
$longopts  = ["help::", "file::"];

$options = getopt($shortopts, $longopts);

if (array_key_exists('h', $options) || array_key_exists('help', $options)) {
  echo "\e[33mUsage:\e[0m\n";
  echo "\t-f or --file specifies a file to load. If a file is loaded, it will be executed and the program will exit.\n";
  echo "\t-h or --help will display this help screen.\n\n";
  echo "If no file is loaded, commands are entered interactively, and you can exit by typing 'exit' or 'quit'.\n\n";
  echo "Commands in the file are one command per line. Commands for interactive and file based usage are the same, as follows:\n\n";
  echo "\e[33mRobot Commands:\e[0m\n";
  echo "\t\e[32mPLACE X,Y,Facing\e[0m\tSets the position and compass direction e.g. PLACE 2, 3, NORTH\n";
  echo "\t\e[32mMOVE\e[0m\tMoves the robot one place in the direction it is facing\n";
  echo "\t\e[32mLEFT\e[0m\tTurns the robot left\n";
  echo "\t\e[32mRIGHT\e[0m\tTurns the robot right\n";
  echo "\t\e[32mREPORT\e[0m\tAsks the robot to report its position and direction\n";
  exit(0);
}

// See if the user has specified a file
$file = null;
if (array_key_exists('f', $options)) {
  $file = $options['f'];
} else if (array_key_exists('file', $options)) {
  $file = $options['file'];
}

if ($file) {
  echo "\e[33mLoading from file: $file\e[0m\n";

  $lines = file($file, FILE_SKIP_EMPTY_LINES);

  if ($lines === false) {
    echo "\e[31mUnable to read file\e[0m\n";
    exit(-1);
  }
  if (!count($lines)) {
    echo "\e[31mFile appears to be empty\e[0m\n";
    exit(-1);
  }

  $robot = new Robot();

  foreach ($lines as $line) {
    processCommand($robot, $line);
  }
} else {
  $robot = new Robot();

  while(true) {
    $line = readline("Command: ");
    if (strcasecmp($line, 'quit') == 0 || strcasecmp($line, 'exit') == 0) {
      echo "Exiting";
      exit(0);
    }
    readline_add_history($line);
    processCommand($robot, $line);
  }
}

/**
 * Core processing function called either when processing lines from a file or
 * user entered.
 *
 * @param Robot $robot
 * @param string $line
 * @return void
 */
function processCommand(Robot $robot, string $line) {
  $line = rtrim($line);
  $ucLine = strtoupper($line);
  if (startsWith($ucLine, 'PLACE')) {
    // Remove the "PLACE" from the start of the string.
    $location = substr($ucLine, strlen('PLACE'));
    $parts = explode(',', $location);
    if (count($parts) != 3 || !is_numeric($parts[0]) || !is_numeric(($parts[1]))) {
      echo "\e[31mIncorrectly formatted PLACE command: \e[0m$ucLine\n";
      echo "Format should be: \e[32mPLACE X,Y,Facing\e[0m e.g. PLACE 2, 3, NORTH\n";
      return;
    }
    $x = $parts[0];
    $y = $parts[1];
    $direction = trim($parts[2]);
    $success = $robot->place($x, $y, $direction);
    if ($success === true) {
      echo "✓ $ucLine\n";
    } else {
      echo "\e[31mFailed to execute $ucLine. Messages are as follows: $success\e[0m";
    }
  } else if (startsWith($ucLine, 'MOVE')) {
    $success = $robot->move();
    if ($success === true) {
      echo "✓ $ucLine\n";
    } else {
      echo "\e[31mFailed to execute $ucLine command\e[0m\n";
    }
  } else if (startsWith($ucLine, 'LEFT')) {
    $success = $robot->left();
    if ($success === true) {
      echo "✓ $ucLine\n";
    } else {
      echo "\e[31mFailed to execute $ucLine command\e[0m\n";
    }
  } else if (startsWith($ucLine, 'RIGHT')) {
    $success = $robot->right();
    if ($success === true) {
      echo "✓ $ucLine\n";
    } else {
      echo "\e[31mFailed to execute $ucLine command\e[0m\n";
    }
  } else if (startsWith($ucLine, 'REPORT')) {
    $report = $robot->report();
    if ($report === false) {
      echo "\e[31mFailed to execute $ucLine command\e[0m\n";
    } else {
      echo "✓ $report\n";
    }
  } else if (strlen($ucLine)) {
    echo "\e[31mUnknown command: \e[0m$ucLine\n";
  }
}