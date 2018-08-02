<?php
namespace App\Http\Controllers;

define("SSLCZ_STORE_ID", "testbox");
define("SSLCZ_STORE_PASSWD", "qwerty");

# IF SANDBOX TRUE, THEN IT WILL CONNECT WITH SSLCOMMERZ SANDBOX (TEST) SYSTEM
define("SSLCZ_IS_SANDBOX", true);

# IF BROWSE FROM LOCAL HOST, KEEP true
define("SSLCZ_IS_LOCAL_HOST", true);

class SSLCommerz
{
    protected $sslc_submit_url;
    protected $sslc_validation_url;
    protected $sslc_mode;
    protected $sslc_data;
    protected $store_id;
    protected $store_pass;
    public $error = '';

    public function __construct()
    {
        $this->setSSLCommerzMode((SSLCZ_IS_SANDBOX) ? 1 : 0);
        $this->store_id = SSLCZ_STORE_ID;
        $this->store_pass = SSLCZ_STORE_PASSWD;
        $this->sslc_submit_url = "https://" . $this->sslc_mode . ".sslcommerz.com/gwprocess/v3/api.php";
        $this->sslc_validation_url = "https://" . $this->sslc_mode . ".sslcommerz.com/validator/api/validationserverAPI.php";
    }

    public function initiate($post_data, $get_pay_options = false)
    {
        if ($post_data != '' && is_array($post_data)) {

            $post_data['store_id'] = $this->store_id;
            $post_data['store_passwd'] = $this->store_pass;

            $load_sslc = $this->sendRequest($post_data);

            if ($load_sslc) {
                if (isset($this->sslc_data['status']) && $this->sslc_data['status'] == 'SUCCESS') {
                    if (!$get_pay_options) {
                        if (isset($this->sslc_data['GatewayPageURL']) && $this->sslc_data['GatewayPageURL'] != '') {
                            //header("Location: " . $this->sslc_data['GatewayPageURL']);
                            echo "
                                <script>
                                    window.location.href = '" . $this->sslc_data['GatewayPageURL'] . "';
                                </script>
                            ";
                            exit;
                        } else {
                            $this->error = "No redirect URL found!";
                            return $this->error;
                        }
                    } else {
                        $options = array();
                        # VISA GATEWAY
                        if (isset($this->sslc_data['gw']['visa']) && $this->sslc_data['gw']['visa'] != "") {
                            $sslcz_visa = explode(",", $this->sslc_data['gw']['visa']);
                            foreach ($sslcz_visa as $gw_value) {
                                if ($gw_value == 'dbbl_visa') {
                                    //$options['cards'][0]['name'] = "DBBL VISA";
                                    //$options['cards'][0]['link'] =  "<a class='hvr-pop' href='".$this->sslc_data['redirectGatewayURL']."dbbl_visa'><img style='width:60px; height:60px' src='".$this->_get_image("dbbl_visa", $this->sslc_data)."' alt='dbbl_visa'/></a>";
                                }
                                if ($gw_value == 'brac_visa') {
                                    //$options['cards'][1]['name'] = "BRAC VISA";
                                    //$options['visa'][1]['link'] =  "<a class='hvr-pop' href='".$this->sslc_data['redirectGatewayURL']."brac_visa'><img style='width:60px; height:60px' src='".$this->_get_image("brac_visa", $this->sslc_data)."' alt='brac_visa'/></a>";
                                }
                                if ($gw_value == 'city_visa') {
                                    //$options['cards'][2]['name'] = "CITY VISA";
                                    //$options['cards'][2]['link'] =  "<a class='hvr-pop' href='".$this->sslc_data['redirectGatewayURL']."city_visa'><img style='width:60px; height:60px' src='".$this->_get_image("city_visa", $this->sslc_data)."' alt='city_visa'/></a>";
                                }
                                if ($gw_value == 'ebl_visa') {
                                    //$options['cards'][3]['name'] = "EBL VISA";
                                    //$options['cards'][3]['link'] =  "<a class='hvr-pop' href='".$this->sslc_data['redirectGatewayURL']."ebl_visa'><img style='width:60px; height:60px' src='".$this->_get_image("ebl_visa", $this->sslc_data)."' alt='ebl_visa'/></a>";
                                }
                                if ($gw_value == 'visacard') {
                                    $options['cards'][4]['name'] = "VISA";
                                    $options['cards'][4]['link'] = "<a class='hvr-pop' href='" . $this->sslc_data['redirectGatewayURL'] . "visacard'><img style='width:60px; height:60px' src='" . $this->_get_image("visacard", $this->sslc_data) . "' alt='visacard'/></a>";
                                }
                            }
                        } # END OF VISA

                        # MASTER GATEWAY
                        if (isset($this->sslc_data['gw']['master']) && $this->sslc_data['gw']['master'] != "") {
                            $sslcz_visa = explode(",", $this->sslc_data['gw']['master']);
                            foreach ($sslcz_visa as $gw_value) {
                                if ($gw_value == 'dbbl_master') {
                                    //$options['cards'][5]['name'] = "DBBL MASTER";
                                    //$options['cards'][5]['link'] =  "<a class='hvr-pop' href='".$this->sslc_data['redirectGatewayURL']."dbbl_master'><img style='width:60px; height:60px' src='".$this->_get_image("dbbl_master", $this->sslc_data)."' alt='dbbl_master'/></a>";
                                }
                                if ($gw_value == 'brac_master') {
                                    //$options['cards'][6]['name'] = "BRAC MASTER";
                                    //$options['master'][6]['link'] =  "<a class='hvr-pop' href='".$this->sslc_data['redirectGatewayURL']."brac_master'><img style='width:60px; height:60px' src='".$this->_get_image("brac_master", $this->sslc_data)."' alt='brac_master'/></a>";
                                }
                                if ($gw_value == 'city_master') {
                                    //$options['cards'][7]['name'] = "CITY MASTER";
                                    //$options['cards'][7]['link'] =  "<a class='hvr-pop' href='".$this->sslc_data['redirectGatewayURL']."city_master'><img style='width:60px; height:60px' src='".$this->_get_image("city_master", $this->sslc_data)."' alt='city_master'/></a>";
                                }
                                if ($gw_value == 'ebl_master') {
                                    //$options['cards'][8]['name'] = "EBL MASTER";
                                    //$options['cards'][8]['link'] =  "<a class='hvr-pop' href='".$this->sslc_data['redirectGatewayURL']."ebl_master'><img style='width:60px; height:60px' src='".$this->_get_image("ebl_master", $this->sslc_data)."' alt='ebl_master'/></a>";
                                }
                                if ($gw_value == 'mastercard') {
                                    $options['cards'][9]['name'] = "MASTER";
                                    $options['cards'][9]['link'] = "<a class='hvr-pop' href='" . $this->sslc_data['redirectGatewayURL'] . "mastercard'><img style='width:60px; height:60px' src='" . $this->_get_image("mastercard", $this->sslc_data) . "' alt='mastercard'/></a>";
                                }
                            }
                        } # END OF MASTER


                        # AMEX GATEWAY
                        if (isset($this->sslc_data['gw']['amex']) && $this->sslc_data['gw']['amex'] != "") {
                            $sslcz_visa = explode(",", $this->sslc_data['gw']['amex']);
                            foreach ($sslcz_visa as $gw_value) {
                                if ($gw_value == 'city_amex') {
                                    $options['cards'][10]['name'] = "AMEX";
                                    $options['cards'][10]['link'] = "<a class='hvr-pop' href='" . $this->sslc_data['redirectGatewayURL'] . "city_amex'><img style='width:60px; height:60px' src='" . $this->_get_image("city_amex", $this->sslc_data) . "' alt='city_amex'/></a>";
                                }

                            }
                        } # END OF AMEX


                        # OTHER CARDS GATEWAY
                        if (isset($this->sslc_data['gw']['othercards']) && $this->sslc_data['gw']['othercards'] != "") {
                            $sslcz_visa = explode(",", $this->sslc_data['gw']['othercards']);
                            foreach ($sslcz_visa as $gw_value) {
                                if ($gw_value == 'dbbl_nexus') {
                                    $options['others'][0]['name'] = "NEXUS";
                                    $options['others'][0]['link'] = "<a class='hvr-pop' href='" . $this->sslc_data['redirectGatewayURL'] . "dbbl_nexus'><img style='width:60px; height:60px' src='" . $this->_get_image("dbbl_nexus", $this->sslc_data) . "' alt='dbbl_nexus'/></a>";
                                }

                                if ($gw_value == 'qcash') {
                                    $options['others'][1]['name'] = "QCASH";
                                    $options['others'][1]['link'] = "<a class='hvr-pop' href='" . $this->sslc_data['redirectGatewayURL'] . "qcash'><img style='width:60px; height:60px' src='" . $this->_get_image("qcash", $this->sslc_data) . "' alt='qcash'/></a>";
                                }

                                if ($gw_value == 'fastcash') {
                                    $options['others'][2]['name'] = "FASTCASH";
                                    $options['others'][2]['link'] = "<a class='hvr-pop' href='" . $this->sslc_data['redirectGatewayURL'] . "fastcash'><img style='width:60px; height:60px' src='" . $this->_get_image("fastcash", $this->sslc_data) . "' alt='fastcash'/></a>";
                                }
                            }
                        } # END OF OTHER CARDS

                        # INTERNET BANKING GATEWAY
                        if (isset($this->sslc_data['gw']['internetbanking']) && $this->sslc_data['gw']['internetbanking'] != "") {
                            $sslcz_visa = explode(",", $this->sslc_data['gw']['internetbanking']);
                            foreach ($sslcz_visa as $gw_value) {
                                if ($gw_value == 'city') {
                                    $options['internet'][0]['name'] = "CITYTOUCH";
                                    $options['internet'][0]['link'] = "<a class='hvr-pop' href='" . $this->sslc_data['redirectGatewayURL'] . "city'><img style='width:60px; height:60px' src='" . $this->_get_image("city", $this->sslc_data) . "' alt='city'/></a>";
                                }

                                if ($gw_value == 'bankasia') {
                                    $options['internet'][1]['name'] = "BANK ASIA";
                                    $options['internet'][1]['link'] = "<a class='hvr-pop' href='" . $this->sslc_data['redirectGatewayURL'] . "bankasia'><img style='width:60px; height:60px' src='" . $this->_get_image("bankasia", $this->sslc_data) . "' alt='bankasia'/></a>";
                                }

                                if ($gw_value == 'ibbl') {
                                    $options['internet'][2]['name'] = "IBBL";
                                    $options['internet'][2]['link'] = "<a class='hvr-pop' href='" . $this->sslc_data['redirectGatewayURL'] . "ibbl'><img style='width:60px; height:60px' src='" . $this->_get_image("ibbl", $this->sslc_data) . "' alt='ibbl'/></a>";
                                }

                                if ($gw_value == 'mtbl') {
                                    $options['internet'][3]['name'] = "MTBL";
                                    $options['internet'][3]['link'] = "<a class='hvr-pop' href='" . $this->sslc_data['redirectGatewayURL'] . "mtbl'><img style='width:60px; height:60px' src='" . $this->_get_image("mtbl", $this->sslc_data) . "' alt='mtbl'/></a>";
                                }
                            }
                        } # END OF INTERNET BANKING

                        # MOBILE BANKING GATEWAY
                        if (isset($this->sslc_data['gw']['mobilebanking']) && $this->sslc_data['gw']['mobilebanking'] != "") {
                            $sslcz_visa = explode(",", $this->sslc_data['gw']['mobilebanking']);
                            foreach ($sslcz_visa as $gw_value) {
                                if ($gw_value == 'dbblmobilebanking') {
                                    $options['mobile'][0]['name'] = "DBBL MOBILE BANKING";
                                    $options['mobile'][0]['link'] = "<a class='hvr-pop' href='" . $this->sslc_data['redirectGatewayURL'] . "dbblmobilebanking'><img style='width:60px; height:60px' src='" . $this->_get_image("dbblmobilebanking", $this->sslc_data) . "' alt='dbblmobilebanking'/></a>";
                                }

                                if ($gw_value == 'bkash') {
                                    $options['mobile'][1]['name'] = "Bkash";
                                    $options['mobile'][1]['link'] = "<a class='hvr-pop' href='" . $this->sslc_data['redirectGatewayURL'] . "bkash'><img style='width:60px; height:60px' src='" . $this->_get_image("bkash", $this->sslc_data) . "' alt='bkash'/></a>";
                                }

                                if ($gw_value == 'abbank') {
                                    $options['mobile'][2]['name'] = "AB Direct";
                                    $options['mobile'][2]['link'] = "<a class='hvr-pop' href='" . $this->sslc_data['redirectGatewayURL'] . "abbank'><img style='width:60px; height:60px' src='" . $this->_get_image("abbank", $this->sslc_data) . "' alt='abbank'/></a>";
                                }

                                if ($gw_value == 'ibbl') {
                                    $options['mobile'][3]['name'] = "IBBL";
                                    $options['mobile'][3]['link'] = "<a class='hvr-pop' href='" . $this->sslc_data['redirectGatewayURL'] . "ibbl'><img style='width:60px; height:60px' src='" . $this->_get_image("ibbl", $this->sslc_data) . "' alt='ibbl'/></a>";
                                }

                                if ($gw_value == 'mycash') {
                                    $options['mobile'][4]['name'] = "MYCASH";
                                    $options['mobile'][4]['link'] = "<a class='hvr-pop' href='" . $this->sslc_data['redirectGatewayURL'] . "mycash'><img style='width:60px; height:60px' src='" . $this->_get_image("mycash", $this->sslc_data) . "' alt='mycash'/></a>";
                                }

                                if ($gw_value == 'ific') {
                                    $options['mobile'][5]['name'] = "IFIC";
                                    $options['mobile'][5]['link'] = "<a class='hvr-pop' href='" . $this->sslc_data['redirectGatewayURL'] . "ific'><img style='width:60px; height:60px' src='" . $this->_get_image("ific", $this->sslc_data) . "' alt='ific'/></a>";
                                }
                            }
                        } # END OF MOBILE BANKING

                        return $options;
                    }

                } else {

                    $this->error = "Invalid Credential!";
                    return $this->error;
                }

            } else {
                $this->error = "Connectivity Issue. Please contact your sslcommerz manager";
                return $this->error;
            }
        } else {
            $msg = "Please provide a valid information list about transaction with transaction id, amount, success url, fail url, cancel url, store id and pass at least";
            $this->error = $msg;
            return false;
        }

    }

