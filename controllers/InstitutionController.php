<?php

namespace app\controllers;

use app\models\Institution;
use app\models\InstitutionSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\FileType;
use app\assets\tools\FileUploader;
use app\models\File;
use app\assets\tools\Tool;
use app\assets\DataDefinition;

/**
 * InstitutionController implements the CRUD actions for Institution model.
 */
class InstitutionController extends BaseController {

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
     * Lists all Institution models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new InstitutionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Institution::hasInstance()) {
            return $this->redirect(['view', 'id' => Institution::getInstance()->id]);
        }

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Institution model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Institution model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Institution();
        $model->created_at = date('Y-m-d H:i:s');
        $model->created_by = \Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->uploadLogo($model);
            Yii::$app->getSession()->setFlash('success', 'Insitution has been successfully created');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Institution model.
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
            $this->uploadLogo($model);
            Yii::$app->getSession()->setFlash('success', 'Insitution Details have been successfully updated');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Institution model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Institution model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Institution the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Institution::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function uploadLogo(Institution $model) {
        $fileType = FileType::findOne(['code' => FileType::CODE_INSTITUTION_LOGOS]);
        $fileUploadResponse = FileUploader::uploadFile('nativeFileInput', $fileType->path, false, 'institution_logo');
        if (!empty($fileUploadResponse['completePath'])) {
            $model->logo = $fileUploadResponse['completePath'];

            $file = new File();
            $file->file_type_id = $fileType->id;
            $file->file_type = $fileUploadResponse['fileExtension'];
            $file->name = $fileUploadResponse['usedName'];
            $file->ip_address = Tool::getClientIpAddress();
            $file->browser_description = Tool::getBrowserInfo();
            $file->is_active = DataDefinition::BOOLEAN_TYPE_YES;
            $file->created_at = date('Y-m-d H:i:s');
            $file->created_by = \Yii::$app->user->id;
            
            if ($file->save()){
                $model->logo_file_id = $file->id;
            }
        }
        if (!empty($model->logo)) {
            $model->save();
        }
    }

}
