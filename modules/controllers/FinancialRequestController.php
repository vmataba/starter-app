<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\controllers;

/**
 * Description of FinancialRequestController
 *
 * @author Victor Mataba <vmataba0@gmail.com>
 */
use app\models\FinancialRequest;
use app\models\FinancialRequestItem as RequestItem;
use yii\helpers\Json;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\FinancialRequestState as RequestState;
use app\assets\DataDefinition;
use app\models\Employee;
use app\models\User;
use app\models\FinancialRequestConversation as Conversation;
use app\models\CompanyLevelAction;
use app\models\CompanyLevel;
use app\assets\tools\Tool;

class FinancialRequestController extends \yii\rest\ActiveController {

    public $modelClass = 'app\models\FinancialRequest';

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'view', 'index'],
                'rules' => [
                    [
                        'actions' => ['create', 'view', 'index', 'remarks', 'add-remark'],
                        'allow' => true,
                        'roles' => ['@', '?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                    'view' => ['get'],
                    'index' => ['get'],
                    'remarks' => ['get'],
                    'items' => ['get'],
                    'add-remark' => ['post']
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

    public function actionIndex($employeeId) {
        $requests = FinancialRequest::find()->where(['requested_by' => $employeeId])->orderBy(['last_updated' => SORT_DESC]);

        \Yii::$app->response->statusCode = 200;

        if ($requests->count() > 0) {

            $allRequests = [];
            foreach ($requests->all() as $singleRequest) {


                $singleRequest->last_updated = Tool::getFormattedDate($singleRequest->last_updated, false);
                $singleRequest->text_amount = number_format($singleRequest->amount, 2);
                $singleRequest->text_issued_amount = number_format($singleRequest->issued_amount, 2);
                $singleRequest->pending_amount = $singleRequest->getPendingAmount();
                $singleRequest->text_pending_amount = number_format($singleRequest->getPendingAmount(), 2);
                $singleRequest->retired_amount = $singleRequest->getRetiredAmount();
                $singleRequest->text_retired_amount = number_format($singleRequest->getRetiredAmount(), 2);
                array_push($allRequests, $singleRequest);
            }

            return Json::encode([
                        'type' => 1,
                        'message' => 'Success',
                        'requests' => $allRequests
            ]);
        } else {
            return Json::encode([
                        'type' => 0,
                        'message' => 'No records were found'
            ]);
        }
    }

    public function actionView($id) {
        $model = FinancialRequest::findOne($id);


        \Yii::$app->response->statusCode = 200;
        if ($model !== null) {

            $model->last_updated = Tool::getFormattedDate($model->last_updated, false);
            $model->text_amount = number_format($model->amount, 2);
            $model->text_issued_amount = number_format($model->issued_amount, 2);
            $model->pending_amount = $model->getPendingAmount();
            $model->text_pending_amount = number_format($model->getPendingAmount(), 2);
            $model->retired_amount = $model->getRetiredAmount();
            $model->text_retired_amount = number_format($model->getRetiredAmount(), 2);

            return Json::encode([
                        'type' => 1,
                        'message' => 'Success',
                        'request' => $model
            ]);
        }
        return Json::encode([
                    'type' => 0,
                    'message' => 'Record is not found'
        ]);
    }

    public function actionCreate() {

        \Yii::$app->response->statusCode = 200;


        if (!empty(\Yii::$app->request->post())) {


            $employee = Employee::findOne(\Yii::$app->request->post('requested_by'));
            if ($employee === null) {
                return Json::encode([
                            'type' => 0,
                            'message' => 'No Employee with ID: ' . \Yii::$app->request->post('requested_by')
                ]);
            }

            $model = new FinancialRequest();
            $model->amount = \Yii::$app->request->post('amount');
            $model->remarks = \Yii::$app->request->post('remarks');
            $model->status = RequestState::TYPE_INITIATE;
            $model->is_approved = DataDefinition::BOOLEAN_TYPE_NO;
            $model->requested_by = \Yii::$app->request->post('requested_by');
            $model->requested_at = date('Y-m-d H:i:s');
            $model->last_updated = date('Y-m-d H:i:s');

            if ($model->save()) {

                /*
                 * Add Request Items
                 */
                foreach (json_decode(\Yii::$app->request->post('items'), true) as $requestItem) {

                    $item = new RequestItem();
                    $item->financial_request_id = $model->id;
                    $item->amount = $requestItem['amount'];
                    $item->description = $requestItem['description'];
                    $item->created_at = date('Y-m-d H:i:s');
                    $item->save();
                }

                /*
                 * Create the first conversation history
                 */
                $conversation = new Conversation();
                $conversation->financial_request_id = $model->id;
                $initiateState = RequestState::findOne(['type' => RequestState::TYPE_INITIATE]);

                $employeeLevel = CompanyLevel::findOne(['rank' => CompanyLevel::MIN_RANK]);
                $initiateAction = CompanyLevelAction::findOne([
                            'company_level_id' => $employeeLevel->id,
                            'financial_request_state_id' => $initiateState->id,
                            'is_active' => DataDefinition::BOOLEAN_TYPE_YES
                ]);

                $conversation->company_level_action_id = $initiateAction->id;
                $conversation->is_request_issuer = DataDefinition::BOOLEAN_TYPE_YES;
                $conversation->words = $model->remarks;
                $conversation->employee_id = $model->requested_by;
                $conversation->created_at = date('Y-m-d H:i:s');

                $conversation->save();



                return Json::encode([
                            'type' => 1,
                            'message' => 'Success',
                            'request' => $model
                ]);
            }
        } else {
            return Json::encode([
                        'type' => 0,
                        'message' => 'No Data was provided'
            ]);
        }
    }

    public function actionRemarks($id) {
        $model = FinancialRequest::findOne($id);

        \Yii::$app->response->statusCode = 200;

        if ($model !== null) {

            if (!$model->hasConversation()) {
                return Json::encode([
                            'type' => 0,
                            'message' => 'No remarks were found'
                ]);
            }

            $remarks = [];

            foreach ($model->getConversation() as $conversation) {
                if ($conversation->postedByUser()) {
                    $user = User::findOne($conversation->user_id);

                    array_push($remarks, [
                        'userFullName' => $user->getFullName(),
                        'userTitle' => $user->getTitle()->description,
                        'userPhoto' => $user->getPhoto(),
                        'status' => $conversation->getAction()->type,
                        'remark' => $conversation->words,
                        'createdAt' => Tool::getFormattedDate($conversation->created_at, false)
                    ]);
                } else {
                    $employee = Employee::findOne($conversation->employee_id);

                    array_push($remarks, [
                        'userFullName' => $employee->getFullName(),
                        'userTitle' => $employee->getTitle()->description,
                        'userPhoto' => $employee->getPhoto(),
                        'status' => $conversation->getAction()->type,
                        'remark' => $conversation->words,
                        'createdAt' => Tool::getFormattedDate($conversation->created_at, false)
                    ]);
                }
            }

            return Json::encode([
                        'type' => 1,
                        'message' => 'Success',
                        'remarks' => $remarks
            ]);
        }
        return Json::encode([
                    'type' => 0,
                    'message' => 'Financial Request does not exist'
        ]);
    }

    public function actionAddRemark($id) {
        $model = FinancialRequest::findOne($id);

        \Yii::$app->response->statusCode = 200;


        if (empty(\Yii::$app->request->post())) {
            return Json::encode([
                        'type' => 0,
                        'message' => 'No Data was Posted'
            ]);
        }

        if ($model !== null) {

            if ($model->status === RequestState::TYPE_APPROVED || $model->status === RequestState::TYPE_REJECTED) {
                return Json::encode([
                            'type' => 0,
                            'message' => 'Request has been closed'
                ]);
            }


            $conversation = new Conversation();
            $conversation->financial_request_id = $model->id;

            $inprogressState = RequestState::findOne(['type' => RequestState::TYPE_INPROGRESS]);
            $employeeLevel = CompanyLevel::findOne(['rank' => CompanyLevel::MIN_RANK]);
            $inprogressAction = CompanyLevelAction::findOne([
                        'company_level_id' => $employeeLevel->id,
                        'financial_request_state_id' => $inprogressState->id,
                        'is_active' => DataDefinition::BOOLEAN_TYPE_YES
            ]);
            $conversation->company_level_action_id = $inprogressAction->id;
            $conversation->is_request_issuer = DataDefinition::BOOLEAN_TYPE_YES;
            $conversation->words = \Yii::$app->request->post('words');
            $conversation->employee_id = \Yii::$app->request->post('employee_id');
            $conversation->created_at = date('Y-m-d H:i:s');



            if ($conversation->save()) {
                /*
                 * Last updated
                 */
                $model->last_updated = date('Y-m-d H:i:s');
                $model->save();

                return Json::encode([
                            'type' => 1,
                            'message' => 'Remarks have been successfully added!'
                ]);
            } else {
                return Json::encode([
                            'type' => 0,
                            'message' => 'Remarks could not be added'
                ]);
            }
        } else {
            return Json::encode([
                        'type' => 0,
                        'message' => 'Financial Request does not exist'
            ]);
        }
    }

    public function actionItems($id) {
        $model = FinancialRequest::findOne($id);

        if ($model !== null) {

            if (!$model->hasItems()) {
                return Json::encode([
                            'type' => 0,
                            'message' => 'No Items were found'
                ]);
            }

            $proccessedItems = [];

            $items = RequestItem::find()->where(['financial_request_id' => $model->id])
                    ->select(['description', 'issued_amount'])
                    ->all();

            foreach ($items as $item) {
                $item->issued_amount = number_format($item->issued_amount, 2);
            }

            return Json::encode([
                        'type' => 1,
                        'message' => 'Succcess',
                        'items' => $items
            ]);
        }
        return Json::encode([
                    'type' => 0,
                    'message' => 'Financial Request does not exist'
        ]);
    }

}
