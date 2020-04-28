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
	
	var $segments;
		 
	/**************************************************/
	
	function __construct($config)
	{
		$this->cfg = $config;
		
		$this->languages = $this->cfg['i18n'];	
	}

	function get_segments($url)
	{    
		$pos = strpos($url, '?');
		
        $this->uri_string = $pos === false ? $url : substr($url, 0, $pos);
	
		$this->segments = explode('/', $this->uri_string);
		
		array_shift($this->segments);
		
		return $this->segments;
	}

	// is there a language segment in this $uri?
	function has_language()
	{
		if (is_special($this->segments[0])) {
			$lang_segment = $this->segments[1];	
		} else {
			$lang_segment = $this->segments[0];	
		}		
		
		return isset($this->languages[$lang_segment]);
	}
	
	function get_area() {
		if (is_special($this->segments[0])) {
			return $this->segments[0];
		}
		
		return "";
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
	
	// default language: first element of $this->languages
	function default_lang()
	{
		return $this->cfg['default'];
	}	 
}
