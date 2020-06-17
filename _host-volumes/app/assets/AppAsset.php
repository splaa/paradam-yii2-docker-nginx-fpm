<?php
	/**
	 * @link http://www.yiiframework.com/
	 * @copyright Copyright (c) 2008 Yii Software LLC
	 * @license http://www.yiiframework.com/license/
	 */
	
	namespace app\assets;
	
	use yii\web\AssetBundle;

	/**
	 * Main application asset bundle.
	 *
	 * @author Qiang Xue <qiang.xue@gmail.com>
	 * @since 2.0
	 */
	class AppAsset extends AssetBundle
	{
		public $basePath = '@webroot';
		public $baseUrl = '@web';
		public $css = [
			'css/paradam.css',
			'css/flickity.css',
			'css/site.css',
			'css/order.css',
			'css/tooltipster.bundle.min.css',
			'css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-shadow.min.css',
		];
		public $js = [
			'js/flickity.pkgd.min.js',
			'js/jquery.inputmask.min.js',
			'js/tabs.js',
			'js/tooltipster.bundle.min.js',
			'js/main.js',
		];
		public $depends = [
			'yii\web\YiiAsset',
			'yii\bootstrap\BootstrapPluginAsset',
		];
	}
