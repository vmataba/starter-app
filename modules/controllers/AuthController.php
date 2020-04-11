<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\controllers;

/**
 * Description of Auth
 *
 * @author Victor Mataba <vmataba0@gmail.com>
 */
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use app\models\Employee;

class AuthController extends \yii\rest\ActiveController {

    //For testing 

    public $modelClass = 'app\models\EmployeeUser';

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'sync-account-details'],
                'rules' => [
                    [
                        'actions' => ['login', 'sync-account-details'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'login' => ['post'],
                    'update' => ['post'],
                ],
            ],
        ];
    }

    public function actions() {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['view']);
        unset($actions['delete']);
        return $actions;
    }

    public function actionLogin() {

        $username = \Yii::$app->request->post('username');
        $password = \Yii::$app->request->post('password');

        $model = Employee::findByEmail($username);

        \Yii::$app->response->statusCode = 200;

        if ($model !== null && $model->validatePassword($password)) {

            $model->text_salutation = $model->getSalutation()->name;

            return Json::encode([
                        "type" => 1,
                        "message" => "Success",
                        "employee" => $model
            ]);
        } else {

            return Json::encode([
                        "type" => 0,
                        "message" => "Incorrect Username or Password"
            ]);
        }
    }

    public function actionSync() {

        $username = \Yii::$app->request->post('username');


        $model = Employee::findByEmail($username);

        \Yii::$app->response->statusCode = 200;

        if ($model !== null) {

            $model->text_salutation = $model->getSalutation()->name;

            return Json::encode([
                        "type" => 1,
                        "message" => "Success",
                        "employee" => $model
            ]);
        }
    }
    
    public function actionUpdate(){
        
        $username = \Yii::$app->request->post('username');
        
        $model = Employee::findByEmail($username);
        
        if ($model !== null){
            
            $password = \Yii::$app->request->post('password');
            $model->password = \Yii::$app->getSecurity()->generatePasswordHash($password);
            
            if ($model->save()){
                
                return Json::encode([
                    'type' => 1,
                    'message' => 'Success'
                ]);
                
            }
            
            
        }
    }

}
