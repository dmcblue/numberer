<?php
	require '../vendor/autoload.php';
	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . DIRECTORY_SEPARATOR . '..');
	$dotenv->load();
	$baseUrl = $_ENV['NUMBERER_URL'];
	$title = 'Numberer';
	$description = 'Learn numbers';
?><!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<style>
			@-ms-viewport{
				width: device-width;
			}
		</style>
		<link rel="icon" href="<?= $baseUrl ?>/favicon.png">
		<link rel="canonical" href="<?= $baseUrl ?>/home.html" />
		<meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>

		<!-- <link href="<?= $baseUrl ?>/style.css" rel="stylesheet" type="text/css">
		<link href="<?= $baseUrl ?>/home.css" rel="stylesheet" type="text/css"> -->
		<!-- Fonts -->
		<!-- <link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@300&family=Open+Sans:ital,wght@0,300;0,400;0,600;1,300;1,400;1,600&display=swap" rel="stylesheet"> -->
		<!-- END Fonts -->

		
		<!-- Metadata -->
			<!-- Standard -->
			<title><?= $title ?></title>
			<meta name="description" content="<?= $description ?>" />		
		
			<!-- END Standard -->
			<!-- OpenGraph -->
			<meta property="og:title" content="<?= $title ?>" />
			<meta property="og:type" content="website" />
			<meta property="og:url" content="<?= $baseUrl ?>/" />
			<!-- <meta property="og:image" content="<?= $baseUrl ?>/images/opengraph.png" /> -->
			<meta property="og:description" content="<?= $description ?>" />
			<meta property="og:locale" content="en_US" />
			
			<!-- END OpenGraph -->
			<!-- TwitterCard -->
		
			<meta name="twitter:card" content="summary_large_image">
			<meta name="twitter:site" content="@dmcblue">
			<meta name="twitter:creator" content="@dmcblue">
			<meta name="twitter:title" content="dmcblue">
			<meta name="twitter:description" content="<?= $description ?>">
			<!-- <meta name="twitter:image" content="<?= $baseUrl ?>/images/opengraph.png"> -->
			<!-- END TwitterCard -->
			<!-- Json LD -->
			<script type='application/ld+json'>{"@context":"https:\/\/schema.org","@graph":[{"@type":"WebSite","@id":"<?= json_encode($baseUrl) ?>","url":"<?= json_encode($baseUrl) ?>","name":"dmcblue","publisher":{"@id":"<?= json_encode($baseUrl) ?>\/about"}},{"@type":"ImageObject","@id":"<?= json_encode($baseUrl) ?>\/images\/opengraph.png","url":"<?= json_encode($baseUrl) ?>\/images\/opengraph.png","width":1273,"height":775},{"@type":"WebPage","@id":"<?= json_encode($baseUrl) ?>\/","url":"<?= json_encode($baseUrl) ?>\/","inLanguage":"en-US","name":"dmcblue","isPartOf":{"@id":"<?= json_encode($baseUrl) ?>"},"primaryImageOfPage":{"@id":"<?= json_encode($baseUrl) ?>\/images\/opengraph.png"},"datePublished":null,"dateModified":null},{"@type":"Article","@id":"<?= json_encode($baseUrl) ?>\/","isPartOf":{"@id":"<?= json_encode($baseUrl) ?>\/"},"author":{"@id":"<?= json_encode($baseUrl) ?>\/about"},"headline":"dmcblue","datePublished":null,"dateModified":null,"commentCount":0,"mainEntityOfPage":{"@id":"<?= json_encode($baseUrl) ?>\/"},"publisher":{"@id":"<?= json_encode($baseUrl) ?>\/about"},"image":{"@id":"<?= json_encode($baseUrl) ?>\/images\/opengraph.png"},"keywords":"","articleSection":""},{"@type":["Person"],"@id":"<?= json_encode($baseUrl) ?>\/about","name":"dmcblue","image":{"@type":"ImageObject","@id":"\/images\/opengraph.png","url":"\/images\/opengraph.png","caption":"dmcblue"},"sameAs":[]}]}</script>
			<!-- END Json LD -->
		<!-- END Metadata -->
		<style>
			#disp {
				font-size: 400%;
			}
		</style>
		<script src="numberer.js" async="" defer="" crossorigin="anonymous"></script>
	</head>
	<body onload="start()">
		<h1>Learn Numbers</h1>
		<select id="lang" onchange="setLanguage()">
			<option value="ar">Arabic</option>
			<option value="fa">Farsi</option>
			<option value="ur">Urdu</option>
		</select>
		<div id="disp"></div>
		<button id="b0" onclick="test(0)"></button>
		<button id="b1" onclick="test(1)"></button>
		<button id="b2" onclick="test(2)"></button>
		<button id="b3" onclick="test(3)"></button>
		<button id="b4" onclick="test(4)"></button>
		<button id="b5" onclick="test(5)"></button>
		<button id="b6" onclick="test(6)"></button>
		<button id="b7" onclick="test(7)"></button>
		<button id="b8" onclick="test(8)"></button>
		<button id="b9" onclick="test(9)"></button>
		<script>
			// add mode to reverse study type
			let lang = 'ar';
			let current = [0];
			let testIndex = 0;
			function start() {
				setLanguage();
				fillButtons();
				next();
			}

			function setLanguage() {
				lang = document.getElementById('lang').value;
				next();
			}

			function getDigitsInLanguage(digits) {
				if (lang === 'ar') {
					return digitsToArabic(digits)
				}

				return digitsToFarsi(digits);
			}

			function next() {
				let numDigits = getRandomInteger(1, 5);
				const disp = document.getElementById('disp');
				disp.lang = lang;
				let temp = getDigits(numDigits);
				while (temp.join('') === current.join('') || (temp[0] === 0 && temp.length > 1)) {
					temp = getDigits(numDigits);
				}
				current = temp;
				disp.textContent = getDigitsInLanguage(current).join('');
				testIndex = 0;
			}

			function fillButtons() {
				for (let i = 0; i < 10; i++) {
					document.getElementById(`b${i}`).textContent = +i;
				}
			}

			function test(n) {
				if (n === current[testIndex]) {
					console.log('yes');
					testIndex++;
					if (testIndex === current.length) {
						next();
					}
				} else {
					console.log('no');
				}
			}
		</script>
	</body>
</html>
