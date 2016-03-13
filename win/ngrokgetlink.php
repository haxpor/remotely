<?php

$remoteUrl = "https://wasin.io/projs/remotely/sendEmailMsg.php";
$email = "haxpor@gmail.com";

// we might need to increase the range of local port here
// my test is either 4040 or 4042
$localInterfacePort = array(4042, 4041, 4042);
$tryIndex = 0;

// sleep for short duration to get result in local interface
echo "Waiting for 7 secs..."."\n";
sleep(7);

REQ:
// read result from localhost interface
echo "Requesting to get content for local interface page..."."\n";
echo "Trying http://127.0.0.1:" . "$localInterfacePort[$tryIndex]..."."\n";
$localInterfaceContent = file_get_contents("http://127.0.0.1:" . "$localInterfacePort[$tryIndex]");

// found URL
if (strpos($localInterfaceContent, 'URL') !== false)
{
	//echo "ngrok forwarding url: " . $ngrokOutput . "\n";
	echo "Requesting to send email..."."\n";
	$homepage = file_get_contents($remoteUrl."?email=" . urlencode($email) . "&msg=" . urlencode($localInterfaceContent));
	echo $homepage . "\n";
}
else
{
	if ($tryIndex > sizeOf($localInterfacePort)-1)
	{
		echo "Tried out all possible local interface port. Exit immediately."."\n";
		exit(0);
	}

	$tryIndex++;

	goto REQ;
}

?>
