<?php 

namespace worstinme\forum\helpers;

use Yii;

class HtmlPurifier extends \yii\helpers\HtmlPurifier
{
	public static function filter($content, $config = null) {

		return static::process($content,function ($config) {

			$config->set('HTML.Allowed','p,b,ul,ol,li,strong,em,del,img[src|width|height|style],br,hr,u');

		});

	}
}