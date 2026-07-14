<!doctype html>
<html lang="en-US">
<head>
<title>EthereonGaming - Соц-Сети</title>
<meta charset="utf-8">
<meta name="description" content="На данной странице вы можете перейти на наши каналы">
<meta name="keywords" content="social networks, EthereonGaming, ethereon gaming>
<?php include 'lib/module/sys-meta.php';?>
<meta property="og:title" content="EthereonGaming - Соц-Сети" />
<meta property="og:description" content="На данной странице вы можете перейти на наши каналы" />
<meta property="og:image" content="/img/meta/mobile/1200.png" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:url" content="https://ethereongaming.ru" />
<meta property="og:locale" content="en_US"/>
<meta property="og:type" content="website" />
<meta property="og:site_name" content="EthereonGaming" />

<meta name="twitter:title" content="EthereonGaming - Соц-Сети">
<meta name="twitter:description" content="На данной странице вы можете перейти на наши каналы">
<meta name="twitter:image" content="/img/meta/mobile/1200.png">
<meta name="twitter:site" content="t.me/ethereongaming_ru">
<meta name="twitter:creator" content="t.me/ethereongaming_ru">
<meta name="twitter:card" content="summary_large_image">
<?php include 'lib/module/sys-css.php';?>
<?php include 'lib/module/sys-js.php';?>
</head>
<body>
<?php include 'lib/module/sys-global.php';?>
<?php
if (@include_once("lib/compat/objects/Build.php"))
	$build = Build::get_latest(null);
?>
<div class="page-con-content">
	<div class="banner-con-container darkmode-header">
		<div id="object-particles">
		</div>
		<div class="wavebar-con-container">
			<div class="wavebar-con-wrap">
				<div class="wavebar-svg-object">
				</div>
				<div class="wavebar-svg-object">
				</div>
			</div>
		</div>
		<div class='banner-con-title fade-up-onstart'>
			<div class='banner-tx1-title fade-up-onstart pulsate'>
				<h1>Соц-Сети</h1>
			</div>
			<div class='banner-con-divider'>
			</div>
			<div class='banner-tx2-title fade-up-onstart'>
				<p>
					 Наши Каналы
				</p>
			</div>
		</div>
	</div>
	<div class="page-con-container">
		<div class="page-in-container">
			<div class='container-con-block darkmode-block'>
				<div class='container-con-wrapper'>
				</div>
			</div>
			<div class='container-tx1-block darkmode-txt'>
				<h2>Соц-сети</h2>
			</div>
			<div class='container-tx2-block darkmode-txt'>
				<p class="download-desc">
				Нажав на кнопку, вы попадете на наши каналы
				</p>
			</div>			
		<?php include 'lib/module/download/inc-download-platform.php';?>
			<div class='container-con-block darkmode-block'>
				<div class='container-con-wrapper'>
				</div>
			</div>
		</div>
	</div>
</div>
	<?php include 'lib/module/inc-footer.php';?>
</div>
</body>
</html>
О