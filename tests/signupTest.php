<?php
use PHPUnit\Framework\TestCase;

class SignUpTest extends TestCase {
    public function testFormDataCanBeSubmitted() {
        // Simulate form submission with sample data
        $_POST['fname'] = 'John';
        $_POST['lname'] = 'Doe';
        $name=$_POST['fname']." ".$_POST['lname'];
        $_POST['address'] = '123 Main Street';
        $_POST['nic'] = '1234567890';
        $_POST['dob'] = '2000-01-01';

        // Start the session
        session_start();

        // Include the script
        include 'C:\xampp\htdocs\eDoc\signup.php';

        // Check if session variables are set correctly
        $this->assertEquals('John', $_SESSION["personal"]['fname']);
        $this->assertEquals('Doe', $_SESSION["personal"]['lname']);
        $this->assertEquals('John Doe', $name);
        $this->assertEquals('123 Main Street', $_SESSION["personal"]['address']);
        $this->assertEquals('1234567890', $_SESSION["personal"]['nic']);
        $this->assertEquals('2000-01-01', $_SESSION["personal"]['dob']);
        session_abort();
    }
}
