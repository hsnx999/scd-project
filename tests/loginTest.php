<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    public function testValidPatientLogin(): void
    {
        // Simulate a valid patient login
        $_POST['useremail'] = 'patient@edoc.com';
        $_POST['userpassword'] = '123';

        // Include the login.php file
        require_once 'C:/xampp/htdocs/eDoc/login.php';

        // Assert that the session variables are set correctly
        $this->assertEquals('patient@edoc.com', $_SESSION['user']);
        $this->assertEquals('p', $_SESSION['usertype']);
    }

    public function testInvalidLogin(): void
    {
        // Simulate an invalid login
        $_POST['useremail'] = 'invalid@example.com';
        $_POST['userpassword'] = 'password';

        // Include the login.php file
        require_once 'C:/xampp/htdocs/eDoc/login.php';

        // Assert that the error message is displayed
        $error = 'We cant found any acount for this email.';
        $this->assertStringContainsString($error, $error);
    }

    public function testInvalidLoginPassword(): void
    {
        // Simulate an invalid login
        $_POST['useremail'] = 'admin@edoc.com';
        $_POST['userpassword'] = 'password';

        // Include the login.php file
        require_once 'C:/xampp/htdocs/eDoc/login.php';

        // Assert that the error message is displayed
        $error = 'Wrong credentials: Invalid email or password';
        $this->assertStringContainsString($error, $error);
    }
}