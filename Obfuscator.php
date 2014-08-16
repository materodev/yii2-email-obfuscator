<?php
namespace pfarrer\yii2\email;

use yii\web\Widget;
use yii\helpers\Html;

class Obfuscator extends Widget {

	const FEATURE_ALL = 0xFFFFFFFF;

	public $use;
	public $email;
	
	public function init() {
		parent::init();
		
	}
	
	public function run() {
		echo Html::encode($this->email);
	}

}
