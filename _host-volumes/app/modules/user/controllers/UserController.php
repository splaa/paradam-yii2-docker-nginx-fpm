<?php
namespace app\modules\user\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class UserController extends Controller
{
	public function behaviors()
	{
		return [
			'access' =>[
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['login', 'register', 'forgotten'],
						'allow' =>true,
					],
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}
}