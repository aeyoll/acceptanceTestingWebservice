<?php

class Robots extends FileExistsTest {
	public $route = 'robots/';
	public $file = 'robots.txt';
	public $name = 'robots.txt';
	public $description = 'Checks if the robots.txt file exists';
	public $successMessage = 'OK: File exists';
	public $errorMessage = 'FAILED: File not found';
}

?>
