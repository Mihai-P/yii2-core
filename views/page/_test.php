<?php
	echo $form->field($model, 'content')->textarea(['class' => 'editor']);
	echo $form->field($model->object('SuccessMessage'), 'content')->textInput(['name' => 'Object[SuccessMessage]', 'id' => 'Object-SuccessMessage']);