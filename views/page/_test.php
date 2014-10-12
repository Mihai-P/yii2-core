<?php
	echo $form->field($model, 'content')->textarea(['class' => 'editor']);
	echo $form->field($model->object('SuccessMessage'), 'content')->textInput(['name' => 'Object[SuccessMessage]', 'id' => 'Object-SuccessMessage']);
    //echo $form->field($model, 'content')->widget(theme\widgets\ImageButton\ImageButtonWidget::className());
    //echo $form->field($model->object('Button'), 'content')->widget(theme\widgets\ImageButton\ImageButtonWidget::className(), ['options' => ['id' => 'object-button', 'name' => 'Object[Button]']])->hint('Hello World !!!');