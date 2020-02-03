<?php
/* function to get a random string */
function generateToken(): string {
	return bin2hex(random_bytes(32));
}

/* set CSP nonce for style and script sources */
$styleNonce = generateToken();
$scriptNonce = generateToken();
$imgNonce = generateToken();

/* create CSP string */
$CSP = "default-src 'self'; script-src 'nonce-$scriptNonce'; style-src 'nonce-$styleNonce'";
header("Content-Security-Policy: $CSP");
?>
<!DOCTYPE html>
<html>
	<head>
		<!-- <meta http-equiv="Content-Security-Policy" content="<?=$CSP?>"/> -->

		<meta charset="utf-8"/>
		<meta http-equiv="Content-Type" content="text/html">

		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
		<meta name="description" content="Proof of concept of CSP nonce bypassing on Mozilla Firefox"/>

		<meta name="author" content="Andrea Serra"/>
		<title>POC XFOX</title>

		<link rel="stylesheet" type="text/css" href="/css/style.css" nonce="<?=$styleNonce?>"/>
	</head>
	<body>
		<h1>Hello!!!</h1>
		<script src="/js/script.js" type="text/javascript" nonce="<?=$scriptNonce?>"></script>
	</body>
</html>
