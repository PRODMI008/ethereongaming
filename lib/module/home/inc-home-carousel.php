<?php
/*
 * inc-home-carousel.php — Карусель постов на главной
 *
 * Посты теперь читаются из lib/data/posts.json (управляются через admin.php).
 * Старый статичный код трёх постов сохранён ниже в комментарии для истории.
 *
 * Поля одного поста: id, title, thumbnail, animate_class, scale_class, content, tags
 */
require_once __DIR__ . '/../inc-posts.php';
$posts = posts_get_all();
?>
<div class="container fill">
	<div id="myCarousel" class="carousel slide">
		<div class="carousel-inner">
			<?php $is_first = true; ?>
			<?php foreach ($posts as $p): ?>
				<!-- Пост: <?= htmlspecialchars($p['id']) ?> -->
				<div class="item<?= $is_first ? ' active' : '' ?>">
					<div class="fill">
						<div class="video-con-container">
							<div class='video-con-left'>
								<div class='video-con-wrapper'>
									<div class='video-con-animate <?= htmlspecialchars($p['animate_class']) ?>'>
									</div>
									<div class='video-img-thumbnail' style="background: url('<?= htmlspecialchars($p['thumbnail']) ?>') no-repeat center; background-size: cover; pointer-events: none;">
									</div>
								</div>
							</div>
							<div class='video-con-right'>
								<div class="video-tx1-description darkmode-txt <?= htmlspecialchars($p['scale_class']) ?>">
									<div class='video-emp-block'>
									</div>
									<h2><?= posts_render_content($p['content']) ?></h2>
									<h3><?= htmlspecialchars($p['tags']) ?></h3>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php $is_first = false; ?>
			<?php endforeach; ?>

			<?php if (empty($posts)): ?>
				<div class="item active">
					<div class="fill">
						<div class="video-con-container">
							<div class='video-con-right'>
								<div class="video-tx1-description darkmode-txt">
									<h2>Постов пока нет.</h2>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php
/* ============================================================================
 * СТАРЫЙ СТАТИЧНЫЙ КОД ТРЁХ ПОСТОВ (сохранён для истории)
 * Посты перенесены в lib/data/posts.json и теперь управляются через admin.php.
 * ----------------------------------------------------------------------------
 *
 * <div class="container fill">
 * 	<div id="myCarousel" class="carousel slide">
 * 		<div class="carousel-inner">
 * 			<!-- Carousel Slide -->
 * 			<div class="item active">
 * 				<div class="fill">
 * 					<div class="video-con-container">
 * 						<div class='video-con-left'>
 * 							<div class='video-con-wrapper'>
 *								<!-- OLD
 *								<div class="video-btn-play">
 *								</div>
 *								<div class="video-ico-service">
 *								</div>
 *								<div class='video-con-animate page-video-1'>
 *								</div>
 *								<div class='video-img-thumbnail' style="background: url('/img/videos/1.jpg') no-repeat center; background-size: cover;">
 *								<div class="video-img-overlay">
 *								</div>
 *								</div>
 *								-->
 *								<div class='video-con-animate page-video-1'>
 *								</div>
 * 								<div class='video-img-thumbnail' style="background: url('/img/videos/1.jpg') no-repeat center; background-size: cover; pointer-events: none;">
 * 								</div>
 * 							</div>
 * 						</div>
 * 						<div class='video-con-right'>
 * 							<div class="video-tx1-description darkmode-txt scale-content-txt-4">
 * 								<div class='video-emp-block'>
 * 								</div>
 * 								<h2>Мы сообщаем вам,что EthereonGaming и DissGame заключили сотрудничество!🤝
 *
 * 									DissGame — это турнирная организация с опытом и собственным подходом. Вместе мы планируем проводить совместные турниры, расширять форматы и делать события интереснее для игроков
 * 								</h2>
 * 									<h3>#EGWiN #Partners #DissGame</h3>
 *
 * 							</div>
 * 						</div>
 * 					</div>
 * 				</div>
 * 			</div>
 * 			<!-- Carousel Slide -->
 * 			<div class="item">
 * 				<div class="fill">
 * 					<div class="video-con-container">
 * 						<div class='video-con-left'>
 * 							<div class='video-con-wrapper'>
 *								<!-- OLD
 *								<div class="video-btn-play">
 *								</div>
 *								<div class="video-ico-service">
 *								</div>
 *								<div class='video-con-animate page-video-2'>
 *								</div>
 *								<div class='video-img-thumbnail' style="background: url('/img/videos/2.jpg') no-repeat center; background-size: cover;">
 *								<div class="video-img-overlay">
 *								</div>
 *								</div>
 *								-->
 *								<div class='video-con-animate page-video-2'>
 *								</div>
 * 								<div class='video-img-thumbnail' style="background: url('/img/videos/2.jpg') no-repeat center; background-size: cover; pointer-events: none;">
 * 								</div>
 * 							</div>
 * 						</div>
 * 						<div class='video-con-right'>
 * 							<div class="video-tx1-description darkmode-txt scale-content-txt-5">
 * 								<div class='video-emp-block'>
 * 								</div>
 * 								<h2>Мы теперь есть в TikTok!
 * 								Продолжаем осваивать новые соц-сети.
 *
 * 								НА ТЕКСТЕ БУДЕТ ССЫЛКА (https://www.tiktok.com/@ethereongaming?_r=1&_t=ZS-97fdNxhKVAw)
 * 								Через 10 дней нам исполняется уже пол-года! К этому моменту готовим для вас кое-что. </h2>
 *
 * 								<h3> #EGWiN🏆 </h3>
 * 							</div>
 * 						</div>
 * 					</div>
 * 				</div>
 * 			</div>
 * 			<!-- Carousel Slide -->
 * 			<div class="item">
 * 				<div class="fill">
 * 					<div class="video-con-container">
 * 						<div class='video-con-left'>
 * 							<div class='video-con-wrapper'>
 *								<!-- OLD
 *								<div class="video-btn-play">
 *								</div>
 *								<div class="video-ico-service">
 *								</div>
 *								<div class='video-con-animate page-video-3'>
 *								</div>
 *								<div class='video-img-thumbnail' style="background: url('/img/videos/3.jpg') no-repeat center; background-size: cover;">
 *								<div class="video-img-overlay">
 *								</div>
 *								</div>
 *								-->
 *								<div class='video-con-animate page-video-3'>
 *								</div>
 * 								<div class='video-img-thumbnail' style="background: url('/img/videos/3.jpg') no-repeat center; background-size: cover; pointer-events: none;">
 * 								</div>
 * 							</div>
 * 						</div>
 * 						<div class='video-con-right'>
 * 							<div class="video-tx1-description darkmode-txt scale-content-txt-6">
 * 								<div class='video-emp-block'>
 * 								</div>
 * 								<h2>Мы полностью переработали наш эмодзи-пак — и он уже ждёт вас ниже.
 *
 * 								❤️‍🩹 ТУТ БУДЕТ ССЫЛКА
 * 								 (https://t.me/addemoji/EthereonGamingEmojiPack)
 * 								Мы пересматриваем подход к постам и контенту. В ближайшее время поделимся с вами новостями! </h2>
 * 								<h3>#EGWiN🏆</h3>
 * 							</div>
 * 						</div>
 * 					</div>
 * 				</div>
 * 			</div>
 * 		</div>
 * 	</div>
 * </div>
 *
 * ========================================================================== */
?>