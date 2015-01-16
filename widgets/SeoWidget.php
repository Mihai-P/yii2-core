<?php
/**
 * SeoWidget class file.
 *
 * @author Mihai Petrescu <mihai.petrescu@gmail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace core\widgets;

use \Yii;
use yii\base\Widget;

/**
 * The SeoWidget widget displays some SEO tags which probably have no effect<strike></strike>.
 *
 */
class SeoWidget extends Widget
{
    /**
     * @var seo that mixed the widget mode
     */
    public $seo = [];

    public function run()
    {
        $this->seo = array_reverse($this->seo);

        $tags = [];
        foreach($this->seo as $key => $value) {
            $tags = array_merge($tags, $value);
        }

        return $this->render('seo',
            ['tags' => $tags]
        );
    }
}
