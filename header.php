<?php
$canonical_path = $canonical_path ?? '/';
$canonical_url  = 'https://rangeroverguys.com' . $canonical_path;
$meta_robots    = $meta_robots ?? 'index, follow';
$og_url         = ($canonical_path === '/') ? 'https://rangeroverguys.com/' : $canonical_url;
?>
<!DOCTYPE html>

<html lang="en-US">

	<head>

		<title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>

		<meta name="description" content="<?= htmlspecialchars($meta_description, ENT_QUOTES, 'UTF-8') ?>" />

		<meta name="robots" content="<?= htmlspecialchars($meta_robots, ENT_QUOTES, 'UTF-8') ?>" />

		<meta charset="utf-8" />

		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<meta name="theme-color" content="#004678" />

		<meta property="og:title" content="<?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?>" />

		<meta property="og:description" content="<?= htmlspecialchars($meta_description, ENT_QUOTES, 'UTF-8') ?>" />

		<meta property="og:image" content="https://rangeroverguys.com/images/og-shop.jpg" />

		<meta property="og:url" content="<?= htmlspecialchars($og_url, ENT_QUOTES, 'UTF-8') ?>" />

		<meta property="og:type" content="website" />

		<meta name="twitter:card" content="summary_large_image" />

		<link rel="stylesheet" type="text/css" href="style.css" media="screen" />

		<link rel="stylesheet" type="text/css" href="print.css" media="print" />

		<link rel="canonical" href="<?= htmlspecialchars($canonical_url, ENT_QUOTES, 'UTF-8') ?>" />

		<script type="application/ld+json">
		{
		  "@context": "https://schema.org",
		  "@type": "AutoRepair",
		  "name": "Range Rover Guys",
		  "image": "https://rangeroverguys.com/images/shop.jpg",
		  "telephone": "+1-714-465-5488",
		  "priceRange": "$$",
		  "address": {
		    "@type": "PostalAddress",
		    "streetAddress": "7662 Slater Avenue, Suite J",
		    "addressLocality": "Huntington Beach",
		    "addressRegion": "CA",
		    "postalCode": "92647",
		    "addressCountry": "US"
		  },
		  "geo": { "@type": "GeoCoordinates", "latitude": "33.719057", "longitude": "-117.991018" },
		  "url": "https://rangeroverguys.com",
		  "openingHoursSpecification": [{
		    "@type": "OpeningHoursSpecification",
		    "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
		    "opens": "08:00",
		    "closes": "17:00"
		  }],
		  "areaServed": ["Huntington Beach","Irvine","Newport Beach","Seal Beach","Los Alamitos"],
		  "makesOffer": ["Range Rover repair","Range Rover air conditioning service","Range Rover brake service","Range Rover electrical diagnosis","Range Rover maintenance"]
		}
		</script>

	</head>

	<body>

		<div id="wrapper">

			<header><a href="tel:+17144655488" border="0"><img src="images/banner.png" width="968" height="281" fetchpriority="high" alt="Range Rover Guys - Independent Range Rover Repair, Huntington Beach" /></a></header>

			<div id="content">

				<nav aria-label="Primary">

					<ul>
						<li><a href="/">Home</a></li>
						<li><a href="air-conditioning-service-and-repair.php">Air Conditioning Service</a></li>
						<li><a href="brake-service-and-repair.php">Brake Service</a></li>
						<li><a href="sitemap.php">Site Map</a></li>
					</ul>

				</nav>

				<div id="unique">
