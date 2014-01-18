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
    	$StartTime = FirstFunc('Your_NickName','Your_APIKey','YOUR_APISecret');



	// Pause :)
	if ($StartTime > 3) $StartTime = 3;

	for	($j=1; $j<=$StartTime; $j++)
	{
		echo " \n Waiting 1 minute ";
		for($i=0; $i<60; $i++)
		{
			 echo ".";
			 sleep(1);
		}
	}
	echo " \n ";

}

// Work Function
function FirstFunc($username, $api_key, $api_secret)
{
	static $StartTime = 0;
	echo " \n Reading DATA from CEX.IO... \n \n";

	// Reading
	$BTCPrice = getBTC();

	$NMCPrice = getNMC();

	// Ballance
	$nonce	= round(microtime(true)*100);
	$myvars	= 'key=' . $api_key .
		      '&signature=' . make_signature($username,$api_key,$api_secret,$nonce) .
		      '&nonce=' . $nonce;
	$OutRes	= getCEX($myvars);

	$BTC_Ball	= $OutRes->BTC->available ; // $btcPrice
	$NMC_Ball	= $OutRes->NMC->available ; // $btcPrice

	$GHSBTC_available = $BTC_Ball / ($BTCPrice*1.0001) ;
	$GHSNMC_available = $NMC_Ball / ($NMCPrice*1.0001) ;

	// Print to Screen

	echo 'GHS/BTC : ', $BTCPrice, "\n";
	echo 'GHS/NMC : ', $NMCPrice, "\n";

	echo 'BTC in account - ', $BTC_Ball, "\n" ;
	echo 'NMC in account - ', $NMC_Ball, "\n" ;


	$StartTime++;


	// BUY GHS for BTC
	if ($GHSBTC_available > 0.01)
	{
		$RealGH = intval( $GHSBTC_available / 0.01 )*0.01;
		echo 'Ready to buy (GHS/BTC) - ', $RealGH, " (", $GHSBTC_available, " GHS) \n";

		$nonce		= round(microtime(true)*100);
		$buyVars = 'key=' . $api_key .
			       '&signature=' . make_signature($username,$api_key,$api_secret,$nonce) .
			       '&nonce=' . $nonce .
			       '&type=buy' .
			       '&price=' . number_format(1.0001 * $BTCPrice,8) .
			       '&amount=0.01'; // . $buyAmnt;

		echo "  Placing order (",number_format(1.0001 * $BTCPrice,8), " x 0.01)... ";
	    $OutRes = buy_GHSBTC($buyVars);
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

	// BUY GHS for NMC
	if ($GHSNMC_available >0.01)
	{
		$RealGH = intval( $GHSNMC_available / 0.01 )*0.01;
		echo 'Ready to buy (GHS/NMC) - ', $RealGH, " (", $GHSNMC_available, " GHS) \n";

		$nonce		= round(microtime(true)*100);
		$buyVars = 'key=' . $api_key .
			       '&signature=' . make_signature($username,$api_key,$api_secret,$nonce) .
			       '&nonce=' . $nonce .
			       '&type=buy' .
			       '&price=' . number_format(1.0001 * $NMCPrice,8) .
			       '&amount=0.01'; // . $buyAmnt;

		echo "  Placing order (",number_format(1.0001 * $NMCPrice,8), " x 0.01)... ";
	    $OutRes = buy_GHSNMC($buyVars);
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


function getBTC ()
{
	$url = 'https://cex.io/api/ticker/GHS/BTC';
	$contents = file_get_contents($url);
	$answer = json_decode($contents ,true);
	$current = $answer['last'];

	return $current;
}


function getNMC ()
{
	$url = 'https://cex.io/api/ticker/GHS/NMC';
	$contents = file_get_contents($url);
	$answer = json_decode($contents ,true);
	$currentNMC = $answer['last'];

	return $currentNMC;
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

// Buy GHS`s for BTC
function buy_GHSBTC($buyVars)
{
	$url = 'https://cex.io/api/place_order/GHS/BTC';

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


// Buy GHS`s for NMC
function buy_GHSNMC($buyVars)
{
	$url = 'https://cex.io/api/place_order/GHS/NMC';

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
