<?php
/**
 * @author Vlad Barinov <vvbarinov@gmail.com>
 */

namespace HtmlGen;

/**
 * Php DOMNode implementation of markup.
 */
class Markup
{
	/** @var \DOMNode Current node */
	protected $node;

	/** @var \DOMDocument Root node */
	protected $root;

	/**
	 * Init root and current nodes.
	 */
	public function __construct()
	{
		$this->root = $this->node = new \DOMDocument();
	}

	/**
	 * Add node to current node and forward to it.
	 * 
	 * @param string $name Node name
	 * @param string $value Optional node value (text or html)
	 * @param array  $attributes Optional node attributes
	 */
	public function add($name, $value = NULL, $attributes = array())
	{
		$html_value = NULL;

		if (is_array($value)) {
			// If attributes passed instead of value
			$attributes = $value;
			$value = NULL;
		} else if ($value !== NULL AND $this->detectHtml($value)) {
			// If node contains HTML markup
			$html_value = $value;
			$value = NULL;
		}

		$new_node = new \DOMElement($name, $value);

		$this->node = $this->node->appendChild($new_node);

		$this->setAttributes($attributes);

		$this->setHtmlContent($html_value);
	}

	/**
	 * Rewind to current's node parent if it exists.
	 */
	public function getParent()
	{
		if ($this->node->parentNode && is_a($this->node->parentNode, '\DOMElement')) {
			$this->node = $this->node->parentNode;	
		}
	}

	/**
	 * Set current's node attributes.
	 * 
	 * @param array $attributes Associative array of attributes
	 */
	private function setAttributes($attributes)
	{
		if (!$attributes || !is_array($attributes)) return;

		foreach ($attributes as $name => $value) {
			$this->node->setAttribute($name, $value);	
		}
	}

	/**
	 * Creates and appends html to current node.
	 * 
	 * @todo  Memory efficient?
	 * @param string $html HTML string
	 */
	private function setHtmlContent($html)
	{
		if ($html === NULL) return;

		$dom = new \DOMDocument;
		$html_fragment = $dom->createDocumentFragment();
		$html_fragment->appendXML($html);

		$this->node->appendChild($this->root->importNode($html_fragment, TRUE));
	}

	/**
	 * Attempts to detect HTML in given string.
	 * 
	 * @param  string $string Wanna be HTML
	 * @return bool         Whether HTML are found
	 */
	public function detectHtml($string)
	{
		if ($string AND $string != strip_tags($string))	return TRUE;
		return FALSE;
	}

	/**
	 * Uses DOMDocument to print HTML markup.
	 * 
	 * @return string HTML
	 */
	public function	__toString()
	{
		//$this->root->formatOutput = TRUE;
		return (string) $this->root->saveHtml();
	}
}