<div class="container-con-superblock darkmode-txt">
	<div class='container-con-superblock-emp'>
	</div>
	<div class='container-con-superblock-div'>
	</div>
</div>
<div class='container-con-wrapper'>
	<div class="anchor-point" id="requirements_handheld">
	</div>
	<div class='container-tx1-block darkmode-txt'>
		<div class='container-emp-block'>
		</div>
		<h2>Download kuyokibrawl</h2>
	</div>
	<div class='container-tx2-block darkmode-txt'>
		<p class="download-desc">
			Здесь вы можете установить kuyokibrawl на ваше устройство.<br>
			<br>
			<b>Также для установки вы можете использовать страницу <a href='/download' target="_blank">downloads</a>.</b>
		</p>
	</div>
</div>
<div class='downloadable-con-container'>
	<div class='downloadable-con-outer'>
		<div class='downloadable-con-inner-a'>
			<div class='downloadable-con-graphic' style="background: url(/img/graphics/download/windows.png) center top no-repeat; right: -52px; bottom: -38px;">
			</div>
			<div class='downloadable-con-image' style="background: url(/img/icons/list/os-android.png) center left / 42px no-repeat;">
			</div>
			<div class='downloadable-tx1-title darkmode-txt'>
				<span>Android</span>
			</div>
			<div class='downloadable-tx2-desc darkmode-txt'>
				<span>Установить kuyokibrawl на ваше устройство. Перед установкой следует ознакомиться с необходимыми характеристиками устройства для стабильной работы.</span>
			</div>
			<div class='sha2-tx1-title darkmode-txt'>
				<span>32-bit</span>
			</div>
			<div class='sha2-tx2-desc'>
			<div class='sha2-ico-desc' style="background: url(/img/icons/buttons/sha2-arm64.png) center / contain no-repeat;"></div>
				<span>
					<?php
					if (false /*isset($build) && !is_null($build->checksum_win_arm64)*/)
						printf("%s", $build->checksum_win_arm64);
					else
						printf("Coming soon...");
					?>
				</span>
			</div>
			<div class='package-tx1-title darkmode-txt'>
				<span>Download</span>
			</div>
			<?php
			if (isset($build) && !is_null($build->
			get_url_windows())) printf("<a href=\"%s\" download>", $build->get_url_windows()); ?>
			<a href="https://kuyokibrawl.ru/downloads/KuyokiBrawl_x32.apk">
			<div class='package-con-button'>
				<div class='package-ico-button' style="background: url(/img/icons/list/os-android.png) center / 22px no-repeat;">
				</div>
				<div class='package-tx1-button'>
					<span>32 bit</span>
					<br>
					<span class='package-tx2-metabutton'>
					</span>
				</div>
			</div>
			<?php
			if (isset($build) && !is_null($build->get_url_windows()))
				printf("</a>");
			?>
			<?php
			if (false /*isset($build) && !is_null($build->get_url_windows_arm64())*/)
				printf("<a href=\"%s\" download>", $build->get_url_windows_arm64());
			?>
				</div>
			</div>
			<?php
			if (isset($build) && !is_null($build->
			get_url_windows())) printf("</a>"); ?>
		</div>
	</div>
</div>