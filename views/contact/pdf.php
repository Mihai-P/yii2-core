<?php
use yii\widgets\ListView;
?>
<page backtop="22mm" backbottom="8mm" backleft="0" backright="0">
    <page_header>
    	<h1>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "Invoice Report"?></h1>
        <table backleft="10mm" style="width: 700px;" align="center">
			<tr>
				<td style="width: 10%; border-bottom: 1px solid black;">ID</td>
				<td style="width: 75%; border-bottom: 1px solid black;">Name</td>
				<td style="width: 15%; border-bottom: 1px solid black;">Status</td>
			</tr>
        </table>
    </page_header>
    <page_footer>
        <table style="width: 700px; border-top: 1px solid black;" align="center">
            <tr>
                <td style="text-align: left; width: 50%"></td>
                <td style="text-align: right; width: 50%">page [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>    
	<table style="width: 700px;" align="center">
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'layout' => "{items}",
    'itemOptions' => ['class' => 'item', 'style' => 'margin-bottom: 5px;'],
    'itemView' => function ($model, $key, $index, $widget) {
        //return print_r($model, true);
        return "<tr><td>" . $model->id . "</td><td>" . $model->name . "</td><td>" . $model->status . "</td><tr>";
    },
]) ?>	</table>
</page>