<?php

namespace CrazyInventor;

class Mailtrapper {

	/**
	 * Token to authorize access
	 * @var string
	 */
	protected $token;

	/**
	 * URL of the Mailtrap API
	 * @var string
	 */
	protected $url = 'https://mailtrap.io/api/v1/';

	/**
	 * Desired format of response, accepted values are 'json' and 'xml'
	 * @var string
	 */
	protected $format = '';

	/**
	 * Mailtrapper constructor
	 * @param $api_token
	 * @param bool $format
	 */
	public function __construct($api_token, $format = false)
	{
		$this->token=$api_token;
		if($format && in_array($format, ['json', 'xml'])) {
			$this->format = '.' . $format;
		}
	}

	/**
	 * Get list of inboxes
	 * @return string
	 */
	public function getInboxes()
	{
		$url = $this->buildUrl('inboxes');
		return $this->process($url);
	}

    /**
     * Get raw HTML body of message
     * @param $inbox_id
     * @param $message_id
     * @return string
     */
    public function getRawHtmlBody($inbox_id, $message_id)
    {
        $path = '/api/v1/inboxes/'.$inbox_id.'/messages/'.$message_id.'/body.html';
        $url = $this->buildUrl($path);
        return $this->process($url);
    }

    /**
     * Get formated for view HTML body of message
     * @param $inbox_id
     * @param $message_id
     * @return string
     */
    public function getHtmlBody($inbox_id, $message_id)
    {
        $path = '/api/v1/inboxes/'.$inbox_id.'/messages/'.$message_id.'/body.htmlsource';
        $url = $this->buildUrl($path);
        return $this->process($url);
    }

    /**
     * Get text body of message
     * @param $inbox_id
     * @param $message_id
     * @return string
     */
    public function getTextBody($inbox_id, $message_id)
    {
        $path = '/api/v1/inboxes/'.$inbox_id.'/messages/'.$message_id.'/body.txt';
        $url = $this->buildUrl($path);
        return $this->process($url);
    }

    /**
     * Get raw body of message
     * @param $inbox_id
     * @param $message_id
     * @return string
     */
    public function getRawBody($inbox_id, $message_id)
    {
        $path = '/api/v1/inboxes/'.$inbox_id.'/messages/'.$message_id.'/body.raw';
        $url = $this->buildUrl($path);
        return $this->process($url);
    }

	/**
	 * Get mails by inbox ID
	 * @param $inbox_id
	 * @return string
	 */
	public function getMails($inbox_id)
	{
		$path = 'inboxes/'.$inbox_id.'/messages';
		$url = $this->buildUrl($path);
		return $this->process($url);
	}

	/**
	 * Delete all mails by inbox ID
	 * @param $inbox_id
	 * @return string
	 */
	public function clearInbox($inbox_id)
	{
		$path = 'inboxes/'.$inbox_id.'/clean';
		$url = $this->buildUrl($path);
		$context = stream_context_create([
			'http'=>[
				'method'=>"PATCH",
				'header' => 'Api-Token: '.$this->token
			]
		]);
		return $this->process($url, $context);
	}

	/**
	 * Delete mail by inbox ID and mail ID
	 * @param $inbox_id
	 * @param $message_id
	 * @return string
	 */
	public function deleteMessage($inbox_id, $message_id)
	{
		$path = 'inboxes/'.$inbox_id.'/messages/'.$message_id;
		$url = $this->buildUrl($path);
		$context = stream_context_create([
			'http'=>[
				'method'=>"DELETE",
				'header' => 'Api-Token: '.$this->token
			]
		]);
		return $this->process($url, $context);
	}

	/**
	 * Build an URL to send request to
	 * @param $path
	 * @return string
	 */
	protected function buildUrl($path)
	{
		return $this->url
		. $path
		. $this->format;
	}

	/**
	 * Send request to Mailtrap and return response
	 * @param $url
	 * @param null $context
	 * @return string
	 */
	protected function process($url, $context = null)
	{
		if ($context==null)
		{
		    $context = stream_context_create([
			    'http'=>[
			        'method'=>"GET",
			        'header' => 'Api-Token: '.$this->token
			    ]
		    ]);
		}
		return file_get_contents($url, null, $context);
	}
	
}

