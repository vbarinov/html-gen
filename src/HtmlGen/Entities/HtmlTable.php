<?php
/**
 * @author Vlad Barinov <vvbarinov@gmail.com>
 */

namespace HtmlGen\Entities;

use HtmlGen\Markup;

/**
 * Html table entity.
 *
 * @uses HtmlGen\Markup Markup DOM implementation
 */
class HtmlTable
{
	/** @var HtmlGen\Markup Markup instance */
	private $markup;

	/**
	 * Creates markup instance and adds root table tag.
	 * 
	 * @param array $attributes Optional HTML attributes
	 */
	public function __construct($attributes = array())
	{
		$this->markup = new Markup;

		$this->markup->add('table', NULL, $attributes);
	}

	/**
	 * Rewinds to parent of the current markup tag.
	 * 
	 * @return HtmlTable Html table handle for chaining
	 */
	public function up()
	{
		$this->markup->getParent();

		return $this;
	}

	/**
	 * Adds ANY tag to the current markup tag.
	 *
	 * @param string $name Tag name
	 * @param array $args Tag value and tag attributes combined to array
	 * @return HtmlTable Handle for chaining
	 */
	private function addTag($name, $args)
	{
		call_user_func_array(
			array($this->markup, 'add'),
			array_merge(array($name), $args)
		);

		return $this;
	}

	/**
	 * Hooks to methods for tag addition.
	 *  
	 * @param  string $name Method name
	 * @param  array $args Method arguments
	 * @return HtmlTable Current object if hook fired
	 */
	public function __call($name, $args)
	{
		if (!in_array($name, array('up'))) {
			return $this->addTag($name, $args);
		}
	}

	/**
	 * Alias for __toString().
	 * 
	 * @return string String representation of markup
	 */
	public function display()
	{
		echo $this->__toString();
	}

	/**
	 * Converts table markup to string.
	 * 
	 * @return string String representation of markup
	 */
	public function __toString()
	{
		return $this->markup->__toString();
	}
}