<?php

$f3 = require('lib/base.php');
$f3->set('DEBUG',3);
$f3->set('AUTOLOAD','classes/tests/');

$f3->route('GET /',
	function() {
		echo 'Acceptance Testing Webservice';
	}
);
$f3->route('GET /robots/@url',
	function($f3) {
		$obj = new RobotsTxt;
		echo $obj->test('http://'.$f3->get('PARAMS.url'));
	}
);
$f3->route('GET /favicon/@url',
	function($f3) {
		$obj = new Favicon;
		echo $obj->test('http://'.$f3->get('PARAMS.url'));
	}
);
$f3->route('GET /sitemap/@url',
	function($f3) {
		$obj = new Sitemap;
		echo $obj->test('http://'.$f3->get('PARAMS.url'));
	}
);

$f3->run();
