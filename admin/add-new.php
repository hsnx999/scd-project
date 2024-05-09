<?php

// Import required classes (including your database connection class)
require_once 'C:\xampp\htdocs\eDoc\connection.php'; // Replace with your actual file path

class AddNew extends PHPUnit\Framework\TestCase {

    // Mock database class for testing purposes
    private $mockDatabase;

    public function setUp() {
        $this->mockDatabase = $this->createMock(Database::class); // Replace with your class name
    }

    // Test user validation (session check)
    public function testUserValidation_NoSession() {
        $_SESSION = []; // Clear any existing session data

        $doctorRegistration = new DoctorRegistration($this->mockDatabase); // Replace with your class name
        $this->expectException(Exception::class); // Expect an exception if not admin
        $this->expectExceptionMessage('You are not authorized to add doctors');
        $doctorRegistration->registerDoctor($_POST); // Simulate form submission
    }

    // Test user validation (usertype check)
    public function testUserValidation_InvalidUserType() {
        $_SESSION['user'] = 'patient@edoc.com';
        $_SESSION['usertype'] = 'p'; // Set usertype to non-admin

        $doctorRegistration = new DoctorRegistration($this->mockDatabase);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('You are not authorized to add doctors');
        $doctorRegistration->registerDoctor($_POST);
    }

    // Test database connection (using mock object)
    public function testDatabaseConnection() {
        $this->mockDatabase->expects($this->once())
            ->method('query') // Verify if query method is called
            ->withAnyParameters(); // Don't care about specific query arguments

        $doctorRegistration = new DoctorRegistration($this->mockDatabase);
        $doctorRegistration->registerDoctor($_POST); // Simulate form submission
    }

    // Test email duplication check (using mock object)
    public function testEmailDuplication_ExistingEmail() {
        $this->mockDatabase->expects($this->once())
            ->method('query')
            ->with('select * from webuser where email=\'test@example.com\'') // Specific query for email check
            ->willReturn($this->createMock(mysqli_result::class)); // Mock result object

        $doctorRegistration = new DoctorRegistration($this->mockDatabase);
        $_POST['email'] = 'test@example.com'; // Set email for testing

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Email already exists');
        $doctorRegistration->registerDoctor($_POST);
    }

    // Test password match validation
    public function testPasswordMatch_NoMatch() {
        $_POST['password'] = 'password123';
        $_POST['cpassword'] = 'differentpassword';

        $doctorRegistration = new DoctorRegistration($this->mockDatabase);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Passwords do not match');
        $doctorRegistration->registerDoctor($_POST);
    }

    // ... Add more tests for successful registration and other functionalities

}
