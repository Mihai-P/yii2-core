<?php
/**
 * Controller implements the CRUD actions for the model.
 *
 * @license http://www.yiiframework.com/license/
 * @author Mihai Petrescu <mihai.petrescu@gmail.com>
 * @since 2.0
 */

namespace core\components;

use Yii;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use core\models\History;
use \yii\filters\AccessControl;

/**
 * Controller implements the CRUD actions for the model.
 *
 * This class implements some basic default actions for a standard back end
 * CMS controller that is used for standard CRUD editing of a single model
 * used in the CMS.
 *
 * * An "index" action which lists all of the records, with filtering and
 *   pagination.
 * * View, Create, Update and Delete actions.
 * * Modifying record statuses -- setting records to active or inactive.
 * * Bulk and individual record actions.
 */
class Controller extends \yii\web\Controller
{
    /**
     * @const string the layouts available for the controller views. Defaults to the main one
     */
    const MAIN_LAYOUT = '@core/views/layouts/main';
    const FORM_LAYOUT = '@core/views/layouts/form';
    const TABLE_LAYOUT = '@core/views/layouts/table';
    const BLANK_LAYOUT = '@core/views/layouts/blank';
    const POPUP_LAYOUT = '@core/views/layouts/popup';
    const PRINT_LAYOUT = '@core/views/layouts/print';
    const SIMPLE_LAYOUT = '@core/views/layouts/simple';
    const SIDEBAR_LAYOUT = '@core/views/layouts/sidebar';
    const LOGIN_LAYOUT = '@core/views/layouts/login';
    /**
     * @event Event an event that is triggered after a record is inserted.
     */
    const EVENT_AFTER_CREATE = 'afterCreate';
    /**
     * @event Event an event that is triggered after a record is updated.
     */
    const EVENT_AFTER_UPDATE = 'afterUpdate';

    /**
     * @var bool if the redirects should go to the view action or back to inder
     */
    var $hasView = false;

    /**
     * @var string the class of the main model for the controller
     */
    var $MainModel = '';
    /**
     * @var string the search class of the main model for the controller
     */
    var $MainModelSearch = '';

    /**
     * @var array the default query params for the index view
     */
    var $defaultQueryParams = ['status' => ActiveRecord::STATUS_ACTIVE];

    /**
     * @var ActiveRecord the search model
     */
    var $searchModel;

    /**
     * @var \yii\data\ActiveDataProvider the data provider for the index, pdf, csv
     */
    var $dataProvider;

