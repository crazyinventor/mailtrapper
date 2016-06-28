<?php

namespace CrazyInventor;

class Mailtrapper {

	protected $token;
	protected $url = 'https://mailtrap.io/api/v1/';
	protected $format = '';

	public function __construct($api_token, $format = false)
	{
		$this->token=$api_token;
		if($format && in_array($format, ['json', 'xml'])) {
			$this->format = '.' . $format;
		}
	}

	public function getInboxes()
	{
		$url = $this->buildUrl('inboxes');
		return $this->process($url);
	}

	public function getMails($inbox_id)
	{
		$path = 'inboxes/'.$inbox_id.'/messages';
		$url = $this->buildUrl($path);
		return $this->process($url);
	}
	
	public function clearInbox($inbox_id){
        $path = 'inboxes/'.$inbox_id.'/clean';
        $url = $this->buildUrl($path);
        $context = stream_context_create(array('http'=>array(
            'method'=>"PATCH",
            'header' => 'Api-Token: '.$this->token)));
        return $this->process($url, $context);
    }

	protected function buildUrl($path)
    {
        return $this->url
        . $path
        . $this->format;
    }

	protected function process($url, $context = null)
    {
        if ($context==null)
            $context = stream_context_create(array('http'=>array(
                'method'=>"GET",
                'header' => 'Api-Token: '.$this->token)));
        return json_decode(
            file_get_contents($url, null, $context),
            true
        );
    }

}