    public function orderValidate($trx_id = '', $amount = 0, $currency = "BDT", $post_data)
    {
        if ($post_data == '' && $trx_id == '' && !is_array($post_data)) {
            $this->error = "Please provide valid transaction ID and post request data";
            return $this->error;
        }
        $validation = $this->validate($trx_id, $amount, $currency, $post_data);
        if ($validation) {
            return true;
        } else {
            return false;
        }
    }

    # SEND CURL REQUEST
    protected function sendRequest($data)
    {


        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $this->sslc_submit_url);
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

        if (SSLCZ_IS_LOCAL_HOST) {
            curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        } else {
            curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, true);
        }


        $content = curl_exec($handle);


        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        if ($code == 200 && !(curl_errno($handle))) {
            curl_close($handle);
            $sslcommerzResponse = $content;

            # PARSE THE JSON RESPONSE
            $this->sslc_data = json_decode($sslcommerzResponse, true);
            return $this;
        } else {
            curl_close($handle);
            $msg = "FAILED TO CONNECT WITH SSLCOMMERZ API";
            $this->error = $msg;
            return false;
        }
    }

    # SET SSLCOMMERZ PAYMENT MODE - LIVE OR TEST
    protected function setSSLCommerzMode($test)
    {
        if ($test) {
            $this->sslc_mode = "sandbox";
        } else {
            $this->sslc_mode = "securepay";
        }
    }

    # VALIDATE SSLCOMMERZ TRANSACTION
    protected function validate($merchant_trans_id, $merchant_trans_amount, $merchant_trans_currency, $post_data)
    {
        # MERCHANT SYSTEM INFO
        if ($merchant_trans_id != "" && $merchant_trans_amount != 0) {

            # CALL THE FUNCTION TO CHECK THE RESUKT
            $post_data['store_id'] = $this->store_id;
            $post_data['store_pass'] = $this->store_pass;

            if ($this->SSLCOMMERZ_hash_varify($this->store_pass, $post_data)) {

                $val_id = urlencode($post_data['val_id']);
                $store_id = urlencode($this->store_id);
                $store_passwd = urlencode($this->store_pass);
                $requested_url = ($this->sslc_validation_url . "?val_id=" . $val_id . "&store_id=" . $store_id . "&store_passwd=" . $store_passwd . "&v=1&format=json");

                $handle = curl_init();
                curl_setopt($handle, CURLOPT_URL, $requested_url);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

                if (SSLCZ_IS_LOCAL_HOST) 
                {
                    curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
                } 
                else 
                {
                    curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, true);
                    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, true);
                }


                $result = curl_exec($handle);

                $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

                if ($code == 200 && !(curl_errno($handle))) {

                    # TO CONVERT AS ARRAY
                    # $result = json_decode($result, true);
                    # $status = $result['status'];

                    # TO CONVERT AS OBJECT
                    $result = json_decode($result);
                    $this->sslc_data = $result;

                    # TRANSACTION INFO
                    $status = $result->status;
                    $tran_date = $result->tran_date;
                    $tran_id = $result->tran_id;
                    $val_id = $result->val_id;
                    $amount = $result->amount;
                    $store_amount = $result->store_amount;
                    $bank_tran_id = $result->bank_tran_id;
                    $card_type = $result->card_type;
                    $currency_type = $result->currency_type;
                    $currency_amount = $result->currency_amount;

                    # ISSUER INFO
                    $card_no = $result->card_no;
                    $card_issuer = $result->card_issuer;
                    $card_brand = $result->card_brand;
                    $card_issuer_country = $result->card_issuer_country;
                    $card_issuer_country_code = $result->card_issuer_country_code;

                    # API AUTHENTICATION
                    $APIConnect = $result->APIConnect;
                    $validated_on = $result->validated_on;
                    $gw_version = $result->gw_version;

                    # GIVE SERVICE
                    if ($status == "VALID" || $status == "VALIDATED") {
                        if ($merchant_trans_currency == "BDT") {
                            if (trim($merchant_trans_id) == trim($tran_id) && (abs($merchant_trans_amount - $amount) < 1) && trim($merchant_trans_currency) == trim('BDT')) {
                                return true;
                            } else {
                                # DATA TEMPERED
                                $this->error = "Data has been tempered";
                                return false;
                            }
                        } else {
                            //echo "trim($merchant_trans_id) == trim($tran_id) && ( abs($merchant_trans_amount-$currency_amount) < 1 ) && trim($merchant_trans_currency)==trim($currency_type)";
                            if (trim($merchant_trans_id) == trim($tran_id) && (abs($merchant_trans_amount - $currency_amount) < 1) && trim($merchant_trans_currency) == trim($currency_type)) {
                                return true;
                            } else {
                                # DATA TEMPERED
                                $this->error = "Data has been tempered";
                                return false;
                            }
                        }
                    } else {
                        # FAILED TRANSACTION
                        $this->error = "Failed Transaction";
                        return false;
                    }
                } else {
                    # Failed to connect with SSLCOMMERZ
                    $this->error = "Faile to connect with SSLCOMMERZ";
                    return false;
                }
            } else {
                # Hash validation failed
                $this->error = "Hash validation failed";
                return false;
            }
        } else {
            # INVALID DATA
            $this->error = "Invalid data";
            return false;
        }
    }

    # FUNCTION TO CHECK HASH VALUE
    protected function SSLCOMMERZ_hash_varify($store_passwd = "", $post_data)
    {

        if (isset($post_data) && isset($post_data['verify_sign']) && isset($post_data['verify_key'])) {
            # NEW ARRAY DECLARED TO TAKE VALUE OF ALL POST
            $pre_define_key = explode(',', $post_data['verify_key']);

            $new_data = array();
            if (!empty($pre_define_key)) {
                foreach ($pre_define_key as $value) {
                    if (isset($post_data[$value])) {
                        $new_data[$value] = ($post_data[$value]);
                    }
                }
            }
            # ADD MD5 OF STORE PASSWORD
            $new_data['store_passwd'] = md5($store_passwd);

            # SORT THE KEY AS BEFORE
            ksort($new_data);

            $hash_string = "";
            foreach ($new_data as $key => $value) {
                $hash_string .= $key . '=' . ($value) . '&';
            }
            $hash_string = rtrim($hash_string, '&');

            if (md5($hash_string) == $post_data['verify_sign']) {

                return true;

            } else {
                $this->error = "Verification signature not matched";
                return false;
            }
        } else {
            $this->error = 'Required data mission. ex: verify_key, verify_sign';
            return false;
        }
    }

    # FUNCTION TO GET IMAGES FROM WEB
    protected function _get_image($gw = "", $source = array())
    {
        $logo = "";
        if (!empty($source) && isset($source['desc'])) {

            foreach ($source['desc'] as $key => $volume) {

                if (isset($volume['gw']) && $volume['gw'] == $gw) {

                    if (isset($volume['logo'])) {
                        $logo = str_replace("/gw/", "/gw1/", $volume['logo']);
                        break;
                    }
                }
            }
            return $logo;
        } else {
            return "";
        }
    }

    public function getResultData()
    {
        return $this->sslc_data;
    }
}