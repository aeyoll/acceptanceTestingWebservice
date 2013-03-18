<?

class W3cValidation extends AcceptanceTest {
    public $BaseUrl = 'http://validator.w3.org/check';
    public $Output = 'soap12';
    public $Uri = '';
    public $Feedback;
    public $CallUrl = '';
    public $ValidResult = false;
    public $ValidErrors = 0;
    public $Sleep = 1;
    public $SilentUi = false;
    public $Ui = '';


    public $route = 'w3cvalidation/';
    public $name = 'W3C Validation';
    public $description = 'Checks if webpage is valid for W3C standards';
    public $successMessage = 'OK: Webpage is valid';
    public $errorMessage = 'FAILED: Webpage has errors';

    function W3cValidateApi(){
        //Nothing...
    }

    function makeCallUrl(){
        $this->CallUrl = $this->BaseUrl . "?output=" . $this->Output . "&uri=" . $this->Uri;
    }

    function setUri($uri){
        $this->Uri = $uri;
        $this->makeCallUrl();
    }

    function makeValidationCall(){
        if ($this->CallUrl != '' && $this->Uri != '' && $this->Output != '') {
            $curl = curl_init($this->CallUrl);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)');

            $contents = curl_exec($curl);
            curl_close($curl);

            $this->Feedback = $contents;
            sleep($this->Sleep);
            return $contents;
        }
        else {
            return false;
        }
    }

    function validate($uri){
        if($uri != ''){
            $this->setUri($uri);
        } else {
            $this->makeCallUrl();
        }

        $this->makeValidationCall();

        $a = strpos($this->Feedback, '<m:validity>', 0)+12;
        $b = strpos($this->Feedback, '</m:validity>', $a);
        $result = substr($this->Feedback, $a, $b-$a);
        if($result == 'true'){
            $result = true;
        } else {
            $result = false;
        }
        $this->ValidResult = $result;

        if($result){
            return $result;
        } else {
            //<m:errorcount>3</m:errorcount>
            $a = strpos($this->Feedback, '<m:errorcount>', $a)+14;
            $b = strpos($this->Feedback, '</m:errorcount>', $a);
            $errors = substr($this->Feedback, $a, $b-$a);
            $this->ValidErrors = $errors;
        }
    }

    public function test() {
        return $this->validate($this->domain);
    }

    function ui_validate($uri){
        $this->validate($uri);

        if($this->ValidResult){
            $msg1 = 'This document was successfully checked';
            $color1 = '#00CC00';
        } else {
            $msg1 = 'Errors found while checking this document';
            $color1 = '#FF3300';
        }
        $ui = '<div style="background:#FFFFFF; border:1px solid #CCCCCC; padding:2px;">
                    <h1 style="color:#FFFFFF; border-bottom:1px solid #CCCCCC; margin:0; padding:5px; background:'.$color1.'; font-family:Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold;">
                     '.$msg1.'
                    </h1>
                    <div>
                        <strong>Errors:</strong><br>
                        '.$this->ValidErrors.'
                    </div>
                </div>';
        $this->Ui = $ui;
        if($this->SilentUi == false){
            echo $ui;
        }
        return $ui;

    }

}
?>
