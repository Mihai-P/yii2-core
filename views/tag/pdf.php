<?php
use yii\widgets\ListView;

?>
<html>
<head>
<style>
@page {
  size: auto;
  header: Main;
  footer: Main;
  odd-header-name: Main;
  even-header-name: Main;
  odd-footer-name: Main;
  even-footer-name: Main;  
  margin-top: 30mm;
}
</style>
</head>
<body>
<htmlpageheader name="Main">
    <h1><?= trim(preg_replace("([A-Z])", " $0", $this->context->getCompatibilityId()))?></h1>
    <table backleft="10mm" style="width: 700px;" align="center">
        <tr>
            <td style="width: 10%; border-bottom: 1px solid black;">ID</td>
            <td style="width: 75%; border-bottom: 1px solid black;">Name</td>
            <td style="width: 15%; border-bottom: 1px solid black;">Status</td>
        </tr>
    </table>
</htmlpageheader>
<htmlpagefooter name="Main">
    Page {PAGENO}
</htmlpagefooter>
    <sethtmlpageheader name="Main" value="on"/>
    <sethtmlpagefooter name="Main" value="on"/>
	<table style="width: 700px;" align="center">
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'layout' => "{items}",
    'itemOptions' => ['class' => 'item', 'style' => 'margin-bottom: 5px;'],
    'itemView' => function ($model, $key, $index, $widget) {
        //return print_r($model, true);
        return '<tr><td style="width: 10%;">' . $model->id . '</td><td style="width: 75%;">' . $model->name . '</td><td style="width: 15%;">' . $model->status . '</td><tr>';
    },
]) ?>	
    </table>
</body></html>