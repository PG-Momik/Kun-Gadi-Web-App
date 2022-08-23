<?php

class CURL
{
    public ?string $base = 'http://localhost/NewGadi/index.php?';
    public ?string $en = 'en=';
    public ?string $op = '&op=';
    public ?string $url = '';
    public ?string $params = '';
    public array $options;
    public $ch;

    public function __construct($en, $op, $params=null)
    {
        $this->ch = curl_init();
        $this->en = $this->en . $en;
        $this->op = $this->op . $op;
        $this->params = json_encode($params);
    }

    public function ready(): void
    {
        $this->url = $this->base . $this->en . $this->op;
        $this->options = array(
            CURLOPT_URL => $this->url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $this->params,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-Type: : application/json')
        );

            curl_setopt_array($this->ch, $this->options);
    }

    public function execute()
    {
        return curl_exec($this->ch);
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }
}


//$curlResult = '';
//$ch = curl_init();
//$url = "https://localhost/NewGadi/index.php?op=users&en=login";
//$params = array('phone'=>$phone, 'password'=>$password);
//$params = json_encode($params);
//$options = array(
//    CURLOPT_URL => $url,
//    CURLOPT_POST => true,
//    CURLOPT_POSTFIELDS => $params,
//    CURLOPT_RETURNTRANSFER => true,
//    CURLOPT_HTTPHEADER => array('Content-Type: : application/json')
//);
//curl_setopt_array($ch, $options);
//$response = curl_exec($ch);
//curl_close($ch);