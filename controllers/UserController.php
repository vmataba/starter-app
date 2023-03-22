<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\FileType;
use app\models\GroupMember;
use app\assets\DataDefinition;
use yii\web\ForbiddenHttpException;
use app\assets\tools\FileUploader;
use yii\helpers\Json;
use app\models\SystemRoute;
use app\models\validators\RecoveryPassword;
use app\models\validators\NewPassword;
use app\models\validators\CurrentPassword;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController {

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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $model = $this->findModel($id);

        $recoveryPassword = new RecoveryPassword();
        if ($recoveryPassword->load(Yii::$app->request->post()) && $recoveryPassword->validate()) {
            $model->password = Yii::$app->getSecurity()->generatePasswordHash($recoveryPassword->password);
            $model->has_default_password = DataDefinition::BOOLEAN_TYPE_YES;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->id;
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Password has been successfully reset');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->getSession()->setFlash('warning', 'There was an error in saving the new password');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('view', [
                    'model' => $model,
                    'recoveryPassword' => $recoveryPassword
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new User();

        $model->auth_key = \Yii::$app->getSecurity()->generateRandomString();
        $model->access_token = \Yii::$app->getSecurity()->generateRandomString();
        $model->created_at = date('Y-m-d H:i:s');
        $model->created_by = \Yii::$app->user->id;

        $model->photo = User::DEFAULT_USER_PHOTO;

        if ($model->load(Yii::$app->request->post())) {

            if (empty($model->password)) {
                $model->password = User::DEFAULT_PASSWORD;
            }

            if (empty($model->photo)) {
                $model->photo = User::DEFAULT_USER_PHOTO;
            }

            $model->password = \Yii::$app->getSecurity()->generatePasswordHash($model->password);

            if ($model->save()) {
                $this->uploadPhoto($model);
                Yii::$app->getSession()->setFlash('success', 'User has been successfully created');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $model->updated_at = date('Y-m-d H:i:s');
        $model->updated_by = \Yii::$app->user->id;



        $old_password = $model->password;
        $model->password = '';

        if ($model->load(Yii::$app->request->post())) {

            if (empty($model->password)) {
                $model->password = $old_password;
            } else {
                $model->password = \Yii::$app->getSecurity()->generatePasswordHash($model->password);
            }

            if ($model->save()) {

                $this->uploadPhoto($model);

                Yii::$app->getSession()->setFlash('success', 'User details have been successfully updated');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionResetPassword($id) {
        $model = $this->findModel($id);
        $model->password = \Yii::$app->getSecurity()->generatePasswordHash(User::DEFAULT_PASSWORD);
        $model->updated_at = date('Y-m-d H:i:s');
        $model->updated_by = \Yii::$app->user->id;
        if ($model->save()) {
            \Yii::$app->getSession()->setFlash('success', 'Password has been successfully reset');
            return $this->redirect(['view', 'id' => $model->id]);
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSayHello() {
        $model = User::findOne(5);

        return \yii\helpers\Json::encode($model->getCompanyLevel()->getActions());
    }

    private function uploadPhoto($model) {
        $fileType = FileType::findOne(['code' => FileType::CODE_PROFILE_PICTURE]);
        $fileUploadResponse = FileUploader::uploadFile('nativeFileInput', $fileType->path, false);
        if (!empty($fileUploadResponse['completePath'])) {
            $model->photo = $fileUploadResponse['completePath'];
        }
        if (!empty($model->photo)) {
            $model->save();
        }
    }

    public function actionDeactivateGroup($id, $membershipId) {
        $model = $this->findModel($id);
        $membership = GroupMember::findOne($membershipId);
        if ($membership !== null) {
            $membership->is_active = DataDefinition::BOOLEAN_TYPE_NO;
            if ($membership->save()) {
                \Yii::$app->getSession()->setFlash('success', 'Deactivation process has succeeded');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        \Yii::$app->getSession()->setFlash('warning', 'This user does not exist in a given group');
        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionActivateGroup($id, $membershipId) {
        $model = $this->findModel($id);
        $membership = GroupMember::findOne($membershipId);
        if ($membership !== null) {
            $membership->is_active = DataDefinition::BOOLEAN_TYPE_YES;
            if ($membership->save()) {
                \Yii::$app->getSession()->setFlash('success', 'Activation process has succeeded');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        \Yii::$app->getSession()->setFlash('warning', 'This user does not exist in a given group');
        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionMyProfile($id = null) {
        if ($id === null) {
            $id = \Yii::$app->user->id;
        }
        $model = $this->findModel($id);

        if (Yii::$app->user->id !== $model->id) {
            throw new ForbiddenHttpException("Access denied! You can not view this Profile.");
        }
        $currentPassword = new CurrentPassword();
        if ($currentPassword->load(Yii::$app->request->post())) {

            if (Yii::$app->getSecurity()->validatePassword($currentPassword->password, $model->password)) {
                return $this->redirect(['update-password', 'id' => $model->id]);
            } else {
                $currentPassword->addError('password', 'Incorrect password');
                $currentPassword->password = '';
                return $this->render('my_profile', [
                            'model' => $model,
                            'currentPassword' => $currentPassword,
                            'showCurrentPasswordModal' => true
                ]);
            }
        }
        return $this->render('my_profile', [
                    'model' => $model,
                    'currentPassword' => $currentPassword,
                    'showCurrentPasswordModal' => false
        ]);
    }

    public function actionLoadDefaultPages($id) {
        $model = User::findOne($id);
        if ($model === null) {
            return Json::encode([
                        'type' => 0,
                        'message' => 'User does not exist'
            ]);
        }
        if (!$model->hasGroups()) {
            return Json::encode([
                        'type' => 0,
                        'message' => 'User does not belong to any group'
            ]);
        }
        $defaultPages = [];

        foreach ($model->getGroups() as $membership) {
            $group = $membership->getGroup();
            foreach ($group->getRoutes() as $access) {
                if (!isset($defaultPages[$access->system_route_id]) && $access->system_route_id != $model->default_system_route_id) {
                    $defaultPages[$access->system_route_id] = $access->getRoute()->pretty_name;
                } else {
                    continue;
                }
            }
        }
        return Json::encode([
                    'type' => 1,
                    'size' => count($defaultPages),
                    'defaultPages' => $defaultPages
        ]);
    }

    public function actionMakeDefaultPage($id, $routeId) {
        $model = User::findOne($id);
        $systemRoute = SystemRoute::findOne($routeId);
        if ($model === null || $systemRoute === null) {
            return Json::encode([
                        'type' => 0,
                        'message' => 'User/System Route Not Found'
            ]);
        }
        $model->default_system_route_id = $systemRoute->id;
        $model->updated_at = date('Y-m-d H:i:s');
        $model->updated_by = \Yii::$app->user->id;
        return Json::encode([
                    'type' => $model->save() ? 1 : 0,
                    'systemRoute' => $systemRoute
        ]);
    }

    public function actionGeneratePassword($size = 8) {
        return Json::encode([
                    'password' => Yii::$app->getSecurity()->generateRandomString($size)
        ]);
    }

    public function actionUpdatePassword($id = null) {
        if ($id === null) {
            $id = Yii::$app->user->id;
        }
        $model = $this->findModel($id);
        $newPassword = new NewPassword();

        if ($newPassword->load(Yii::$app->request->post()) && $newPassword->validate()) {
            $model->password = Yii::$app->getSecurity()->generatePasswordHash($newPassword->newPassword);
            $model->updated_at = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->id;
            $model->has_default_password = DataDefinition::BOOLEAN_TYPE_NO;
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Password has been successfully updated');
                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('warning', 'There was an error in saving password');
                return $this->goHome();
            }
        }
        return $this->render('update_password', [
                    'model' => $model,
                    'newPassword' => $newPassword
        ]);
    }

    public function actionInactive($id) {
        $model = $this->findModel($id);
        return $this->render('inactive', [
                    'model' => $model
        ]);
    }

}
