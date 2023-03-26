<?php
	require './vendor/autoload.php';
	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
	$dotenv->load();
	$baseUrl = $_ENV['NUMBERER_URL'];
	$title = 'Numberer';
	$description = 'Learn numbers';
	ob_start();
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
		<!-- <link rel="icon" href="<?= $baseUrl ?>/favicon.png"> -->
		<link rel="canonical" href="<?= $baseUrl ?>/index.html" />
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
			<meta property="og:image" content="<?= $baseUrl ?>/opengraph.png" />
			<meta property="og:description" content="<?= $description ?>" />
			<meta property="og:locale" content="en_US" />
			
			<!-- END OpenGraph -->
			<!-- TwitterCard -->
		
			<meta name="twitter:card" content="summary_large_image">
			<meta name="twitter:site" content="@dmcblue">
			<meta name="twitter:creator" content="@dmcblue">
			<meta name="twitter:title" content="dmcblue">
			<meta name="twitter:description" content="<?= $description ?>">
			<meta name="twitter:image" content="<?= $baseUrl ?>/opengraph.png">
			<!-- END TwitterCard -->
			<!-- Json LD -->
			<script type='application/ld+json'>{"@context":"https:\/\/schema.org","@graph":[{"@type":"WebSite","@id":"<?= json_encode($baseUrl) ?>","url":"<?= json_encode($baseUrl) ?>","name":"dmcblue","publisher":{"@id":"<?= json_encode($baseUrl) ?>\/about"}},{"@type":"ImageObject","@id":"<?= json_encode($baseUrl) ?>\/opengraph.png","url":"<?= json_encode($baseUrl) ?>\/opengraph.png","width":1273,"height":775},{"@type":"WebPage","@id":"<?= json_encode($baseUrl) ?>\/","url":"<?= json_encode($baseUrl) ?>\/","inLanguage":"en-US","name":"dmcblue","isPartOf":{"@id":"<?= json_encode($baseUrl) ?>"},"primaryImageOfPage":{"@id":"<?= json_encode($baseUrl) ?>\/opengraph.png"},"datePublished":null,"dateModified":null},{"@type":"Article","@id":"<?= json_encode($baseUrl) ?>\/","isPartOf":{"@id":"<?= json_encode($baseUrl) ?>\/"},"author":{"@id":"<?= json_encode($baseUrl) ?>\/about"},"headline":"dmcblue","datePublished":null,"dateModified":null,"commentCount":0,"mainEntityOfPage":{"@id":"<?= json_encode($baseUrl) ?>\/"},"publisher":{"@id":"<?= json_encode($baseUrl) ?>\/about"},"image":{"@id":"<?= json_encode($baseUrl) ?>\/opengraph.png"},"keywords":"","articleSection":""},{"@type":["Person"],"@id":"<?= json_encode($baseUrl) ?>\/about","name":"dmcblue","image":{"@type":"ImageObject","@id":"\/opengraph.png","url":"\/opengraph.png","caption":"dmcblue"},"sameAs":[]}]}</script>
			<!-- END Json LD -->
		<!-- END Metadata -->
		<style>
			body {
				background: rgba(150, 150, 255, 1);
				text-align: center;
			}
			#disp {
				margin-top: 1rem;
			}
			#disp, #answer {
				height: 4rem;
			}
			#disp .step, #answer .step {
				margin-right: 0.5rem;
			}
			#disp[lang=en], #answer[lang=en] {
				font-size: 300%;
			}
			#disp[lang=ar], #answer[lang=ar] {
				font-size: 400%;
			}
			#disp[lang=fa], #answer[lang=fa] {
				font-size: 400%;
			}
			#disp[lang=ur], #answer[lang=ur] {
				font-size: 400%;
			}
			#answer {
				margin-bottom: 1rem;
			}
			#answer .step {
				border-bottom: 1px solid black;
			}
			.step {
				display: inline-block;
				width: 2.5rem;
				text-align: center;
			}
			.step.correct {
				background: rgba(10, 200, 10, 1);
			}
			.step.incorrect {
				background: rgba(200, 10, 10, 1);
			}
			select, table button {
				border: none;
				background: rgba(10, 10, 200, 0.5);
			}
			select {
				margin-right: 1em;
			}
			table {
				margin: 0 auto;
			}
			table button {
				width: 2.5rem;
			}
			table[lang=en] button {
				font-size: 200%;
			}
			table[lang=ar] button {
				font-size: 300%;
			}
			table[lang=fa] button {
				font-size: 300%;
			}
			table[lang=ur] button {
				font-size: 300%;
			}
		</style>
		<script src="numberer.js" async="" defer="" crossorigin="anonymous"></script>
	</head>
	<body onload="start()">
		<h1>Learn Numbers</h1>
		From: <select id="source" onchange="setLanguage()">
			<option value="ar">Arabic</option>
			<option value="fa">Farsi</option>
			<option value="ur">Urdu</option>
			<option value="en">English</option>
		</select>
		To: <select id="target" onchange="setLanguage()">
			<option value="en">English</option>
			<option value="ar">Arabic</option>
			<option value="fa">Farsi</option>
			<option value="ur">Urdu</option>
		</select>
		<div id="disp"></div>
		<div id="answer"></div>
		<table>
			<tbody>
				<tr>
					<td>
						<button id="b7" onclick="test(7)"></button>
					</td>
					<td>
						<button id="b8" onclick="test(8)"></button>
					</td>
					<td>
						<button id="b9" onclick="test(9)"></button>
					</td>
				</tr>
				<tr>
					<td>
						<button id="b4" onclick="test(4)"></button>
					</td>
					<td>
						<button id="b5" onclick="test(5)"></button>
					</td>
					<td>
						<button id="b6" onclick="test(6)"></button>
					</td>
				</tr>
				<tr>
					<td>
						<button id="b1" onclick="test(1)"></button>
					</td>
					<td>
						<button id="b2" onclick="test(2)"></button>
					</td>
					<td>
						<button id="b3" onclick="test(3)"></button>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<button id="b0" onclick="test(0)"></button>
					</td>
					<td></td>
				</tr>
			</tbody>
		</table>
		<script>
			// add mode to reverse study type
			let source = 'ar';
			let target = 'en';
			let current = [0];
			let testIndex = 0;
			function start() {
				document.getElementById('source').value = source;
				document.getElementById('target').value = target;
				setLanguage();
				fillButtons();
				next();
			}

			function setLanguage() {
				source = document.getElementById('source').value;
				target = document.getElementById('target').value;
				fillButtons();
				next();
			}

			function getDigitsInLanguage(lang, digits) {
				if (lang === 'en') {
					return digits;
				} else if (lang === 'ar') {
					return digitsToArabic(digits)
				}

				return digitsToFarsi(digits);
			}

			function next() {
				let numDigits = getRandomInteger(1, 5);
				const disp = document.getElementById('disp');
				disp.lang = source;
				let temp = getDigits(numDigits);
				while (temp.join('') === current.join('') || (temp[0] === 0 && temp.length > 1)) {
					temp = getDigits(numDigits);
				}
				current = temp;
				disp.innerHTML = '';
				const lDigits = getDigitsInLanguage(source, current);
				for (let i = 0; i < current.length; i++) {
					const step = document.createElement('div');
					step.className = 'step';
					step.textContent = lDigits[i];
					disp.appendChild(step);
				}
				testIndex = 0;

				const answer = document.getElementById('answer');
				answer.innerHTML = '';
				answer.lang = target;
				for (let i = 0; i < current.length; i++) {
					const step = document.createElement('div');
					step.className = 'step';
					step.id = `s${i}`;
					step.innerHTML = '&nbsp;';
					answer.appendChild(step);
				}
			}

			function fillButtons() {
				for (let i = 0; i < 10; i++) {
					const n = getDigitsInLanguage(target, [i])[0];
					document.getElementById(`b${i}`).textContent = n;
				}
			}

			function test(n) {
				const step = document.getElementById(`s${testIndex}`);
				step.textContent = getDigitsInLanguage(target, [n])[0];
				if (n === current[testIndex]) {
					step.className = 'step correct';
					console.log('yes');
					testIndex++;
					if (testIndex === current.length) {
						setTimeout(function() {
							next();
						}, 500);
					}
				} else {
					step.className = 'step incorrect';
					console.log('no');
				}
			}
		</script>
	</body>
</html><?php

$page = ob_get_contents();
ob_end_clean();
file_put_contents('public' . DIRECTORY_SEPARATOR . 'index.html', $page);
