<?php
/**
 * @author Vlad Barinov <vvbarinov@gmail.com>
 */

namespace HtmlGen\Input;

/**
 * Represent JSON input.
 */
class JSONInput implements InputInterface
{
	/** @var string Path to JSON source */
	protected $inputPath;

	/** @var string|null|false Raw JSON data */
	protected $raw = NULL;

	/** @var array PHP array with decoded JSON */
	protected $output;

	/**
	 * Craft an object and set JSON path
	 * @param string $inputPath URI to JSON file
	 * @return JSONInput Object for chaining
	 */
	public function __construct($inputPath = NULL)
	{
		$this->inputPath = $inputPath;
	}

	/**
	 * Processing the JSON input.
	 *
	 * @throws \Exception If JSON error found
	 * @return array Processed output
	 */
	public function process()
	{
		if (!$this->raw) $this->readData();

		$this->output = json_decode($this->raw, TRUE);

		if (json_last_error() > 0) {
			 throw new \Exception($this->getErrorMessage());
		}

		return $this->output;
	}

	/**
	 * Read data from specified source.
	 *
	 * @throws \Exception If unable to open data source
	 * @return string Raw source data
	 */
	public function readData()
	{
		$this->raw = @file_get_contents($this->inputPath);

		if ($this->raw === FALSE) {
			throw new \Exception("Can't find input data");
		}

		return $this->raw;
	}

	/**
	 * Set raw JSON content.
	 * 
	 * @param string $json JSON string
	 */
	public function setRaw($json)
	{
		$this->raw = $json;
	}

	/**
	 * Get JSON error message from error code.
	 * 
	 * @return string Error message
	 */
	public function getErrorMessage()
	{
		switch (json_last_error()) {
	        case JSON_ERROR_NONE:
	            return 'Ошибок нет';
	        break;
	        case JSON_ERROR_DEPTH:
	            return 'JSON: Достигнута максимальная глубина стека';
	        break;
	        case JSON_ERROR_STATE_MISMATCH:
	            return 'JSON: Некорректные разряды или несовпадение режимов';
	        break;
	        case JSON_ERROR_CTRL_CHAR:
	            return 'JSON: Некорректный управляющий символ';
	        break;
	        case JSON_ERROR_SYNTAX:
	            return 'JSON: Синтаксическая ошибка, некорректный JSON';
	        break;
	        case JSON_ERROR_UTF8:
	            return 'JSON: Некорректные символы UTF-8, возможно неверная кодировка';
	        break;
	        default:
	            return 'JSON: Неизвестная ошибка';
	        break;
	    }
	}
}