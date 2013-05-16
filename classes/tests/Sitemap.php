<?php

class Sitemap extends FileExistsTest {
	public $route = 'sitemap/';
	public $file = array('sitemap.xml', 'index_sitemap.xml', 'sitemap_index.xml');
	public $name = 'sitemap.xml';
	public $description = 'Checks if the sitemap.xml file exists';
	public $successMessage = 'OK: File exists';
	public $errorMessage = 'FAILED: File not found';
}

?>
