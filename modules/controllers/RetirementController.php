<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\controllers;

/**
 * Description of RetirementController
 *
 * @author Victor Mataba <vmataba0@gmail.com>
 */
use yii\rest\ActiveController;
use yii\filters\VerbFilter;
use app\models\FinancialRequest;
use app\models\Retirement;
use yii\helpers\Json;

class RetirementController extends ActiveController {

    public $modelClass = 'app\models\TempRetirement';

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                    'retire' => ['post'],
                    'view' => ['get'],
                    'index' => ['get']
                ],
            ]
        ];
    }

    public function actionRetire($financialRequestId) {



        \Yii::$app->response->statusCode = 200;

        $request = FinancialRequest::findOne($financialRequestId);

        if ($request !== null) {

            $retirement = new Retirement();
            $retirement->financial_request_id = $request->id;
            $retirement->amount = \Yii::$app->request->post('amount');
            $retirement->description = \Yii::$app->request->post('description');
            $retirement->receipt = Retirement::RECEIPT_PATH . 'Request-' . $request->id . '-' . date('Y-m-d H:i:s') . '.PNG';
            $retirement->created_at = date('Y-m-d H:i:s');
            //Temporary
            //return \Yii::$app->request->post('encodedReceipt');

            if ($retirement->save()) {
                $this->saveAttachment($retirement->receipt, \Yii::$app->request->post('encodedReceipt'));
                return Json::encode([
                            'type' => 1,
                            'message' => 'Success',
                            'pendingAmount' => $request->getPendingAmount()
                ]);
            }
            return Json::encode([
                        'type' => 0,
                        'message' => 'Error',
                        'errors' => $retirement->errors
            ]);
        }
        return Json::encode([
                    'type' => 0,
                    'message' => 'Financial request is not found'
        ]);
    }

    private function saveAttachment($path, $encodedFile) {
        file_put_contents($path, base64_decode($encodedFile));
    }

}
