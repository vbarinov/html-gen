<?php
/**
 * Test client.
 *
 * @todo do some grid and layout
 * @author Vlad Barinov <vvbarinov@gmail.com>
 */

require_once __DIR__ . '/../vendor/autoload.php';

use HtmlGen\Facades\Table;
use HtmlGen\Input\JSONInput;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>HtmlGen</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="public/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<h1>HtmlGen</h1>
		<div class="row">
			<div class="col-md-3">
				<h3>Table</h3>
				<p>Use <code>Table::create([])</code> to create table and chain tags to add rows and columns: </p>
				<p><code>Table::create(["class" => "table"])->tr()->td("Hi!")</code></p>
				
				<p>Use <code>echo Table::from(new JSONInput('phones.json'))</code> to generate table from JSON data.</p>
			</div>

			<div class="col-md-9">
				<?php
					echo Table::from(new JSONInput("phones.json"));			
				?>
			</div>
			
		</div>	
	</div>
	
	
</body>
</html>