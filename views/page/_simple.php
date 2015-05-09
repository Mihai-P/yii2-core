<?php
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
?>
<?= $form->field($model, 'h1')->textInput(['maxlength' => 255]) ?>

<?= $form->field($model, 'content')->widget(CKEditor::className(),[
    'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['preset' => 'full', 'inline' => false] + ["allowedContent" => true, "extraAllowedContent" => '*{*}']),
]) ?>