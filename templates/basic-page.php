<?php namespace ProcessWire; ?>

<div id='hero' data-pw-prepend>
	<link rel="stylesheet" href="<?= urls('templates') ?>assets/css/basic-page.css">
</div>

<?php if (page()->hasChildren()): ?>

<div id="content-body" pw-append>

	<h3><?= setting('more-pages') ?></h3>

	<div class='page-children flex-center' style='flex-wrap: wrap'>

		<?php foreach (page()->children() as $item): ?>
			<div class="card-default">
				<a  href='<?= $item->url ?>'>
					<h4><?= $item->title ?></h4>
					<?= page()->if("meta_title", "<p class='right-hero'>{meta_title}</p>") ?>
				</a>
			</div>
		<?php endforeach; ?>

	</div>

</div>

<?php endif;
