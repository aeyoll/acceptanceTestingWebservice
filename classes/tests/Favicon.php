<?php

class Favicon extends FileExistsTest {
	public $route = 'favicon/';
	public $file = 'favicon.ico';
	public $name = 'favicon.ico';
	public $description = 'Checks if the favicon.ico file exists';
	public $successMessage = 'OK: File exists';
	public $errorMessage = 'FAILED: File not found';
}

?>
