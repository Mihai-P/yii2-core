<?php

use yii\helpers\Html;
use core\widgets\GridView;

/**
 * @var yii\web\View $this
 * @var core\models\AdministratorSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Administrators';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="administrator-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'Group_id',
            'username',
            'is_admin',
            // 'password',
            // 'password_hash',
            // 'password_reset_token',
            // 'auth_key',
            // 'last_visit_time',
            // 'name',
            // 'firstname',
            // 'lastname',
            // 'picture',
            // 'email:email',
            // 'phone',
            // 'mobile',
            // 'fax',
            // 'company',
            // 'address',
            // 'Postcode_id',
            // 'Administrator_id',
            // 'Contact_id',
            // 'comments:ntext',
            // 'internal_comments:ntext',
            // 'break_from',
            // 'break_to',
            // 'dob_date',
            // 'ignore_activity',
            // 'sms_subscription',
            // 'email_subscription:email',
            // 'validation_key',
            // 'login_attempts',
            // 'status',
            // 'update_time',
            // 'update_by',
            // 'create_time',
            // 'create_by',

            ['class' => 'core\widgets\ActionColumn'],
        ],
    ]); ?>

</div>
