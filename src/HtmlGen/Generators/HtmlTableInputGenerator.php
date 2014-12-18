<?php
/**
 * @author Vlad Barinov <vvbarinov@gmail.com>
 */

namespace HtmlGen\Generators;

use HtmlGen\Input\InputInterface;
use HtmlGen\Entities\HtmlTable;

/**
 * Generates HtmlTable from input
 */
class HtmlTableInputGenerator implements GeneratorInterface
{
	/** @var array Processed data */
	protected $data;

	/**
	 * Constructs HtmlTable.
	 * 
	 * @throws \InvalidArgumentException If Given wrong input
	 * @param  HtmlGen\Input\InputInterface $input Input wrapper
	 * @return HtmlGen\Entities\HtmlTable Builded table
	 */
	public function generateFrom($input)
	{
		if (!$input instanceof InputInterface) {
			throw new \InvalidArgumentException("Table input must implement InputInterface");
		}

		try {
			$this->data = $input->process();	
		} catch (\Exception $e) {
			die($e->getMessage());
		}
		
		return $this->build();
	}

	/**
	 * Builds the table cell by cell.
	 * 
	 * @return HtmlGen\Entities\HtmlTable Populated table
	 */
	public function build()
	{
		$this->table = new HtmlTable($this->data['attributes']);

		if ($this->data['caption']) 
			$this->table->caption($this->data['caption'])->up();

		if (sizeof($this->data['rows'])) {
			foreach ($this->data['rows'] as $k => $v) {
				$this->table->tr(NULL, $v['attributes']);

				if (sizeof($v['cols'])) {
					foreach ($v['cols'] as $c) {
						$this->table->td($c['value'], $c['attributes'])->up();
					}	
				}
				
				$this->table->up();
			}
		}

		return $this->table;
	}

	/**
	 * Displays the resulting table.
	 * 
	 * @return string Table markup
	 */
	public function display()
	{
		if ($this->table) echo $this->table->__toString();
	}
}