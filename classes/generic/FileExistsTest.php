<?php

abstract class FileExistsTest extends AcceptanceTest {
	public $file;

	public function curl_request($file) {
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


	public function test() {
		if (isset($this->file) && $this->file) {

			/**
			  Test for multiple files
			  */
			if (is_array($this->file)) {
				$ret_array = array();
				foreach ($this->file as $file) {
					$ret_array[] = curl_request($this->domain.$file);
				}
				return in_array(true, $ret_array);
			}
			/**
			  Single file test
			  */
			else {
				return curl_request($this->domain.$this->file);
			}
		}
		return false;
	}
}
