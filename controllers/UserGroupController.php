<?php

namespace app\controllers;

use Yii;
use app\models\UserGroup;
use app\models\UserGroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\assets\DataDefinition;
use yii\widgets\ActiveForm;
use yii\web\Response;
use app\models\CanPerform;
use app\models\GroupMember as GroupMember;
use app\models\SystemRoute;
use yii\helpers\Json;
use app\models\User;

/**
 * UserGroupController implements the CRUD actions for UserGroup model.
 */
class UserGroupController extends BaseController {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserGroup models.
     * @return mixed
     */
    public function actionIndex() {
        unset(\Yii::$app->session['createClonedGroup']);
        unset(\Yii::$app->session['referenceGroup']);
        $searchModel = new UserGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserGroup model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        unset(\Yii::$app->session['createClonedGroup']);
        unset(\Yii::$app->session['referenceGroup']);
        $model = $this->findModel($id);
        $canPerform = new CanPerform();
        $canPerform->group_id = $model->id;
        $canPerform->created_at = date('Y-m-d H:i:s');
        $canPerform->created_by = \Yii::$app->user->id;
        $canPerform->is_active = DataDefinition::BOOLEAN_TYPE_YES;

        $groupMember = new GroupMember();
        $groupMember->group_id = $model->id;
        $groupMember->created_at = date('Y-m-d H:i:s');
        $groupMember->created_by = Yii::$app->user->id;

        if ($groupMember->load(Yii::$app->request->post()) && $groupMember->save()) {

            Yii::$app->getSession()->setFlash('success', $groupMember->getUser()->getFullName() . " has been added to " . $model->name . " group");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        if ($canPerform->load(\Yii::$app->request->post())) {

            if (!$canPerform->save()) {
                return \yii\helpers\Json::encode($canPerform->errors);
            }

            \Yii::$app->getSession()->setFlash('success', 'Route has been added to ' . $canPerform->getGroup()->name);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'canPerform' => $canPerform,
                    'groupMember' => $groupMember
        ]);
    }

