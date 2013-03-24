<?php 

class JUnit {
	public $tests;
	public $tests_count;
	public $domain;

	public $failures = 0;
	public $skipped = 0;
	public $limit = 90;

	public function __construct($tests, $domain) {
		$this->tests = $tests;
		$this->tests_count = count($tests);
		$this->domain = $domain;
	}

	public function render() {
		header('Content-Type:text/xml');

		$dom = new DomDocument();
		$testsuites = $dom->createElement('testsuites');
		$dom->appendChild($testsuites);

		$testsuite = $dom->createElement('testsuite');
		$testsuite->setAttribute('name', 'Acceptance testing for '.$this->domain);
		$testsuite->setAttribute('tests', $this->tests_count + 1); // Adding the overall test
		$testsuite->setAttribute('failures', $this->failures);
		$testsuite->setAttribute('skipped', $this->skipped);
		$testsuites->appendChild($testsuite);

		$overall = $dom->createElement('testcase');
		$overall->setAttribute('name', 'Overall average score');
		$overall_score = 0;
		$testsuite->appendChild($overall);

		foreach ($this->tests as $test) {
			$testcase = $dom->createElement('testcase');
			$testcase->setAttribute('name', $test->name);
			$test->setDomain($this->domain);

			if ($test->test()) {
				$score = 100;
			}
			else {
				$score = 0;
				$this->failures++;
				$failure = $dom->createElement('failure', $test->errorMessage);
				$failure->setAttribute('message', 'Score: '.$score.' - '.$test->errorMessage);
				$testcase->appendChild($failure);
				$testsuite->setAttribute('failures', $this->failures);
			}

			$overall_score += $score;
			$testcase->setAttribute('status', $score);

			$testsuite->appendChild($testcase);
		}

		$average = $overall_score / $this->tests_count; 
		$overall->setAttribute('status', $average);
		if (floatval($average) < floatval($this->limit)) {
			$this->failures++;
			$failure = $dom->createElement('failure');
			$failure->setAttribute('message', 'The average overall score '.$average.' is below your limit of '.$this->limit);
			$overall->appendChild($failure);
			$testsuite->setAttribute('failures', $this->failures);
		}

		$chaineXML = $dom->saveXML();
		echo $chaineXML;
	}
}