<?php

abstract class AcceptanceTest {
	public $route;
	public $domain;
	public $name;
	public $description;
	public $done = false;
	public $status;
	public $successMessage;
	public $errorMessage;

	public function __construct() {
		$this->webservice_url = 'http://'.$_SERVER['HTTP_HOST'].'/acceptanceTestingWebservice/';
	}
	public function setDomain($domain) {
		$this->domain = 'http://'.$domain.'/';
	}
	abstract public function test();
}
