<?php
$symbol = "^AORD";
$quote = fetch_historical_data($symbol);
			if (count($quote) > 0) {
				print_r($quote);
			}
function fetch_historical_data($symbol)
	{
		require_once('simple_html_dom.php');
		// body of price history search
		$sym = $symbol;
		$yahooURL='https://finance.yahoo.com/quote/'.$sym.'/history?p='.$sym;
		// get stock name
		$data = file_get_contents($yahooURL);
		// get price data - use simple_html_dom.php (added to /include)
		$body=file_get_html($yahooURL);
		$tables = $body->find('table', 1);
		$dom = new DOMDocument();
		$elements[] = null;
		$dom->loadHtml($tables); 
		$x = new DOMXpath($dom);
		$i = 0;
		foreach($x->query('//td') as $td){
				$elements[$i] = $td -> textContent." ";
			$i++;
		}
		$open = ($elements[1]); 
		$high = ($elements[2]);
		$low = ($elements[3]);
		$close = ($elements[4]);
		$adj_close = ($elements[5]);
		$vol = str_replace( ',', '', $elements[6]);
		$vol = ($vol);
		return [			   
				"price" => $close,
				"open" => $open,
				"high" => $high,
				"low" => $low,
				"vol" => $vol,
				"adj_close" => $adj_close
		   ];
	}