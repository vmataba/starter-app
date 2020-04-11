<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\models\Institution;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1 style="text-align: center;">

    <?php
    if (Institution::hasInstance()) {

        echo 'Welcome to ' . Institution::getInstance()->institution_name . ' Stater System';
    } else {
        echo 'Welcome to Payroll System';
    }
    ?>
</h1>
<hr>

<style>
    .center{
        margin-left: auto;
        margin-right: auto
    }
</style>

<div class="row">
    <div class="col-md-8">

        <?php if (Institution::hasInstance()): ?>


            <?= Institution::getInstance()->home_page ?>
            <b>Contacts</b>
            <hr>
            <?= Institution::getInstance()->contact_details ?>

        <?php else: ?>

            No contents to display...

        <?php endif; ?>

<!--        <img src="images/loan_1.png" class="img center-block" style="width: 250px; height: 250px;"/>-->
    </div>
    <div class="col-md-4">
        <div class="panel">
            <div class="panel-body">

                <?php if (Institution::hasInstance()): ?>
                    <img src="<?= Institution::getInstance()->logo ?>" class="img center-block" style="width: <?= Institution::getInstance()->logo_width ?>; height: <?= Institution::getInstance()->logo_height ?>"/>
                <?php else: ?>
                    <img src="<?= Institution::getDefaultLogo() ?>" class="img center-block" style="width: <?= Institution::DEFAULT_LOGO_WIDTH ?>; height: <?= Institution::DEFAULT_LOGO_HEIGHT ?>"/>
                <?php endif; ?>

                <div class="header">
                    <p class="lead">Login to your account</p>
                </div>

                <div class="card-body">
                    <?php
                    $form = ActiveForm::begin([
                                'id' => 'login-form',
                                'options' => [
                                    'class' => 'form-auth-small'
                                ]
                    ]);
                    ?>

                    <div class="form-group">
                        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Enter username...']) ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Enter password...']) ?>
                    </div>

                    <p>
                        Username: <code>admin</code>
                        Password: <code>123456</code>
                    </p>
                    
                    <div class="form-group">

                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary form-control', 'name' => 'login-button']) ?>

                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

    </div>
</div>
