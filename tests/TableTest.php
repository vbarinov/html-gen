<?php

use HtmlGen\Facades\Table;
use HtmlGen\Generators\HtmlTableInputGenerator;
use HtmlGen\Input\JSONInput;
use HtmlGen\Entities\HtmlTable;
use HtmlGen\Markup;

class TableTest extends PHPUnit_Framework_TestCase
{
	public function testFacadeCreatesProperTable()
	{
		$table = Table::create();

		$this->assertInstanceOf('HtmlGen\Entities\HtmlTable', $table);
	}

	public function testCanCreateTableWithAttributes()
	{
		$table_markup = Table::create(array("id" => "phpunit"))->__toString();

		$expected_markup = '<table id="phpunit"></table>' . PHP_EOL;

		$this->assertEquals($expected_markup, $table_markup, "Can't render table with attributes");
	}

	public function testCanCreateTableWithManyChildren()
	{
		$table_markup = Table::create()->tr()->td("Hai!")->up()->up()
							->tr()->td()->up()->td()->__toString();

		$expected_markup = 
			'<table><tr><td>Hai!</td></tr><tr><td></td><td></td></tr></table>'  . PHP_EOL;

		$this->assertEquals($expected_markup, $table_markup);
	}

	public function testMarkupDetectsHtml()
	{
		$markup = new Markup();

		$html = "Okay <strong>Yay!</strong>";
		$non_html = "Multiton' sucks";

		$this->assertTrue($markup->detectHtml($html));
		$this->assertFalse($markup->detectHtml($non_html));
	}

	public function testCanCreateCellWithHtmlContent()
	{
		$table_markup = Table::create()->tr()->td("<p class='lead'>Lorem</p>")->__toString();

		$expected_markup = '<table><tr><td><p class="lead">Lorem</p></td></tr></table>' . PHP_EOL;

		$this->assertEquals($expected_markup, $table_markup);
	}

	public function testItCanParseJSONFromFile()
	{
		$input = new JSONInput('public/phones.json');

		$raw = $input->readData();

		$expected_raw = file_get_contents(APP_ROOT . 'public/phones.json');

		$this->assertJsonStringEqualsJsonString($expected_raw, $raw);
	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Can't find input data
	 */
	public function testItThrowsErrorJSONFileNotFound()
	{
		$input = new JSONInput('foo.json');

		$raw = $input->readData();
	}

	/**
	 * @expectedException Exception
	 */
	public function testItThrowsErrorWithMalformedJSON()
	{
		$malformed_json = '{ "foo": "1". "bar"; 2}';

		$input = new JSONInput();
		$input->setRaw($malformed_json);
		$input->readData();
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testFailsToGenerateTableFromString()
	{
		$table = (new HtmlTableInputGenerator())->generateFrom('foo.json');
	}
}