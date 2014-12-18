<?php
/**
 * @author Vlad Barinov <vvbarinov@gmail.com>
 */

namespace HtmlGen\Facades;

use HtmlGen\Input\InputInterface;

/**
 * Abstract facade class
 */
abstract class Facade
{
	/** We don't want to create an instance */
	private final function __construct() {}

	/** Create handle */
	abstract public static function create();

	/** Create from data handle */
	abstract public static function from($input);
}