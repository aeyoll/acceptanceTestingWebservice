<?php 

class RobotsTxt extends AcceptanceTest {

	public function test($domain) {
		if (isset($domain) && $domain) {
			return $this->remoteFileExists($domain.'/robots.txt');
		}
	}
	
}

?>