<?php

namespace materodev\yii2emailobfuscator;

use yii\base\Widget;
use yii\helpers\Html;
use yii\validators\EmailValidator;
use yii\web\HttpException;

/**
 * Class Obfuscator
 * @package materodev\yii2emailobfuscator
 */
class EmailObfuscator extends Widget
{
    public $email;
    public $useMicrodata = false;

    /**
     * Initializes the widget.
     * @throws HttpException
     */
    public function init()
    {
        parent::init();

        if (!$this->email || !(new EmailValidator())->validate($this->email)) {
            throw new HttpException(500, 'The email you specified is not valid.');
        }
    }

    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     */
    public function run()
    {
        $email = Html::encode($this->email);
        $atIndex = strpos($email, '@');
        $email = str_replace('@', '', $email);
        $rotMail = str_rot13($email);

        return '
<script type="text/javascript">
    var action = ":otliam".split("").reverse().join("");
    var href = "' . $rotMail . '".replace(/[a-zA-Z]/g, function(c){return String.fromCharCode((c <= "Z" ? 90 : 122) >= (c = c.charCodeAt(0) + 13) ? c : c-26);});
    href = href.substr(0, ' . $atIndex . ') + String.fromCharCode(4*2*2*4) + href.substr(' . $atIndex . ');
    var a = "<a ' . ($this->useMicrodata ? 'itemprop=\"email\"' : '') . ' href=\"" + action + href + "\">" + href + "</a>";
    document.write(a);
</script>';
    }
}
