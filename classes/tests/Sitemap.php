<?php 

class Sitemap extends AcceptanceTest {

	public function test($domain) {
		if (isset($domain) && $domain) {
			return $this->remoteFileExists($domain.'/sitemap.xml');
		}
	}
	
}

?>