    /**
     * @var string the field name that will identify the record
     */
    var $historyField = "name";
    /**
     * @inheritdoc
     */
    var $layout = '@core/views/layouts/main';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'list', 'pdf', 'csv', 'pagination'], // Define specific actions
                        'allow' => true, // Has access
                        'roles' => ['read::' . $this->getCompatibilityId()],
                    ],
                    [
                        'actions' => ['create'], // Define specific actions
                        'allow' => true, // Has access
                        'roles' => ['create::' . $this->getCompatibilityId()],
                    ],
                    [
                        'actions' => ['save', 'update', 'status', 'activate-all', 'deactivate-all'], // Define specific actions
                        'allow' => true, // Has access
                        'roles' => ['update::' . $this->getCompatibilityId()],
                    ],
                    [
                        'actions' => ['delete', 'delete-all'], // Define specific actions
                        'allow' => true, // Has access
                        'roles' => ['delete::' . $this->getCompatibilityId()],
                    ],
                    [
                        'allow' => false, // Do not have access
                        'roles' => ['?'], // Guests '?'
                    ],
                ],
            ],
        ];
    }

    /**
     * Gets the simple name for the current controller
     * @return string
     */
    public function getCompatibilityId()
    {
        $controller = $this->getUniqueId();
        if (strpos($controller, "/")) {
            $controller = substr($controller, strpos($controller, "/") + 1);
        }
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $controller)));
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'csv' => [
                'class' => 'core\components\CsvAction',
            ],
        ];
    }

    /**
     * Lists all the models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->getSearchCriteria();
        $this->layout = static::TABLE_LAYOUT;
        return $this->render('index', [
            'searchModel' => $this->searchModel,
            'dataProvider' => $this->dataProvider,
        ]);
    }

    /**
     * creates the search criteria for the model
     * @return null
     */
    public function getSearchCriteria()
    {
        /* setting the default pagination for the page */
        if (!Yii::$app->session->get($this->MainModel . 'Pagination')) {
            Yii::$app->session->set($this->MainModel . 'Pagination', Yii::$app->getModule('core')->recordsPerPage);
        }
        $savedQueryParams = Yii::$app->session->get($this->MainModel . 'QueryParams');
        if (count($savedQueryParams)) {
            $queryParams = $savedQueryParams;
        } else {
            $queryParams = [substr($this->MainModelSearch, strrpos($this->MainModelSearch, "\\") + 1) => $this->defaultQueryParams];
        }
        /* use the same filters as before */
        if (count(Yii::$app->request->queryParams)) {
            $queryParams = array_merge($queryParams, Yii::$app->request->queryParams);
        }

        if (isset($queryParams['page'])) {
            $_GET['page'] = $queryParams['page'];
        }
        if (Yii::$app->request->getIsPjax()) {
            $this->layout = false;
        }
        Yii::$app->session->set($this->MainModel . 'QueryParams', $queryParams);
        $this->searchModel = new $this->MainModelSearch;
        $this->dataProvider = $this->searchModel->search($queryParams);
    }

    /**
     * Creates a PDF file with the current list of the models
     * @return string
     */
    public function actionPdf()
    {
        $this->getSearchCriteria();
        $this->layout = static::BLANK_LAYOUT;
        $this->dataProvider->pagination = false;
        $content = $this->render('pdf', [
            'dataProvider' => $this->dataProvider,
        ]);
        if (isset($_GET['test'])) {
            return $content;
        } else {
            $mpdf = new \mPDF();
            $mpdf->WriteHTML($content);

            Yii::$app->response->getHeaders()->set('Content-Type', 'application/pdf');
            Yii::$app->response->getHeaders()->set('Content-Disposition', 'attachment; filename="' . $this->getCompatibilityId() . '.pdf"');
            return $mpdf->Output($this->getCompatibilityId() . '.pdf', 'S');
        }
    }

    /**
     * Sets the pagination for the list
     * @return mixed
     */
    public function actionPagination()
    {
        Yii::$app->session->set($this->MainModel . 'Pagination', Yii::$app->request->queryParams['records']);
        $this->redirect(['index']);
    }

    /**
     * Displays a single model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = static::MAIN_LAYOUT;
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        $model = call_user_func_array([$this->MainModel, 'findOne'], [$id]);
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' or 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = static::FORM_LAYOUT;
        $model = new $this->MainModel;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->afterCreate($model);
            if ($this->hasView) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function afterCreate($model)
    {
        $this->saveHistory($model, $this->historyField);
        $this->trigger(self::EVENT_AFTER_CREATE, new ControllerEvent([
            'model' => $model,
            'controller' => $this
        ]));
    }

    /**
     * Saves the history for the model
     * @param \yii\db\ActiveRecord $model
     * @param string $historyField
     * @return null
     */
    public function saveHistory($model, $historyField)
    {
        if (isset($model->{$historyField})) {
            $url_components = explode("\\", get_class($model));
            $url_components[2] = trim(preg_replace("([A-Z])", " $0", $url_components[2]), " ");

            $history = new History;
            $history->name = $model->{$historyField};
            $history->type = $url_components[2];
            $history->url = Url::toRoute(['update', 'id' => $model->id]);
            $history->save();
        }
    }

    /**
     * Updates an existing model.
     * If update is successful, the browser will be redirected to the 'view' or 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = static::FORM_LAYOUT;
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->afterUpdate($model);

            if ($this->hasView) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function afterUpdate($model)
    {
        $this->saveHistory($model, $this->historyField);
        $this->trigger(self::EVENT_AFTER_UPDATE, new ControllerEvent([
            'model' => $model,
            'controller' => $this
        ]));
    }

    /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        if (Yii::$app->request->getIsAjax()) {
            \Yii::$app->response->format = 'json';
            return ['success' => true];
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Deletes a list of models
     * @return mixed
     */
    public function actionDeleteAll()
    {
        if (isset($_POST['items'])) {
            foreach ($_POST['items'] as $id) {
                $this->findModel($id)->delete();
            }
        }
    }

    /**
     * Activates a list of models
     * @return mixed
     */
    public function actionActivateAll()
    {
        if (isset($_POST['items'])) {
            foreach ($_POST['items'] as $id) {
                if ($model = $this->findModel($id)) {
                    $model->status = ActiveRecord::STATUS_ACTIVE;
                    $model->save(false);
                }
            }
        }
    }

    /**
     * Activates a list of models
     * @return mixed
     */
    public function actionDeactivateAll()
    {
        if (isset($_POST['items'])) {
            foreach ($_POST['items'] as $id) {
                if ($model = $this->findModel($id)) {
                    $model->status = ActiveRecord::STATUS_INACTIVE;
                    $model->save(false);
                }
            }
        }
    }

    /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page or send a json response.
     * @param integer $id
     * @return mixed
     */
    public function actionStatus($id)
    {
        $model = $this->findModel($id);
        if ($model->status == ActiveRecord::STATUS_ACTIVE) {
            $model->status = ActiveRecord::STATUS_INACTIVE;
        } else {
            $model->status = ActiveRecord::STATUS_ACTIVE;
        }
        $model->save(false);
        if (Yii::$app->request->getIsAjax()) {
            \Yii::$app->response->format = 'json';
            return ['success' => true];
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Sets the bulk actions that can be performed on the table of models
     * @return array
     */
    public function bulkButtons()
    {
        $buttons = [];
        if (\Yii::$app->user->checkAccess('update::' . $this->getCompatibilityId())) {
            $buttons[] = [
                'text' => 'Activate',
                'url' => Url::toRoute('activate-all'),
                'options' => [
                    'class' => 'pull-left btn btn-xs btn-success all-activate',
                    'data-pjax' => '0',
                    'onclick' => 'javascript: if(confirm("Are you sure you want to activate the selected items?")) myGrid.submit($(this)); return false;'
                ]
            ];
            $buttons[] = [
                'text' => 'Deactivate',
                'url' => Url::toRoute('deactivate-all'),
                'options' => [
                    'class' => 'pull-left btn btn-xs btn-primary all-deactivate',
                    'data-pjax' => '0',
                    'onclick' => 'javascript: if(confirm("Are you sure you want to deactivate the selected items?")) myGrid.submit($(this)); return false;'
                ]
            ];
        }
        if (\Yii::$app->user->checkAccess('delete::' . $this->getCompatibilityId())) {
            $buttons[] = [
                'text' => 'Delete',
                'url' => Url::toRoute('delete-all'),
                'options' => [
                    'class' => 'pull-left btn btn-xs btn-danger all-delete',
                    'data-pjax' => '0',
                    'onclick' => 'javascript: if(confirm("Are you sure you want to delete the selected items?")) myGrid.submit($(this)); return false;'
                ]
            ];
        }
        return $buttons;
    }


    /**
     * Sets the buttons that can be performed on the entire result
     * @return array
     */
    public function allButtons()
    {
        $buttons = [];
        if (\Yii::$app->user->checkAccess('read::' . $this->getCompatibilityId())) {
            $buttons['pdf'] = [
                'text' => 'Download PDF',
                'url' => Url::toRoute(['pdf']),
                'options' => [
                    'target' => '_blank',
                ]
            ];
            $buttons['csv'] = [
                'text' => 'Download CSV',
                'url' => Url::toRoute(['csv']),
                'options' => [
                    'target' => '_blank',
                ]
            ];
        }
        return $buttons;
    }
}