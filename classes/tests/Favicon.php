<?php 

class Favicon extends AcceptanceTest {

	public function test($domain) {
		if (isset($domain) && $domain) {
			return $this->remoteFileExists($domain.'/favicon.ico');
		}
	}
	
}

?>