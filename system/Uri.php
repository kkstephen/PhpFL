<?php  if ( ! defined('APP_PATH')) exit('No direct script access allowed');

// CodeIgniter i18n library by Jérôme Jaglale
// http://maestric.com/en/doc/php/codeigniter_i18n
// version 10 - May 10, 2012
// Modify: Stephen Yeung, 2014-06
 
class Uri {

	/**************************************************
	 configuration
	***************************************************/
	var $cfg;

	// languages
	var $languages;

	var $uri_string;
	
	// special URIs (not localized)
	var $special;
	
	public $segments;
		 
	/**************************************************/
	
	function __construct($config)
	{
		$this->cfg = $config;
		
		$this->languages = $this->cfg['i18n'];
		//$this->special = $this->config->item('special_url');			
	}
	
	function set_uri($url)
	{    
		$pos = strpos($url, '?');
		
        $this->uri_string = $pos === false ? $url : substr($url, 0, $position);
	
		$this->segments = explode('/', $this->uri_string);
		
		array_shift($this->segments);
	}
			
	// is there a language segment in this $uri?
	function has_language()
	{
		$first_segment = $this->segments[0];	
		
		return isset($this->languages[$first_segment]);
	}
	
	// get current language
	// ex: return 'en' if language is 'english' 
	function lang()
	{	 		
		if ($this->has_language()) {
			$language = $this->languages[$this->segments[0]]; 
		 		
			if (isset($language)) {
				$lang = array_search($language, $this->languages);
				
				if ($lang)
				{
					return $lang;
				}
			}
		}
		
		return NULL;	// this should not happen
	}
	
	function is_special()
	{ 
		if (in_array($this->segments[0], $this->special))
		{
			return TRUE;
		}
		 
		return FALSE;
	}
	
	function switch_uri($lang)
	{ 
		$uri = $this->uri_string;
		
		if ($this->has_language())
		{
			if ($lang != $this->lang())
			{
				$this->segments[0] = $lang;
			}
			
			$uri = implode('/', $this->segments);
		}
		else {
			$uri = $lang;
		}
		
		return $uri;
	}

	
	// default language: first element of $this->languages
	function default_lang()
	{
		return $this->cfg['default'];
	}
	
	function set_lang($uri_lang)
	{ 
		$language = $this->languages[$uri_lang];
		//$this->config->set_item('language', $language);		 
	}
	
	// add language segment to $uri (if appropriate)
	function localized()
	{
		if($this->has_language()
				|| $this->is_special()
				|| preg_match('/(.+)\.[a-zA-Z0-9]{2,4}$/', $this->uri_string))
		{
			// we don't need a language segment because:
			// - there's already one or
			// - it's a special uri (set in $special) or
			// - that's a link to a file
		}
		else
		{
			$uri = $this->lang() . '/' .  $this->uri_string;
		}
		
		return $uri;
	}	
	
	private function isNULLorEmpty($str) 
	{
		return !isset($str) || empty($str);
	}
}
