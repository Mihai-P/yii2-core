<?php
/**
 * RedirectWidget class file.
 *
 * @author Mihai Petrescu <mihai.petrescu@gmail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace core\widgets;

use \Yii;
use yii\base\Widget;
use sammaye\audittrail\AuditTrail;

/**
 * The RedirectWidget widget displays the redirect page after returning from provider.
 *
 */
class AuditTrailWidget extends Widget
{
    /**
     * @var seo that mixed the widget mode
     */
    public $modelIds = [];

    public function run()
    {
        $criteria = AuditTrail::find();
        $param_id = 0;

        // $model_ids is the one you built in your original code
        foreach( $this->modelIds as $id_pair ) {
            $criteria->orWhere('model_id = :id' . $param_id . ' AND model = :model' . $param_id);
            $criteria->addParams([
                ':id' . $param_id => $id_pair[0],
                ':model' . $param_id => $id_pair[1]
            ]);
            $param_id++;
        }
        $criteria->orderBy(['stamp' => SORT_DESC]);

        return $this->render('auditTrail',
            ['criteria' => $criteria]
        );
    }
}