    /**
     * Creates a new UserGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new UserGroup();

        if (isset(\Yii::$app->session['createClonedGroup']) || isset(\Yii::$app->session['referenceGroup'])) {

            $referenceGroup = \Yii::$app->session['referenceGroup'];
            $model->name = 'Copy of ' . $referenceGroup->name;
            $model->description = 'Copy of ' . $referenceGroup->name . ' group description';
            $model->is_active = $referenceGroup->is_active;
        }


        $model->created_at = date('Y-m-d H:i:s');
        $model->created_by = \Yii::$app->user->id;
        $model->is_active = DataDefinition::BOOLEAN_STATUS_ACTIVE;
        $model->code = UserGroup::getUniqueCode();

        if ($model->load(\Yii::$app->request->post()) && \Yii::$app->request->isAjax) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (isset(\Yii::$app->session['createClonedGroup']) || isset(\Yii::$app->session['referenceGroup'])) {
                $this->clone($model);
                unset(\Yii::$app->session['createClonedGroup']);
                unset(\Yii::$app->session['referenceGroup']);
            }

            \Yii::$app->getSession()->setFlash('success', 'User Group has been successfully created');

            return $this->redirect(['view','id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $model->updated_at = date('Y-m-d H:i:s');
        $model->updated_by = \Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            \Yii::$app->getSession()->setFlash('success', 'User Group has been successfully updated');

            return $this->redirect(['view','id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserGroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);

        if (!$model->canBeDeleted()) {
            Yii::$app->getSession()->setFlash('warning', 'Sorry, this user group can not be deleted!');
            return $this->redirect(['index']);
        }
        if ($model->delete()) {
            Yii::$app->getSession()->setFlash('success', 'Record has been successfully deleted');
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the UserGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = UserGroup::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDeactivateAssignment($id, $assignmentId) {
        $model = $this->findModel($id);
        $assignment = CanPerform::findOne($assignmentId);
        if ($assignment !== null) {
            $assignment->is_active = DataDefinition::BOOLEAN_TYPE_NO;
            if ($assignment->save()) {
                \Yii::$app->getSession()->setFlash('success', 'Deactivation process has succeeded');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        \Yii::$app->getSession()->setFlash('warning', 'This user does not exist in a given group');
        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionDeactivateMember($id, $membershipId) {
        $model = $this->findModel($id);
        $member = GroupMember::findOne($membershipId);
        if ($member !== null) {
            $member->is_active = DataDefinition::BOOLEAN_TYPE_NO;
            if ($member->save()) {
                \Yii::$app->getSession()->setFlash('success', 'Deactivation process has succeeded');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        \Yii::$app->getSession()->setFlash('warning', 'This member does not exist in a this group');
        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionActivateAssignment($id, $assignmentId) {
        $model = $this->findModel($id);
        $assignment = CanPerform::findOne($assignmentId);
        if ($assignment !== null) {
            $assignment->is_active = DataDefinition::BOOLEAN_TYPE_YES;
            if ($assignment->save()) {
                \Yii::$app->getSession()->setFlash('success', 'Activation process has succeeded');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        \Yii::$app->getSession()->setFlash('warning', 'This user does not exist in a given group');
        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionActivateMember($id, $membershipId) {
        $model = $this->findModel($id);
        $member = GroupMember::findOne($membershipId);
        if ($member !== null) {
            $member->is_active = DataDefinition::BOOLEAN_TYPE_YES;
            if ($member->save()) {
                \Yii::$app->getSession()->setFlash('success', 'Activation process has succeeded');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        \Yii::$app->getSession()->setFlash('warning', 'This member does not exist in a given group');
        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionUpdateAccess($groupId, $routeId, $command) {
        $systemRoute = SystemRoute::findOne($routeId);
        $group = UserGroup::findOne($groupId);
        if ($systemRoute === null || $group === null) {
            return Json::encode([
                        'type' => 0,
                        'message' => 'System Route/User group does not exist'
            ]);
        }

        $access = CanPerform::findOne([
                    'group_id' => $group->id,
                    'system_route_id' => $systemRoute->id
        ]);

        if ($access === null) {
            $access = new CanPerform();
        }


        if ($command === 'ADD') {

            if (!$access->isNewRecord) {
                $access->is_active = DataDefinition::BOOLEAN_TYPE_YES;
                $access->updated_at = date('Y-m-d H:i:s');
                $access->updated_by = Yii::$app->user->id;
                return Json::encode([
                            'type' => $access->save() ? 1 : 0,
                            'errors' => $access->errors
                ]);
            } else {
                $access->system_route_id = $systemRoute->id;
                $access->group_id = $group->id;
                $access->created_by = Yii::$app->user->id;
                $access->created_at = date('Y-m-d H:i:s');
                $access->is_active = DataDefinition::BOOLEAN_TYPE_YES;
                return Json::encode([
                            'type' => $access->save() ? 1 : 0,
                            'errors' => $access->errors
                ]);
            }
        } else if ($command === 'REMOVE') {

            $access->is_active = DataDefinition::BOOLEAN_TYPE_NO;
            $access->updated_at = date('Y-m-d H:i:s');
            $access->updated_by = Yii::$app->user->id;
            return Json::encode([
                        'type' => $access->save() ? 1 : 0,
                        'errors' => $access->errors
            ]);
        }
    }

    public function actionUpdateMembership($groupId, $userId, $command) {
        $group = UserGroup::findOne($groupId);
        $user = User::findOne($userId);
        if ($group === null || $user === null) {
            return Json::encode([
                        'type' => 0,
                        'message' => 'User/User group does not exist'
            ]);
        }

        $membership = GroupMember::findOne([
                    'group_id' => $group->id,
                    'user_id' => $user->id
        ]);

        if ($membership === null) {
            $membership = new GroupMember();
        }

        if ($command === 'ADD') {

            if (!$membership->isNewRecord) {
                $membership->is_active = DataDefinition::BOOLEAN_TYPE_YES;
                $membership->updated_at = date('Y-m-d H:i:s');
                $membership->updated_by = Yii::$app->user->id;
                return Json::encode([
                            'type' => $membership !== null && $membership->delete() ? 1 : 0,
                            'errors' => $membership !== null ? $membership->errors : []
                ]);
            } else {
                $membership->user_id = $user->id;
                $membership->group_id = $group->id;
                $membership->created_by = Yii::$app->user->id;
                $membership->created_at = date('Y-m-d H:i:s');
                $membership->is_active = DataDefinition::BOOLEAN_TYPE_YES;
                return Json::encode([
                            'type' => $membership->save() ? 1 : 0,
                            'errors' => $membership->errors
                ]);
            }
        } else if ($command === 'REMOVE') {

            $membership->is_active = DataDefinition::BOOLEAN_TYPE_NO;
            $membership->deactivated_by = Yii::$app->user->id;
            $membership->deactivated_at = date('Y-m-d H:i:s');

            return Json::encode([
                        'type' => $membership !== null && $membership->delete() ? 1 : 0,
                        'errors' => $membership !== null ? $membership->errors : []
            ]);
        }
    }

    public function actionUpdateIndexes() {
        $accesses = CanPerform::find()->all();
        Yii::$app->db->createCommand("TRUNCATE TABLE `can_perform`")->execute();
        foreach ($accesses as $access) {

            $model = new CanPerform();
            $model->group_id = $access->group_id;
            $model->system_route_id = $access->system_route_id;
            $model->created_at = $access->created_at;
            $model->created_by = $access->created_by;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->id;
            $model->save();
        }

        Yii::$app->getSession()->setFlash('success', 'Process has completed');
        return $this->redirect(['index']);
    }

    public function actionClone($id) {
        $model = $this->findModel($id);
        \Yii::$app->session['createClonedGroup'] = true;
        \Yii::$app->session['referenceGroup'] = $model;
        return $this->redirect(['create']);
    }

    protected function clone(UserGroup $model) {
        if (!isset(\Yii::$app->session['createClonedGroup']) || !isset(\Yii::$app->session['referenceGroup']) || $model === null) {
            return false;
        }
        $referenceGroup = \Yii::$app->session['referenceGroup'];
        return $this->copyUsers($referenceGroup, $model) && $this->copyRoutes($referenceGroup, $model);
    }

    private function copyUsers(UserGroup $source, UserGroup $destination) {
        $feedback = true;
        foreach (GroupMember::find()->where(['group_id' => $source->id])->all() as $member) {
            $membership = new GroupMember();
            $membership->user_id = $member->user_id;
            $membership->group_id = $destination->id;
            $membership->created_at = date('Y-m-d H:i:s');
            $membership->created_by = \Yii::$app->user->id;
            $membership->is_active = $member->is_active;
            $membership->deactivated_by = $member->deactivated_by;
            $membership->deactivated_at = $member->deactivated_at;
            $feedback &= $membership->save();
        }
        return $feedback;
    }

    private function copyRoutes(UserGroup $source, UserGroup $destination) {
        $feedback = true;

        foreach (CanPerform::find()->where(['group_id' => $source->id])->all() as $access) {
            $canPerform = new CanPerform();
            $canPerform->group_id = $destination->id;
            $canPerform->system_route_id = $access->system_route_id;
            $canPerform->created_at = date('Y-m-d H:i:s');
            $canPerform->created_by = \Yii::$app->user->id;
            $canPerform->is_active = $access->is_active;
            $feedback &= $canPerform->save();
        }

        return $feedback;
    }

}
