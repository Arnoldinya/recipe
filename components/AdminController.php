<?php

namespace app\components;

use yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Class AdminController
 * @package app\components
 */
class AdminController extends Controller
{
    /**
     * @var array Options for body tag in view layout.
     */
    public $bodyOptions = [];

    //public $layout = '/admin';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
}
