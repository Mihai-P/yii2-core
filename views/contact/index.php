<?php

use yii\helpers\Html;
use theme\widgets\GridView;
use theme\widgets\Pjax;
use core\models\Contact;
use yii\bootstrap\ActiveForm;
/**
 * @var yii\web\View $this
 * @var core\models\ContactSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Contacts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-index">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin(['options' => ['id'=>'main-pjax']]); ?>    
    <?= GridView::widget([
        'id' => 'main-grid',
        'dataProvider' => $dataProvider,
        'buttons' => $this->context->bulkButtons(),
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'theme\widgets\IdColumn'],
            ['class' => 'theme\widgets\NameColumn', 'hasView' => $this->context->hasView],
            ['class' => 'theme\widgets\StatusColumn'],
            ['class' => 'theme\widgets\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
            <!-- Form modal -->
            <div id="assign-all-tag" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h5 class="modal-title">Assign to tags</h5>
                        </div>
<!-- Form inside modal -->
<?php 
    $model = new Contact;
    $form = ActiveForm::begin([
        'action' => ['assign-tags'],
        'method' => 'post',
        'id' => 'assign-tags-form',
        'options' => [
            'role' => "form",
        ], 
        'enableClientValidation' => false,
        'validateOnSubmit' => false,
        'validateOnChange' => false,
        'fieldConfig' => [
            'template' => "<div class=\"row\"><div class=\"col-sm-2\">{label}</div>\n<div class=\"col-sm-10\">{input}</div></div>",
        ]        
    ]);
?>
                            <div class="modal-body has-padding">
                                <?= $form->field($model, 'tags')->widget(\theme\widgets\InputTags::classname()) ?>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
            <!-- /form modal -->