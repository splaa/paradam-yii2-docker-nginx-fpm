<?php
/* @var $subscribe_id integer */
?>

<?php if ($subscribe_id): ?>
	<img src="<?= Yii::getAlias('@web') ?>/images/paradam/star_w_fill.svg" alt="">
<?php else: ?>
	<img src="<?= Yii::getAlias('@web') ?>/images/paradam/star_w.svg" alt="">
<?php endif; ?>