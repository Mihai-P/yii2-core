<?php
	echo $form->field($model->object('Test'), 'content')->textInput(['name' => 'Object[Test]', 'id' => 'Object-Test']);
	echo $form->field($model->object('aaaaaa'), 'content')->textarea(['class' => 'editor', 'name' => 'Object[aaaaaa]', 'id' => 'Object-aaaaaa']);
?>