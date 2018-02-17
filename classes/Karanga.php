<?php
class Karanga {
	private $user=array();
	private $pass=array();
	private $url=array();
	private $api_url=array();

	private function connect($api_url,$user,$pass,$url)
	{
		$this->user=$user;
		$this->pass=$pass;
		$this->api_url=$api_url;
		$this->url=$url;
	}

	public function article_list($api_url,$user,$pass,$url,$preview=0)
	{
		$this->connect($api_url,$user,$pass,$url,$preview);
		
		if ($preview)
			return $this->getdata('list',array('preview'=>$preview));
		else
			return $this->getdata('list');
	}

	public function article_detail($api_url,$user,$pass,$url,$id)
	{
		$this->connect($api_url,$user,$pass,$url);
		return $this->getdata('article',array('id'=>$id));
	}	

	public function gallery_list($api_url,$user,$pass)
	{
		//var_dump($api_url, $user, $pass); exit;
		$this->connect($api_url,$user,$pass,NULL);
		return $this->getdata('gallerys');
	}	

	public function check($api_url,$user,$pass)
	{
		$this->connect($api_url,$user,$pass,'');
		return $this->getdata('check');
	}	

	private function getdata($url,$data=array())
	{
		$result=array('header'=>'','result'=>'','error'=>'');
    
    $header='Authorization: Basic '.base64_encode($this->user.':'.$this->pass)."\r\n";
    $header.='Content-Type: application/x-www-form-urlencoded';
		
	  $params = array('http' => array(
      'method' => 'POST', // /HTTP/1.1
      'header'=> $header,
      'content' => http_build_query(array_merge($data,array('url'=>$this->url))),
      'ignore_errors' => true,
    ));

	  $ctx = stream_context_create($params);
	  $http_response_header=array();
	  
	  $result = @file_get_contents($this->api_url.$url, false, $ctx);
	 // var_dump($result); exit;
	  if ($result===false) 
	  	return $this->error(0);
		
		$return_code = @explode(' ', $http_response_header[0]);
    $return_code = (int)$return_code[1];
			
		if ($return_code!=200)
			return $this->error($return_code);
		
		return json_decode($result,true);
	}

	private function error($code)
	{
		$text=Array(
			'unknown'=>'unknown error',
			0=>'cant connect',
			204=>'outfits not live',
			401=>'authorization error',
			403=>'gallery not live',
			404=>'url not found',
			500=>'server error',
		);

		if (!isset($text[$code]))	
			return array(
				'error'=>$code,
				'error_text'=>$text['unknown'],
			);	
			
		return array(
			'error'=>$code,
			'error_text'=>$text[$code],
		);	
	}
}
?>