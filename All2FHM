<?php

/**
 * Author: nikcorp
 * e-mail: nickcorp@rambler.ru
 * Donation:
 * BTC   : 1F8F5zUeLhCzzNrThsQHcKSbfu3yNFcjMb
 * LTC   : LbYUZvhDH3eagijBV7exggT29Hct5GqCwm
 */




// MAIN LOOP
while(true)
{

    // Working Function
    	$StartTime = FirstFunc('NickName','Key','Secret',0.01);



	// Pause :)
	if ($StartTime > 3) $StartTime = 3;

	for	($j=1; $j<=$StartTime; $j++)
	{
		echo " \n Waiting 1 minute ";
		for($i=0; $i<15; $i++)
		{
			 echo ".";
			 sleep(1);
		}
	}
	echo " \n ";

}

// Work Function
function FirstFunc($username, $api_key, $api_secret, $Lot)
{
	static $StartTime = 0;
	echo " \n Reading DATA from CEX.IO... \n \n";

	// Reading Price
	$LTCPrice = GetPrice('https://cex.io/api/ticker/LTC/BTC');
	$NMCPrice = GetPrice('https://cex.io/api/ticker/NMC/BTC');
	$FHMPrice = GetPrice('https://cex.io/api/ticker/FHM/BTC');

	// Ballance
	$nonce	= round(microtime(true)*100);
	$myvars	= 'key=' . $api_key .
		      '&signature=' . make_signature($username,$api_key,$api_secret,$nonce) .
		      '&nonce=' . $nonce;
	$OutRes	= getCEX($myvars);

	$BTC_Ball	= $OutRes->BTC->available ;
	$NMC_Ball	= $OutRes->NMC->available ;
	$LTC_Ball	= $OutRes->LTC->available ;

	$FHMBTC_available = $BTC_Ball / ($FHMPrice*1.0001) ;
	$FHMNMC_available = $NMC_Ball / ($FHMPrice*1.0001) * $NMCPrice;
	$FHMLTC_available = $LTC_Ball / ($FHMPrice*1.0001) * $LTCPrice;

	// Print to Screen
	echo 'FHM/BTC : ', $FHMPrice, "\n";
	echo 'FHM/NMC : ', number_format($FHMPrice / $NMCPrice,8), "\n";
	echo 'FHM/LTC : ', number_format($FHMPrice / $LTCPrice,8), "\n";

	echo 'BTC in account - ', $BTC_Ball, "\n" ;
	echo 'NMC in account - ', $NMC_Ball, "\n" ;
	echo 'LTC in account - ', $LTC_Ball, "\n" ;

	$StartTime++;

	// BUY FHM for BTC
	$LotBakUp = $Lot;
	if ($FHMBTC_available > $Lot)
	{
		$RealGH = intval( $FHMBTC_available / $Lot )*$Lot;
		$Lot1 = $Lot;
		if ($RealGH/$Lot > 10)
		{
			$Lot1 = $Lot * 10;
		}
		if ($RealGH/$Lot > 100)
		{
			$Lot1 = $Lot * 100;
		}
		$Lot = $Lot1;
		echo 'Ready to buy (FHM/BTC) - ', $RealGH, " (", $FHMBTC_available, " FHM) \n";

		$nonce		= round(microtime(true)*100);
		$buyVars = 'key=' . $api_key .
			       '&signature=' . make_signature($username,$api_key,$api_secret,$nonce) .
			       '&nonce=' . $nonce .
			       '&type=buy' .
			       '&price=' . number_format(1.0001 * $FHMPrice, 8) .
			       '&amount=' . $Lot; // . $buyAmnt;

		echo "  Placing order (",number_format(1.0001 * $FHMPrice,8), " x $Lot)... ";
	    $OutRes = Buy_Sell($buyVars, 'https://cex.io/api/place_order/FHM/BTC');
	    $ResPlacing = $OutRes->id;
	    if ($ResPlacing > 0)
	    {
	    	echo "Order is Placed. Order ID = ", $ResPlacing, " \n";
	    }
	    else
	    {
	    	echo "Error placing order: \n";
	    	var_dump($OutRes);
	    }
	    $StartTime = 1;
	}


	// Sell LTC for BTC
	$Lot = $LotBakUp;
	if ($FHMLTC_available > $Lot)
	{
		$RealGH = intval( $FHMLTC_available / $Lot )*$Lot;
		$Lot1 = $Lot;
		if ($RealGH/$Lot > 10)
		{
			$Lot1 = $Lot * 10;
		}
		if ($RealGH/$Lot > 100)
		{
			$Lot1 = $Lot * 100;
		}
		$Lot = $Lot1;
		echo 'Ready to Sell (LTC/BTC) - ', $RealGH, " (", $FHMLTC_available, " LTC) \n";

		$nonce		= round(microtime(true)*100);
		$buyVars = 'key=' . $api_key .
			       '&signature=' . make_signature($username,$api_key,$api_secret,$nonce) .
			       '&nonce=' . $nonce .
			       '&type=sell' .
			       '&price=' . number_format(1.0/1.0001 * $LTCPrice,8) .
			       '&amount=' . number_format($FHMPrice / $LTCPrice * $Lot,8); // . $buyAmnt;

		echo "  Placing order (",number_format(1.0/1.0001 * $LTCPrice, 8), " x $Lot)... ";

	    $OutRes = Buy_Sell($buyVars, 'https://cex.io/api/place_order/LTC/BTC');
	    $ResPlacing = $OutRes->id;
	    if ($ResPlacing > 0)
	    {
	    	echo "Order is Placed. Order ID = ", $ResPlacing, " \n";
	    }
	    else
	    {
	    	echo "Error placing order: \n";
	    	var_dump($OutRes);
	    }
	    $StartTime = 1;
	}


	// Sell NMC for BTC
	$Lot = $LotBakUp;
	if ($FHMNMC_available > $Lot)
	{
		$RealGH = intval( $FHMNMC_available / $Lot )*$Lot;
		$Lot1 = $Lot;
		if ($RealGH/$Lot > 10)
		{
			$Lot1 = $Lot * 10;
		}
		if ($RealGH/$Lot > 100)
		{
			$Lot1 = $Lot * 100;
		}
		$Lot = $Lot1;
		echo 'Ready to Sell (NMC/BTC) - ', $RealGH, " (", $FHMNMC_available, " NMC) \n";

		$nonce		= round(microtime(true)*100);
		$buyVars = 'key=' . $api_key .
			       '&signature=' . make_signature($username,$api_key,$api_secret,$nonce) .
			       '&nonce=' . $nonce .
			       '&type=sell' .
			       '&price=' . number_format(1.0/1.0001 * $NMCPrice,8) .
			       '&amount=' . number_format($FHMPrice / $NMCPrice * $Lot, 8); // . $buyAmnt;

		echo "  Placing order (",number_format(1.0/1.0001 * $NMCPrice,8), " x $Lot)... ";

	    $OutRes = Buy_Sell($buyVars, 'https://cex.io/api/place_order/NMC/BTC');
	    $ResPlacing = $OutRes->id;
	    if ($ResPlacing > 0)
	    {
	    	echo "Order is Placed. Order ID = ", $ResPlacing, " \n";
	    }
	    else
	    {
	    	echo "Error placing order: \n";
	    	var_dump($OutRes);
	    }
	    $StartTime = 1;
	}


	echo "\n";
	return $StartTime;
}




















function make_signature($username,$api_key,$api_secret,$nonce)
{
	$string = $nonce . $username . $api_key; //Create string
	$hash = hash_hmac('sha256', $string, $api_secret); //Create hash
	$hash = strtoupper($hash);

	return $hash;
}


function GetPrice ($url)
{
	$contents = file_get_contents($url);
	$answer = json_decode($contents ,true);
	$current = $answer['last'];

	return $current;
}


function getCEX($myvars)
{
	$url = 'https://cex.io/api/balance/';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'phpAPI');
	curl_setopt($ch, CURLOPT_POSTFIELDS, $myvars);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	$out = json_decode(curl_exec($ch));
	curl_close($ch);

	return $out;
}



// Buy & Sell Funktion
function Buy_Sell($buyVars, $url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'phpAPI');
	curl_setopt($ch, CURLOPT_POSTFIELDS, $buyVars);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	$out = json_decode(curl_exec($ch));
	curl_close($ch);

	return $out;
}


?>
