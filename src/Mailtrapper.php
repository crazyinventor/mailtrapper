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

	protected function buildUrl($path)
	{
		return $this->url
				. $path
				. $this->format
				. '?api_token='
				. $this->token;
	}

	protected function process($url)
	{
		return json_decode(
				file_get_contents($url),
				true
		);
	}

}
