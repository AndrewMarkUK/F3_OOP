<?php
/*
 * Copyright (c) 2022.
 */

class AMMValidation
{
    private array $validation;
    public $msg;
    public $errortext;

    function __construct($validation)
    {
        $this->validation = $validation;
        $msg = array();
    }

    function is_invalid($data)
    {
        if (is_array($this->validation) && !empty($this->validation)) {
            $this->validation();
        }
        if (is_array($this->msg) && !empty($this->msg)) {
            return true;
        } else {
            return false;
        }
    }

    function fields($array,$key1 = 0)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if ($key1 == "0") {
                    $key1 = $key;
                }
                $this->fields($value,$key1);
            } else {

                if ($key1 == "0") {
                    $keyfields = $key;
                } else {
                    $keyfields = $key1;
                }
                $this->validation($keyfields,$value);
            }
        }

    }

    function get_Errors()
    {
        if (is_array($this->msg) && !empty($this->msg)) {
            $html = "<ul class='ms-3 list-group'>";
            foreach ($this->msg as $error) {
                $html .= "<li>" . $error[0] . "</li>";
            }
            $html .= "</ul>";
            return $html;
        }
    }

    private function validation()
    {
        $parm = array();
        foreach ($this->validation as $fn => $v) {
            if (isset($v['validation'])) {
                $this->errortext = $v['text'];
                $validationarray = explode("|",$v['validation']);
                foreach ($validationarray as $valid) {
                    $parms = array();
                    preg_match_all("/\[(.*?)\]/",$valid,$matches);
                    if (isset($matches[1][0])) {
                        $braket = $matches[1][0];
                        $valid = preg_replace('/\[(.*)\]/','',$valid);

                        $braket = explode(",",$braket);
                    }
                    if (method_exists($this,$valid)) {
                        $parm[] = isset($_REQUEST[$v['name']]) ? $_REQUEST[$v['name']] : "";
                        if (isset($braket)) {
                            foreach ($braket as $b) {
                                $parm[] = $b;
                            }
                        }
                        $parms[] = isset($_REQUEST[$v['name']]) ? $_REQUEST[$v['name']] : "";
                        $msg = call_user_func_array(array($this,$valid),$parms);

                        if ($msg != "") {

                            $this->msg[$v['name']][] = $msg;
                        }
                    } else {

                        die($valid . ' function not found');
                    }
                }
            }
        }
    }

    function is_space($val)
    {
        if (ctype_space($val)) {
            return "$this->errortext Appears Empty!";
        }
    }

    function is_for_real_name($val)
    {
        if (!(bool)preg_match("/^([A-Za-z-\s'])+$/i",$val)) {
            return "$this->errortext Letters, Hyphens and ' Only!";
        }
    }

    function is_for_item_name($val)
    {
        if (!(bool)preg_match("/^([A-Za-z-\s'0-9])+$/i",$val)) {
            return "$this->errortext Letters, Hyphens and ' Only!";
        }
    }

    function is_address($val)
    {
        if (!(bool)preg_match("/^([A-Za-z0-9-\s'])+$/i",$val)) {
            return "$this->errortext Letters, Numbers, Hyphens and ' Only!";
        }
    }

    function is_addresstwo($val)
    {
        if (!(bool)preg_match("(^[a-zA-Z\s]*$)",$val)) {
            return "$this->errortext Letters, Numbers, Hyphens and ' Only!";
        }
    }

    function is_postcode($val)
    {
        if (!(bool)preg_match("/^([A-Za-z0-9\s])+$/i",$val)) {
            return "$this->errortext Letters and Numbers Only!";
        }
    }

    function is_email($val)
    {
        if (!filter_var($val,FILTER_VALIDATE_EMAIL)) {
            return "$this->errortext Invalid Format!";
        }
    }

    function is_telephone($val)
    {
        if (!(bool)preg_match("/^([0-9 '])+$/i",$val)) {
            return "$this->errortext Numbers Only!";
        }
    }

    function is_alpha($val)
    {
        if (!(bool)preg_match("/^([a-zA-Z])+$/i",$val)) {
            return "$this->errortext Letters Only!";
        }
    }

    function is_alphadash($val)
    {
        if ((bool)preg_match("/[^a-z_\-0-9]/i",$val)) {
            return "$this->errortext Letters, Hyphens or Underscores Only!";
        }
    }

    function is_alphanumeric($val)
    {
        if (!(bool)preg_match("/^([a-zA-Z0-9\s])+$/i",$val)) {
            return "$this->errortext Alphanumeric Only!";
        }
    }

    function is_numeric($val)
    {
        if (!(bool)preg_match('/^[-+]?[0-9]*.?[0-9]+$/',$val)) {
            return "$this->errortext Numeric Only!";
        }
    }

    function is_decimal($val)
    {
        if (!(bool)preg_match("#\d+(?:\.\d{1,2})?#",$val)) {
            return "$this->errortext Decimal Only";
        }
    }

    function is_maxlength($val,$max)
    {
        if (strlen($val) <= (int)$max) {

            return "$this->errortext Less than $max Only!";
        }
    }

    function is_minlength($val,$min)
    {
        if ((strlen($val) >= (int)$min)) {
            return "$this->errortext Greater than $min Only!";
        }
    }

    function is_domain($val)
    {
        if (!(bool)checkdnsrr(preg_replace('/^[^@]++@/','',$val),'MX')) {
            return "$this->errortext is Invalid! ";
        }
    }

    function is_required($val)
    {
        if ($val == "") {
            return "$this->errortext Required!";
        }
    }

    function is_file_ready($val)
    {
        if ($_FILES['fileupload']['size'] == 0 && $_FILES['fileupload']['error'] == 0) {
            return "$this->errortext Required!";
        }
    }

    function is_urlexists($val)
    {
        if (!(bool)@fsockopen($val,80,$errno,$errstr,30)) {
            return "$this->errortext Invalid!";
        }
    }

    function is_safe($val)
    {
        if ((bool)preg_match("/<[^>]*>/",$val)) {
            return "$this->errortext Disabled for Current Content!";
        }
    }

    function is_captcha($val)
    {
        if (isset($_POST['sum']) && $_POST['sum'] != $_SESSION['sumanswer']) {
            return "$this->errortext Incorrect. Please Try Again!";
        }
    }

    function is_checkbox_array($val)
    {
        if (!isset($_POST['checkbox_level'])) {
            return "$this->errortext Required!";
        }
    }

    function is_content_empty($val)
    {
        if ($_POST['record_description'] == '<p><br></p>') {
            return "$this->errortext Required!";
        }
    }

    function is_date($val)
    {
        if (!preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/",$val,$parts)) {
            return "$this->errortext Incorrect Format!";
        }
    }

    function is_datetime($val)
    {
        if (!preg_match("/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/",$val,$parts)) {
            return "$this->errortext Incorrect Format!";
        }
    }

    function is_price($val)
    {
        if (!preg_match("/^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$/",$val)) {
            return "$this->errortext 0.00!";
        }
    }
}