<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/**
 * @var yii\web\View $this
 * @var core\models\Website $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<?php
	$flashes = Yii::$app->getSession()->getAllFlashes();
	if(count($flashes)) {
		foreach($flashes as $type => $message) {
			echo '<div class="bg-'.$type.' has-padding widget-inner">'.$message.'</div>';
		}
		Yii::$app->getSession()->removeAllFlashes();
	}
?>
<div class="website-form">
    <?php $form = ActiveForm::begin(); ?>

	<div class="panel panel-default">
        <div class="panel-heading"><h6 class="panel-title">Misc</h6></div>
        <div class="panel-body">

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'host')->textInput(['maxlength' => 255]) ?>

        </div>
    </div>

	<div class="panel panel-default">
        <div class="panel-heading"><h6 class="panel-title">Top Part</h6></div>
        <div class="panel-body">
<?php
	//echo $form->field($model->object('Background'), 'content')->textInput(['name' => 'Object[Background]', 'id' => 'Object-Background']);

	echo $form->field($model->object('Background'), 'content')->widget(theme\widgets\InputFile::className(), ['options'       => ['name' => 'Object[Background]', 'id' => 'Object-Background']]);

	echo $form->field($model->object('PhoneNumber'), 'content')->textInput(['name' => 'Object[PhoneNumber]', 'id' => 'Object-PhoneNumber']);

	echo $form->field($model->object('FriendlyPhoneNumber'), 'content')->textInput(['name' => 'Object[FriendlyPhoneNumber]', 'id' => 'Object-FriendlyPhoneNumber']);
?>
        </div>
    </div>
	<div class="panel panel-default">
        <div class="panel-heading"><h6 class="panel-title">Bottom Part - Left Column</h6></div>
        <div class="panel-body">

<?php
	echo $form->field($model->object('LeftBoxTitle'), 'content')->textInput(['name' => 'Object[LeftBoxTitle]', 'id' => 'Object-LeftBoxTitle']);
    echo $form->field($model->object('LeftBoxContent'), 'content')->widget(CKEditor::className(),[
        'options' => ['id' => 'Object-LeftBoxContent', 'name' => 'Object[LeftBoxContent]'],
        'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['preset' => 'full', 'inline' => false]),
    ]);
	echo $form->field($model->object('FacebookLink'), 'content')->hint('Leave empty if you do not want to use')->textInput(['name' => 'Object[FacebookLink]', 'id' => 'Object-FacebookLink']);
	echo $form->field($model->object('TwitterLink'), 'content')->hint('Leave empty if you do not want to use')->textInput(['name' => 'Object[TwitterLink]', 'id' => 'Object-TwitterLink']);
	echo $form->field($model->object('GooglePlusLink'), 'content')->hint('Leave empty if you do not want to use')->textInput(['name' => 'Object[GooglePlusLink]', 'id' => 'Object-GooglePlusLink']);
	echo $form->field($model->object('RssLink'), 'content')->hint('Leave empty if you do not want to use')->textInput(['name' => 'Object[RssLink]', 'id' => 'Object-RssLink']);
	echo $form->field($model->object('PintrestLink'), 'content')->hint('Leave empty if you do not want to use')->textInput(['name' => 'Object[PintrestLink]', 'id' => 'Object-PintrestLink']);
	echo $form->field($model->object('InstagramLink'), 'content')->hint('Leave empty if you do not want to use')->textInput(['name' => 'Object[InstagramLink]', 'id' => 'Object-InstagramLink']);
	echo $form->field($model->object('LinkedInLink'), 'content')->hint('Leave empty if you do not want to use')->textInput(['name' => 'Object[LinkedInLink]', 'id' => 'Object-LinkedInLink']);
	echo $form->field($model->object('VimeoLink'), 'content')->hint('Leave empty if you do not want to use')->textInput(['name' => 'Object[VimeoLink]', 'id' => 'Object-VimeoLink']);
	echo $form->field($model->object('YoutubeLink'), 'content')->hint('Leave empty if you do not want to use')->textInput(['name' => 'Object[YoutubeLink]', 'id' => 'Object-YoutubeLink']);
	echo $form->field($model->object('FlickrLink'), 'content')->hint('Leave empty if you do not want to use')->textInput(['name' => 'Object[FlickrLink]', 'id' => 'Object-FlickrLink']);
?>
        </div>
    </div>

	<div class="panel panel-default">
        <div class="panel-heading"><h6 class="panel-title">Bottom Part - Left Menu</h6></div>
        <div class="panel-body">
<?php
	echo $form->field($model->object('LeftMenuTitle'), 'content')->textInput(['name' => 'Object[LeftMenuTitle]', 'id' => 'Object-LeftMenuTitle']);
?>
		<div class="alert alert-info fade in widget-inner">
			You can edit the menu from the <strong>Menus</strong> section.
        </div>
        </div>
    </div>

	<div class="panel panel-default">
        <div class="panel-heading"><h6 class="panel-title">Bottom Part - Right Menu</h6></div>
        <div class="panel-body">
			<?= $form->field($model->object('RightMenuTitle'), 'content')->textInput(['name' => 'Object[RightMenuTitle]', 'id' => 'Object-RightMenuTitle']);?>
		<div class="alert alert-info fade in widget-inner">
			You can edit the menu from the <strong>Menus</strong> section.
        </div>
        </div>
    </div>    

	<div class="panel panel-default">
        <div class="panel-heading"><h6 class="panel-title">Right Side Boxes</h6></div>
        <div class="panel-body">
<?php
		echo $form->field($model->object('PostcodeTitle'), 'content')->textInput(['name' => 'Object[PostcodeTitle]', 'id' => 'Object-PostcodeTitle']);
		echo $form->field($model->object('PostcodeContent'), 'content')->textInput(['name' => 'Object[PostcodeContent]', 'id' => 'Object-PostcodeContent']);
		echo $form->field($model->object('PostcodeSearchMultiple'), 'content')->textInput(['name' => 'Object[PostcodeSearchMultiple]', 'id' => 'Object-PostcodeSearchMultiple']);
		echo $form->field($model->object('PostcodeSearchSuccess'), 'content')->textInput(['name' => 'Object[PostcodeSearchSuccess]', 'id' => 'Object-PostcodeSearchSuccess']);
		echo $form->field($model->object('PostcodeSearchError'), 'content')->textInput(['name' => 'Object[PostcodeSearchError]', 'id' => 'Object-PostcodeSearchError']);
?>
        </div>
    </div>

	<div class="panel panel-default">
        <div class="panel-heading"><h6 class="panel-title">Footer</h6></div>
        <div class="panel-body">
<?php
		echo $form->field($model->object('CopyrightText'), 'content')->textInput(['name' => 'Object[CopyrightText]', 'id' => 'Object-CopyrightText'])->hint('The &copy; and the year are automatically inserted');
?>
        </div>
    </div>

    <div class="form-actions text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
