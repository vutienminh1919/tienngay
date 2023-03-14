<?php

defined('BASEPATH') or exit('No direct script access allowed');

class SendEmailCheckPass {

	public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->config->load('config');
        $this->baseURL = $this->ci->config->item("corev2_mailer");
    }

    /*
    * Call create order api
    */
    public function call_api_module_mailer($data)
    {   
        $this->WriteLog("SendEmailCheckPass" . date("Ymd", time()) . ".txt", " check pass data " . json_encode($data));
        $service = $this->baseURL . '/sendEmailCheckPass';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $service);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($result, true);
        $this->WriteLog("SendEmailCheckPass" . date("Ymd", time()) . ".txt", " check pass response " . json_encode($response));
        return $response;
    }

    public function WriteLog($fileName,$data,$breakLine=true,$addTime=true) {
		$fp = fopen("log/".$fileName,'a');
		if ($fp)
		{
			if ($breakLine)
			{
				if ($addTime)
					$line = date("H:i:s, d/m/Y:  ",time()).$data. " \n";
				else
					$line = $data. " \n";
			}
			else
			{
				if ($addTime)
					$line = date("H:i:s, d/m/Y:  ",time()).$data;
				else
					$line = $data;
			}
			fwrite($fp,$line);
			fclose($fp);
		}
	}
}