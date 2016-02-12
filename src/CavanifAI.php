<?php

namespace CavanifAI;

class CavanifAI
{

		private $clarifaiContext;

    /**
     * Create a new CavanifAI Instance
     */
    public function __construct($client_id, $client_secret, $version = 'v1')
    {
			
			$this->context = new ClarifaiContext($client_id, $client_secret, $version);
						
    }

    /**
     * Tag an image
     */
    public function tag($url)
    {
        return $this->context->call('tag', array('url' => urlencode($url)))
    }
}
