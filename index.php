<?php
	require './vendor/autoload.php';
	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
	$dotenv->load();
	$baseUrl = $_ENV['NUMBERER_URL'];
	$title = 'Learn Numbers';
	$description = 'Practice various number systems';
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

		<link href="<?= $baseUrl ?>/styles.css" rel="stylesheet" type="text/css">
		<!-- Fonts -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300&display=swap" rel="stylesheet">
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

		<script src="numberer.js" async="" defer="" crossorigin="anonymous"></script>
	</head>
	<body onload="start()" onkeyup="UI.onKeyUp(event)">
		<h1>Learn Numbers</h1>
		<div>
			<label>Mode: <select id="mode" onchange="UI.setMode()">
				<option value="match">Matching</option>
				<option value="math">Math</option>
			</select></label>
		</div>
		<div class="match">
			<label>From: <select id="source" onchange="UI.setLanguage()">
				<option value="ar">Arabic</option>
				<option value="bn">Bengali</option>
				<option value="fa">Farsi</option>
				<option value="ur">Urdu</option>
				<option value="en">English</option>
			</select></label>
			<label>To: <select id="target" onchange="UI.setLanguage()">
				<option value="ar">Arabic</option>
				<option value="bn">Bengali</option>
				<option value="en">English</option>
				<option value="fa">Farsi</option>
				<option value="ur">Urdu</option>
			</select></label>
		</div>
		<div class="math">
			<label>Language: <select id="lang-math" onchange="UI.setLanguage()">
				<option value="ar">Arabic</option>
				<option value="bn">Bengali</option>
				<option value="fa">Farsi</option>
				<option value="ur">Urdu</option>
				<option value="en">English</option>
			</select></label>
		</div>
		<div class="match">
			<button id="flip" onclick="UI.flip()">Switch 🔄</button>
		</div>
		<div id="disp"></div>
		<div id="answer"></div>
		<table id="numpad">
			<tbody>
				<tr>
					<td>
						<button id="b7" onclick="UI.test(7)"></button>
					</td>
					<td>
						<button id="b8" onclick="UI.test(8)"></button>
					</td>
					<td>
						<button id="b9" onclick="UI.test(9)"></button>
					</td>
				</tr>
				<tr>
					<td>
						<button id="b4" onclick="UI.test(4)"></button>
					</td>
					<td>
						<button id="b5" onclick="UI.test(5)"></button>
					</td>
					<td>
						<button id="b6" onclick="UI.test(6)"></button>
					</td>
				</tr>
				<tr>
					<td>
						<button id="b1" onclick="UI.test(1)"></button>
					</td>
					<td>
						<button id="b2" onclick="UI.test(2)"></button>
					</td>
					<td>
						<button id="b3" onclick="UI.test(3)"></button>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<button id="b0" onclick="UI.test(0)"></button>
					</td>
					<td>
						<button class="math" onclick="UI.backspace()">&lt;</button>
					</td>
				</tr>
			</tbody>
		</table>
		<p>
			Click or type to enter numbers.
		</p>
		<script>
			function start() {
				UI.start();
			}
		</script>
	</body>
</html><?php

$page = ob_get_contents();
ob_end_clean();
file_put_contents('public' . DIRECTORY_SEPARATOR . 'index.html', $page);
