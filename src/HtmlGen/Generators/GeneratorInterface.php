<?php
/**
 * @author Vlad Barinov <vvbarinov@gmail.com>
 */

namespace HtmlGen\Generators;

use HtmlGen\Input\InputInterface;

/**
 * Contract for HTML generators
 * @todo  Some format restrictions?
 */
interface GeneratorInterface
{
	/** Direct data processing to internal format */
	public function generateFrom($input);

	/** Yield string form of generated entity */
	public function display();

	/** Build entity */
	public function build();
}