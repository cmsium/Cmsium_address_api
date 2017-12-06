<?php
class Request {

    private $url;

    public function __construct($url) {
        $this->url = $url;
    }

    public function sendRequestJSON($method,$header,$content) {
        $URL = $this->url;
        $options = ['http' => ['method' => $method, 'header' => $header]];
        if ($content) {
            $options['http']['content'] = $content;
        }
        $context = stream_context_create($options);
        $result = file_get_contents("$URL", false, $context);
        return json_decode($result,true);
    }

    public function sendRequest($method,$header,$content) {
        $URL = $this->url;
        $options = ['http' => ['method' => $method, 'header' => $header]];
        if ($content) {
            $options['http']['content'] = $content;
        }
        $context = stream_context_create($options);
        $result = file_get_contents("$URL", false, $context);
        return $result;
    }

    public function sendFileJSON($file_path,$file_name){
        $URL = $this->url;
        $mime = mime_content_type($file_path);
        $server = "$URL";
        $curl = curl_init($server);
        curl_setopt($curl, CURLOPT_POST, true);
        $data = ['userfile' => curl_file_create($file_path,$mime,$file_name)];
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        return json_decode(curl_exec($curl),true);
    }

}