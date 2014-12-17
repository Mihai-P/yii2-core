<?php

namespace core\controllers;

use core\components\Controller;
use yii\helpers\ArrayHelper;

/**
 * BookmarkController implements the CRUD actions for Bookmark model.
 */
class BookmarkController extends Controller
{
    var $MainModel = 'core\models\Bookmark';
    var $MainModelSearch = 'core\models\BookmarkSearch';

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return ArrayHelper::merge(
            [
                'save' => [
                    'class' => 'core\components\SaveAction',
                ],
                'details' => [
                    'class' => 'core\components\DetailsAction',
                ],
            ],
            parent::actions()
        );
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
            [
                'access' => [
                    'rules' => [
                        [
                            'actions' => ['save', 'details'], // Define specific actions
                            'allow' => true, // Has access
                            'roles' => ['create::' . $this->getCompatibilityId()],
                        ],
                    ],
                ],
            ],
            parent::behaviors()
        );
    }
}