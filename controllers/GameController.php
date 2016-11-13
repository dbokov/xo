<?php

namespace dbokov\xo\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use dbokov\xo\components\Game;

class GameController extends Controller
{
    // game instance
    private $game;

    public function beforeAction($action)
    {
        $this->game = Game::getInstance();
        return true;
    }

    public function actionIndex()
    {
        $size = Yii::$app->request->get('size') ?  Yii::$app->request->get('size') : 6;
        $this->game->setFieldSize($size);
        $this->game->start();
        return $this->render('@vendor/dbokov/xo/views/game/index',['size'=>$size]);
    }

    public function actionTurn()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $x = Yii::$app->request->post('x');
        $y = Yii::$app->request->post('y');

        if(is_null($x) || is_null($y))
        {
            return ['status' => 'bad turn'];
        }

        $turn = $this->game->turn($x,$y,'x');

        if(is_array($turn))
        {
            $ret['status'] = 'ok';
            $ai_turn = $this->game->doAiTurn();
            if(is_array($ai_turn)) $ret['ai_turn'] = $ai_turn;
            else $ret['status'] = 'lost';
        }
        else
        {
            $ret['status'] = $turn;
        }

        return $ret;

    }


}
