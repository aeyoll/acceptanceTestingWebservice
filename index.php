<?php

$f3 = require('lib/base.php');
$f3->set('DEBUG', 3);
$f3->set('AUTOLOAD','classes/generic/;classes/tests/');

function getDirectoryList($directory) {
	$results = array();
	$handler = opendir($directory);
	while ($file = readdir($handler)) {
		if ($file != '.' && $file != '..' && strtolower(substr($file, strrpos($file, '.') + 1)) == 'php') {
			$results[] = $file;
	 	}
	}
	closedir($handler);
	return $results;
}

function file_get_php_classes($filepath) {
	$php_code = file_get_contents($filepath);
	$classes = get_php_classes($php_code);
	return $classes;
}

function get_php_classes($php_code) {
	$classes = array();
	$tokens = token_get_all($php_code);
	$count = count($tokens);
	for ($i = 2; $i < $count; $i++) {
		if ($tokens[$i - 2][0] == T_CLASS
			&& $tokens[$i - 1][0] == T_WHITESPACE
			&& $tokens[$i][0] == T_STRING) {

			$class_name = $tokens[$i][1];
			$classes[] = $class_name;
		}
	}
	return $classes;
}

$f3->route('GET /',
	function() {
		echo 'Acceptance Testing Webservice';
	}
);

$tests = getDirectoryList(dirname(__FILE__).'/classes/tests/');
$tests_objects = array();
foreach ($tests as $test_file) {
	$classes = file_get_php_classes(dirname(__FILE__).'/classes/tests/'.$test_file);
	foreach ($classes as $class) {
		$acceptance_test = new $class();
		$tests_objects[] = $acceptance_test;
	}
	$f3->set('tests_objects', $tests_objects);
}
$f3->route('GET /tests',
	function($f3) {
		die(json_encode($f3->get('tests_objects')));
	}
);

$f3->route('GET /@test/@url',
	function($f3, $params) {
		if (class_exists($params['test'])) {
			$acceptance_test = new $params['test']();
			$acceptance_test->setDomain($f3->get('PARAMS.url'));
			echo $acceptance_test->test();
		}
	}
);


$f3->run();
