<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var core\models\Contact $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'Group_id',
            'username',
            'is_admin',
            'password',
            'password_hash',
            'password_reset_token',
            'auth_key',
            'last_visit_time',
            'name',
            'firstname',
            'lastname',
            'picture',
            'email:email',
            'phone',
            'mobile',
            'fax',
            'company',
            'address',
            'Postcode_id',
            'Administrator_id',
            'Contact_id',
            'comments:ntext',
            'internal_comments:ntext',
            'break_from',
            'break_to',
            'dob_date',
            'ignore_activity',
            'sms_subscription',
            'email_subscription:email',
            'validation_key',
            'login_attempts',
            'status',
            'update_time',
            'update_by',
            'create_time',
            'create_by',
        ],
    ]) ?>

</div>
