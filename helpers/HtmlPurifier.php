<?php 

namespace worstinme\forum\helpers;

use Yii;

class HtmlPurifier extends \yii\helpers\HtmlPurifier
{
	public static function filter($content, $config = null) {

		return static::process($content,function ($config) {
			$config->set('HTML.Allowed','p,b,strong,em,del,img[src],br,hr,u');
		  	$config->getHTMLDefinition(true)->addAttribute('img', 'data-type', 'Text');
		});

	}
}