<?php
/**
 * @author Vlad Barinov <vvbarinov@gmail.com>
 */

namespace HtmlGen\Facades;

use HtmlGen\Entities\HtmlTable;
use HtmlGen\Generators\HtmlTableInputGenerator;

/**
 * Class provides handy interface for table manipulation.
 */
class Table extends Facade
{
	/** @var \HtmlGen\Entities\HtmlTable The table */
	protected static $table;

	/**
	 * Create new instance of table with optional attributes.
	 * 
	 * @param  array  $attributes Optional HTML attributes
	 * @return \HtmlGen\Entities\HtmlTable Table instance
	 */
	public static function create($attributes = array())
	{
		static::$table = new HtmlTable($attributes);

		return static::$table;
	}

	/**
	 * Tries to generate table markup from input.
	 * @param object $input Input wrapper {@see HtmlGen\Input\InputInterface}
	 * @return \HtmlGen\Entities\HtmlTable Generated table instance
	 */
	public static function from($input)
	{
		try {
			return (new HtmlTableInputGenerator())->generateFrom($input);	
		} catch (\InvalidArgumentException $e) {
			die($e->getMessage());
		}
	}

	/**
	 * Query table instance for string representation.
	 * 
	 * @return string Table markup
	 */
	public function __toString()
	{
		return static::$table->__toString();
	}
}