<!doctype html>
<html lang="nl">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Drieland</title>
		<link
			href="https://fonts.googleapis.com/css2?family=Crimson+Text:wght@400;600&family=Source+Sans+Pro:wght@400;600&display=swap"
			rel="stylesheet"
		/>
		<style>
			* {
				margin: 0;
				padding: 0;
				box-sizing: border-box;
			}

			body {
				font-family: 'Crimson Text', serif;
				line-height: 1.6;
				color: #333;
				background-color: white;
				max-width: 640px;
				margin: 0 auto;
				padding: 40px 20px;
			}

			.logo {
				text-align: center;
				margin-bottom: 40px;
			}

			.logo img {
				max-width: 100%;
				height: auto;
			}

			.main-map {
				text-align: center;
				margin-bottom: 40px;
			}

			.main-map img {
				max-width: 100%;
				height: auto;
				border: 2px solid #333;
			}

			.intro-text {
				font-size: 22px;
				line-height: 1.6;
				margin: 10px;
				margin-bottom: 60px;
				text-align: justify;
			}

			.intro-text::first-letter {
				font-size: 3.5em;
				float: left;
				line-height: 0.8;
				margin: 0.1em 0.1em 0 0;
				font-weight: 600;
			}

			.blog-post {
				margin-bottom: 60px;
				border-bottom: 1px solid #ddd;
				padding-bottom: 40px;
			}

			.blog-post:last-child {
				border-bottom: none;
			}

			.post-map {
				text-align: center;

				margin-bottom: 20px;
			}

			.post-map img {
				max-width: 100%;
				height: auto;
			}

			.post {
				margin: 20px;
			}

			.post-title {
				font-family: 'Source Sans Pro', sans-serif;
				font-size: 32px;
				font-weight: 600;
				text-transform: uppercase;
				letter-spacing: 2px;

				margin-bottom: 20px;
				text-align: left;
			}

			.post-content {
				font-size: 22px;
				line-height: 1.5;

				margin-bottom: 25px;
				text-align: justify;
			}

			.post-content::first-letter {
				font-size: 3.5em;
				float: left;
				line-height: 0.8;
				margin: 0.1em 0.1em 0 0;
				font-weight: 600;
			}

			.read-more {
				display: inline-block;
				background-color: #333;
				color: white;
				text-decoration: none;
				padding: 12px 24px;
				font-family: 'Source Sans Pro', sans-serif;
				font-weight: 600;
				text-transform: uppercase;
				letter-spacing: 1px;
				font-size: 14px;
				transition: background-color 0.3s ease;
			}

			.read-more:hover {
				background-color: #555;
			}

			.tagline {
				text-align: center;
				font-style: italic;
				font-size: 22px;
				color: #666;
				margin-top: 20px;
			}

            .text-center{
                text-align: center;
            }

			.image-gallery {
				margin: 40px 0;
			}

			.image-gallery h3 {
				font-family: 'Source Sans Pro', sans-serif;
				font-size: 24px;
				font-weight: 600;
				text-transform: uppercase;
				letter-spacing: 1px;
				margin-bottom: 20px;
				text-align: center;
				color: #333;
			}

			.gallery-grid {
				display: grid;
				grid-template-columns: 1fr;
				gap: 20px;
				margin-bottom: 30px;
			}

			.gallery-item {
				text-align: center;
			}

			.gallery-item img {
				width: 100%;
				height: auto;
				border: 2px solid #ddd;
				border-radius: 4px;
				cursor: pointer;
				transition: transform 0.3s ease, border-color 0.3s ease;
			}

			.gallery-item img:hover {
				transform: scale(1.02);
				border-color: #333;
			}

			/* Modal styles for full-size image viewing */
			.modal {
				display: none;
				position: fixed;
				z-index: 1000;
				left: 0;
				top: 0;
				width: 100%;
				height: 100%;
				background-color: rgba(0,0,0,0.9);
				align-items: center;
				justify-content: center;
			}

			.modal.show {
				display: flex;
			}

			.modal-content {
				max-width: 90%;
				max-height: 90%;
				object-fit: contain;
				border-radius: 4px;
			}

			.close {
				position: absolute;
				top: 15px;
				right: 35px;
				color: #f1f1f1;
				font-size: 40px;
				font-weight: bold;
				cursor: pointer;
			}

			.close:hover,
			.close:focus {
				color: #bbb;
				text-decoration: none;
				cursor: pointer;
			}

			.modal-nav {
				position: absolute;
				top: 50%;
				transform: translateY(-50%);
				color: #f1f1f1;
				font-size: 30px;
				font-weight: bold;
				cursor: pointer;
				padding: 20px;
				user-select: none;
				transition: color 0.3s ease;
			}

			.modal-nav:hover {
				color: #bbb;
			}

			.modal-nav.prev {
				left: 20px;
			}

			.modal-nav.next {
				right: 20px;
			}

			.modal-counter {
				position: absolute;
				bottom: 20px;
				left: 50%;
				transform: translateX(-50%);
				color: #f1f1f1;
				font-family: 'Source Sans Pro', sans-serif;
				font-size: 14px;
			}

			@media (max-width: 600px) {
				body {
					padding: 20px 15px;
				}


				.gallery-grid {
					grid-template-columns: 1fr;
					gap: 15px;
				}
				
				.image-gallery h3 {
					font-size: 20px;
				}

				.modal-nav {
					font-size: 24px;
					padding: 15px;
				}
			}
		</style>
	</head>
	<body>
		<?php
		// Get the current URL path
		$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		
		// Remove leading/trailing slashes and split by '/'
		$pathParts = array_filter(explode('/', trim($currentPath, '/')));
		
		// Try to find the folder name (usually the second part after 'article')
		$folderName = '';
		if (count($pathParts) >= 2 && $pathParts[0] === 'article') {
			$folderName = $pathParts[1];
		}
		
		// Check if the corresponding image exists, otherwise fall back to header.png
		$imageName = 'header.png'; // default
		if (!empty($folderName)) {
			$imageFile = __DIR__ . '/../img/' . $folderName . '.png';
			if (file_exists($imageFile)) {
				$imageName = $folderName . '.png';
			}
		}
		?>
		<header class="logo">
			<a href="/"><img src="/img/logo.png" alt="Drieland Logo" /></a>
			<img src="/img/<?php echo htmlspecialchars($imageName); ?>" alt="Kaart van <?php echo !empty($folderName) ? htmlspecialchars(ucfirst($folderName)) : 'Drieland'; ?>" />
		</header>