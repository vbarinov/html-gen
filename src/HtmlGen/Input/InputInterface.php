<?php
/**
 * @author Vlad Barinov <vvbarinov@gmail.com>
 */

namespace HtmlGen\Input;

/**
 * Interface for input types.
 */
interface InputInterface
{
	/** Process input to internal data structure */
	public function process();

	/** For manual input assigning */
	public function setRaw($data);
}