<?php

use yii\helpers\Html;
use theme\widgets\GridView;
use theme\widgets\Pjax;
use core\models\Group;

/**
 * @var yii\web\View $this
 * @var core\models\AdministratorSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Administrators';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="administrator-index">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin(['options' => ['id'=>'main-pjax']]); ?>
    <?= GridView::widget([
        'id' => 'main-grid',
        'dataProvider' => $dataProvider,
        'buttons' => $this->context->bulkButtons(),
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'theme\widgets\CheckboxColumn'],
            ['class' => 'theme\widgets\IdColumn'],
            ['class' => 'theme\widgets\NameColumn'],
            // 'id',
            // 'title',
            // 'Group_id',
            // 'username',
            // 'type',
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
            ['class' => 'theme\widgets\StatusColumn'],
            ['class' => 'theme\widgets\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
