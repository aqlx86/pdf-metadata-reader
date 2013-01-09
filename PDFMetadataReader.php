<?php
/**
 * Class for reading pdf meta data
 *
 * @link https://github.com/aqlx86/pdf-metadata-reader
 * @author Arnel Labarda <aqlx86@gmail.com>
 */
class PDFMetadataReader {
	
	protected $binary = '/usr/bin/pdfinfo';

	protected $info;

	public static function factory($path)
	{
		return new PDFMetadataReader($path);
	}

	public function __construct($path)
	{
		exec($this->binary.' -meta '.$path, $output);

		$this->_parse_output($output);
	}

	protected function _parse_output($output)
	{
		foreach($output as $info)
		{
			list($k, $v) = explode(':', $info);

			$this->info[$k] = trim($v);
		}

		// parse keywords
		if(isset($this->info['Keywords']))
		{
			$keywords = array();

			foreach(explode(';', $this->info['Keywords']) as $keyword)
			{
				if($keyword != '')
				{
					list($key_name, $key_value) = explode('=', $keyword);

					$keywords[trim($key_name)] = trim($key_value);					
				}

			}

			$this->info['Keywords'] = $keywords;
		}
	}

	public function info()
	{
		return $this->info;
	}

	public function __get($key)
	{
		if(isset($this->info[$key]))
		{
			return $this->info[$key];
		}
		elseif (isset($this->info['Keywords'][$key])) 
		{
			return $this->info['Keywords'][$key];
		}

		return NULL;
	}
}