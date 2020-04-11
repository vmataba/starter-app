<?php

namespace app\controllers;

use Yii;
use app\models\InstitutionStructure;
use app\models\InstitutionStructureSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\FileType;
use app\assets\tools\FileUploader;
use app\models\File;
use app\assets\tools\Tool;
use app\assets\DataDefinition;

/**
 * InstitutionStructureController implements the CRUD actions for InstitutionStructure model.
 */
class InstitutionStructureController extends BaseController {

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
     * Lists all InstitutionStructure models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new InstitutionStructureSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InstitutionStructure model.
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
     * Creates a new InstitutionStructure model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new InstitutionStructure();

        $model->created_at = date('Y-m-d H:i:s');
        $model->created_by = Yii::$app->user->id;
        $model->logo = InstitutionStructure::getDefaultLogo();
        $model->logo2 = InstitutionStructure::getDefaultLogo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->uploadFile($model, 'nativeLogoInput', true);
            $this->uploadFile($model, 'nativeLogo2Input', false);

            \Yii::$app->getSession()->setFlash('success', 'Institution structure has been successfully created');

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing InstitutionStructure model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $model->updated_at = date('Y-m-d H:i:s');
        $model->updated_by = \Yii::$app->user->id;

        if (empty($model->logo)) {
            $model->logo = InstitutionStructure::getDefaultLogo();
        }
        if (empty($model->logo2)) {
            $model->logo2 = InstitutionStructure::getDefaultLogo();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->uploadFile($model, 'nativeLogoInput', true);
            $this->uploadFile($model, 'nativeLogo2Input', false);

            \Yii::$app->getSession()->setFlash('success', 'Institution structure has been successfully updated');

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing InstitutionStructure model.
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
     * Finds the InstitutionStructure model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InstitutionStructure the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = InstitutionStructure::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function uploadFile($model, $fileInputName, $isLogo1 = true) {
        $fileType = FileType::findOne(['code' => FileType::CODE_INSTITUTION_STRUCTURE_LOGOS]);
        $fileUploadResponse = FileUploader::uploadFile($fileInputName, $fileType->path, false);
        if (!empty($fileUploadResponse['completePath'])) {

            $file = new File();
            $file->file_type_id = $fileType->id;
            $file->file_type = $fileUploadResponse['fileExtension'];
            $file->name = $fileUploadResponse['usedName'];
            $file->ip_address = Tool::getClientIpAddress();
            $file->browser_description = Tool::getBrowserInfo();
            $file->is_active = DataDefinition::BOOLEAN_TYPE_YES;
            $file->created_at = date('Y-m-d H:i:s');
            $file->created_by = \Yii::$app->user->id;
            $file->save();

            if ($isLogo1) {
                $model->logo = $fileUploadResponse['completePath'];
                $model->logo_file_id = $file->id;
            } else {
                $model->logo2 = $fileUploadResponse['completePath'];
                $model->logo2_file_id = $file->id;
            }

            $model->updated_at = date('Y-m-d H:i:s');
            $model->updated_by = \Yii::$app->user->id;

            $model->save();
        }
    }

}
