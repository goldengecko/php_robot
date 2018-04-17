<?php
use PHPUnit\Framework\TestCase;

class RobotTest extends TestCase
{
    public function testRobotInitialize()
    {
        $robot = new Robot();
        $this->assertAttributeEquals(0, 'x', $robot);
        $this->assertAttributeEquals(0, 'y', $robot);
        $this->assertAttributeEquals(0, 'direction', $robot);
    }

    public function testRobotPlace() {
        $robot = new Robot();
        $this->assertEquals(true, $robot->place(1, 2, 'EAST'));
        $this->assertAttributeEquals(1, 'x', $robot);
        $this->assertAttributeEquals(2, 'y', $robot);
        $this->assertAttributeEquals(1, 'direction', $robot);

        // These are noisy with output errors, so suppress the output
        $this->setOutputCallback(function() {});

        $this->assertInternalType('string', $robot->place(100, 42, 'WEST'));
        $this->assertInternalType('string', $robot->place(-1, -2, 'SOUTH'));
        $this->assertInternalType('string', $robot->place(1, 2, 'Bananas'));
        $this->assertInternalType('string', $robot->place(1.3, 2, 'SOUTH'));
        $this->assertInternalType('string', $robot->place(1, 2.5, 'SOUTH'));

        $this->assertAttributeEquals(1, 'x', $robot);
        $this->assertAttributeEquals(2, 'y', $robot);
        $this->assertAttributeEquals(1, 'direction', $robot);
    }

    public function testRotate() {
        $robot = new Robot();
        // Should not rotate before having been placed
        $robot->left();
        $this->assertAttributeEquals(0, 'direction', $robot);
        $robot->right();
        $this->assertAttributeEquals(0, 'direction', $robot);

        $robot->place(1, 2, 'EAST');
        $this->assertAttributeEquals(1, 'direction', $robot);

        $robot->left();
        $this->assertAttributeEquals(0, 'direction', $robot);
        $robot->left();
        $this->assertAttributeEquals(3, 'direction', $robot);
        $robot->left();
        $this->assertAttributeEquals(2, 'direction', $robot);
        $robot->left();
        $this->assertAttributeEquals(1, 'direction', $robot);
        $robot->left();
        $this->assertAttributeEquals(0, 'direction', $robot);

        $robot->right();
        $this->assertAttributeEquals(1, 'direction', $robot);
        $robot->right();
        $this->assertAttributeEquals(2, 'direction', $robot);
        $robot->right();
        $this->assertAttributeEquals(3, 'direction', $robot);
        $robot->right();
        $this->assertAttributeEquals(0, 'direction', $robot);
        $robot->right();
        $this->assertAttributeEquals(1, 'direction', $robot);
    }

    public function testMove() {
        $robot = new Robot();
        // Should not move if it hasn't been placed
        $robot->move();
        $this->assertAttributeEquals(0, 'direction', $robot);

        $robot->place(1, 2, 'EAST');
        $robot->move();
        $this->assertAttributeEquals(2, 'x', $robot);
        $this->assertAttributeEquals(2, 'y', $robot);
        $robot->move();
        $this->assertAttributeEquals(3, 'x', $robot);
        $this->assertAttributeEquals(2, 'y', $robot);
        $robot->move();
        $this->assertAttributeEquals(4, 'x', $robot);
        $this->assertAttributeEquals(2, 'y', $robot);
        $robot->move();
        $this->assertAttributeEquals(4, 'x', $robot);
        $this->assertAttributeEquals(2, 'y', $robot);

        $robot->place(1, 2, 'WEST');
        $robot->move();
        $this->assertAttributeEquals(0, 'x', $robot);
        $this->assertAttributeEquals(2, 'y', $robot);
        $robot->move();
        $this->assertAttributeEquals(0, 'x', $robot);
        $this->assertAttributeEquals(2, 'y', $robot);

        $robot->place(3, 2, 'NORTH');
        $robot->move();
        $this->assertAttributeEquals(3, 'x', $robot);
        $this->assertAttributeEquals(3, 'y', $robot);
        $robot->move();
        $this->assertAttributeEquals(3, 'x', $robot);
        $this->assertAttributeEquals(4, 'y', $robot);
        $robot->move();
        $this->assertAttributeEquals(3, 'x', $robot);
        $this->assertAttributeEquals(4, 'y', $robot);

        $robot->place(3, 2, 'SOUTH');
        $robot->move();
        $this->assertAttributeEquals(3, 'x', $robot);
        $this->assertAttributeEquals(1, 'y', $robot);
        $robot->move();
        $this->assertAttributeEquals(3, 'x', $robot);
        $this->assertAttributeEquals(0, 'y', $robot);
        $robot->move();
        $this->assertAttributeEquals(3, 'x', $robot);
        $this->assertAttributeEquals(0, 'y', $robot);
    }

    public function testReport() {
        $robot = new Robot();
        $this->assertEquals(false, $robot->report());
        $robot->place(1, 2, 'EAST');
        $this->assertEquals('I am at 1, 2, facing EAST', $robot->report());
    }

    public function testSequenceReport() {
        $robot = new Robot();
        $robot->place(1, 2, 'EAST');
        $robot->move();
        $robot->left();
        $robot->left();
        $robot->move();
        $robot->right();
        $robot->move();
        $this->assertEquals('I am at 1, 3, facing NORTH', $robot->report());
    }
}
