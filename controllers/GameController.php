<?php

namespace dbokov\xo\controllers;

use Yii;
use yii\web\Controller;


class GameController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index',['size'=>3]);
    }


}
