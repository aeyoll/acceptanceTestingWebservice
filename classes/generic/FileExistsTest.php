<?php

class FileExistsTest extends AcceptanceTest {
	public $file;

	public function test() {
		if (isset($this->file) && $this->file) {
			$curl = curl_init($this->domain.$this->file);

			//don't fetch the actual page, you only want to check the connection is ok
			curl_setopt($curl, CURLOPT_NOBODY, true);

			//do request
			$result = curl_exec($curl);

			$ret = false;

			//if request did not fail
			if ($result !== false) {
				//if request was ok, check response code
				$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  

				if ($statusCode == 200) {
					$ret = true;   
				}
			}

			curl_close($curl);

			return $ret;
		}
		return false;
	}
}