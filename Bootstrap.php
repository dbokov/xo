<?php
/**
 * Created by PhpStorm.
 * User: wh1sper
 * Date: 12.11.16
 * Time: 22:43
 */

namespace dbokov\xo;

use \yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    /** @param \yii\web\Application $app */
    public function bootstrap($app)
    {
        $app->controllerMap['game'] = '\dbokov\xo\controllers\GameController';
    }
}