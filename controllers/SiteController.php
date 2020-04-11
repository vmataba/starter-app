<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use yii\helpers\Url;

class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
        }
        $currentUser = User::findOne(Yii::$app->user->id);

        /* Inactive user */
        if (!$currentUser->isActive() && $this->route !== 'user/inactive') {
            return $this->redirect(['user/inactive', 'id' => $currentUser->id]);
        }
        /* User with default password */
        if ($currentUser->hasDefaultPassword() && $this->route !== 'user/update-password') {
            return $this->redirect(['user/update-password', 'id' => $currentUser->id]);
        }
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() {
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
            return $this->goHome();
        }

        $model->password = '';
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    public function goHome() {
        $currentUser = User::findOne(\Yii::$app->user->id);
        if ($currentUser->hasDefaultPage()) {
            return $this->redirect(Url::to([$currentUser->getDefaultSystemRoute()->getRoute()]));
        }
        return parent::goHome();
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();
        if (isset(Yii::$app->getSession()['partialSupportingDocument']['completePath']) && is_file(Yii::$app->getSession()['partialSupportingDocument']['completePath'])) {
            unlink(Yii::$app->getSession()['partialSupportingDocument']['completePath']);
        }
        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact() {
        $currentUser = User::findOne(Yii::$app->user->id);
        if ($currentUser->hasDefaultPassword() && $this->route !== 'user/update-password') {
            return $this->redirect(['user/update-password', 'id' => $currentUser->id]);
        }

        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
                    'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout() {
        $currentUser = User::findOne(Yii::$app->user->id);
        if ($currentUser->hasDefaultPassword() && $this->route !== 'user/update-password') {
            return $this->redirect(['user/update-password', 'id' => $currentUser->id]);
        }

        return $this->render('about');
    }

//    public function actionAddUser() {
//        $model = new User();
//
//        $model->username = 'admin';
//        $model->password = \Yii::$app->getSecurity()->generatePasswordHash('12345');
//        $model->auth_key = \Yii::$app->getSecurity()->generateRandomString();
//        $model->access_token = \Yii::$app->getSecurity()->generateRandomString();
//        $model->salutation = 1;
//        $model->first_name = 'Victor';
//        $model->surname = 'Mataba';
//        $model->phone = '+255765909090';
//        $model->email = 'vmataba0@gmail.com';
//        $model->company_level = 1;
//
//        if ($model->validate()) {
//            $model->save();
//            return 'Success';
//        }
//        return \yii\helpers\Json::encode($model->errors);
//    }

    public function actionLogMeOut() {
        if (isset(Yii::$app->getSession()['partialSupportingDocument']['completePath']) && is_file(Yii::$app->getSession()['partialSupportingDocument']['completePath'])) {
            unlink(Yii::$app->getSession()['partialSupportingDocument']['completePath']);
        }
        \Yii::$app->user->logout();
        return $this->redirect(['index']);
    }

//   public function sayHello(){
//       $model = User::findOne(1);
//       $model->password = \Yii::$app->getSecurity()->generatePasswordHash('12345');
//       $model->save();
//   }
}
