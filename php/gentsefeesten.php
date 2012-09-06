<html>
	<head>
		<title>Open Data Ghent: PHP</title>
	</head>
	<body>
	<h1>Gentse Feesten</h1>
	<p> This example downloads a CSV file from <span class="quote">http://data.appsforghent.be/gentsefeesten/20120723.csv</span>, parses it, groups the events by the "street" column, and returns the number of events by street in a JSON format. You can view the original file in a table  <a href="http://data.appsforghent.be/gentsefeesten/20120723.about">here</a>.
	</p>
	<?php
	
	/**
	 * Very simple CSV parsing going on here
	 *
	 * First, check the get parameter "action". Whenever set,
	 * Download the CSV from the URL $url, next,
	 */
	$url = "http://data.appsforghent.be/gentsefeesten/20120723.csv";
	
	// Check Action
	if (array_key_exists('action', $_GET)) {
	  $handle = fopen($url, "r");
	  $array = fgetcsv($handle, 0, ";");
	  $headers = ($array) ? $array : FALSE;
	  $counts = array();
	  if ($headers) {
	    $headernum = array_search('Straat', $headers);
	    while (($array = fgetcsv($handle, 0, ";")) ==! FALSE) {
	  	  $street = $array[$headernum];
	  	  if (array_key_exists($street, $counts)) {
	  	    $counts[$street] = $counts[$street] + 1;
	  	  } else {
	  	    $counts[$street] = 1;
	  	  }
	    } 
	    print "<pre>" . json_encode($counts) . "</pre>";
	  }
	  
	  else {
	  	print "File could not be parsed";
	  }
	// If no action is set, display some HTML
	} else {
	?>
	<lu>
	  <li><a href="?action=go">Go!</a></li>
	</ul>
	<?php
	}
	?>
	<p>Code on <a href="https://github.com/tthoeye/opendataghent">GitHub</a></p>
	</body>
</html>
