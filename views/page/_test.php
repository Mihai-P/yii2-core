<?php
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

echo $form->field($model, 'content')->widget(CKEditor::className(),[
    'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['preset' => 'standard', 'inline' => false]),
]);
echo $form->field($model->object('SuccessMessage'), 'content')->textInput(['name' => 'Object[SuccessMessage]', 'id' => 'Object-SuccessMessage']);