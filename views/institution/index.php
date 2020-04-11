<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InstitutionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Institutions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="institution-index">


    <p>
        <?= Html::a('Add New Institution', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

                  ['attribute' =>  'id','filterInputOptions' => ['placeholder' => 'Search...','class' => 'form-control']],
          ['attribute' =>  'institution_code','filterInputOptions' => ['placeholder' => 'Search...','class' => 'form-control']],
          ['attribute' =>  'subsp_code','filterInputOptions' => ['placeholder' => 'Search...','class' => 'form-control']],
          ['attribute' =>  'institution_name','filterInputOptions' => ['placeholder' => 'Search...','class' => 'form-control']],
          ['attribute' =>  'logo','filterInputOptions' => ['placeholder' => 'Search...','class' => 'form-control']],
            //'logo_height',
            //'logo_width',
            //'banner',
            //'instructions:ntext',
            //'instructions_pg:ntext',
            //'contact_details:ntext',
            //'home_page:ntext',
            //'pay_bank_instructions:ntext',
            //'pay_bank_instructions_pg:ntext',
            //'min_prog_direct',
            //'max_prog_direct',
            //'min_prog_equivalent',
            //'max_prog_equivalent',
            //'min_programme',
            //'max_programme',
            //'support_email1:email',
            //'support_email2:email',
            //'support_email3:email',
            //'support_phone1',
            //'support_phone2',
            //'support_phone3',
            //'applicant_home_page:ntext',
            //'application_deadline',
            //'activate_account_email:ntext',
            //'referee_email:ntext',
            //'application_close_reminder:ntext',
            //'not_selected_email:ntext',
            //'selected_email:ntext',
            //'payment_confirmed_email:ntext',
            //'account_activated_message:ntext',
            //'banner_color',
            //'application_status',
            //'application_status_remarks',
            //'application_status_pg',
            //'application_status_remarks_pg',
            //'tcu_username',
            //'tcu_key',
            //'current_round',
            //'confirmation_status',
            //'admiss_letter_ug:ntext',
            //'admiss_letter_pg:ntext',
            //'publish_status_pg',
            //'show_pg_tab',
            //'created_at',
            //'closed_by',
            //'updated_at',
            //'updated_by',

        ['class' => 'yii\grid\ActionColumn'],
        ],
        ]); ?>
    
    
</div>
