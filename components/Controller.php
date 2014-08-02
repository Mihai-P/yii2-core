<?php

namespace core\components;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use core\models\History;


/**
 * FaqController implements the CRUD actions for Faq model.
 */
class Controller extends \yii\web\Controller
{
    var $MainModel = '';
    var $MainModelSearch = '';
    var $defaultQueryParams = ['status' => 'active'];
    var $searchModel;
    var $dataProvider;
    var $historyField = "name";

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
       return [
           'access' => [
                'class' => \core\components\AccessControl::className(),
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
                        'roles'=>['?'], // Guests '?'
                    ],
                ],
           ],
        ];
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
     * Lists all Faq models.
     * @return mixed
     */
    public function getCompatibilityId()
    {
        $controller = $this->getUniqueId();
        if(strpos($controller, "/")) {
            $controller = substr($controller, strpos($controller, "/") + 1);
        }        
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $controller)));
    }

    public function getSearchCriteria() {
        /* setting the default pagination for the page */
        if(!Yii::$app->session->get($this->MainModel.'Pagination')) {
            Yii::$app->session->set($this->MainModel.'Pagination', 10);
        }
        $savedQueryParams = Yii::$app->session->get($this->MainModel.'QueryParams');
        if(count($savedQueryParams)) {
            $queryParams = $savedQueryParams;
        } else {
            $queryParams = [substr($this->MainModelSearch, strrpos($this->MainModelSearch, "\\") + 1) => $this->defaultQueryParams];
        }
        /* use the same filters as before */
        if(count(Yii::$app->request->queryParams)) {
            $queryParams = array_merge($queryParams, Yii::$app->request->queryParams);
        }

        if(isset($queryParams['page'])) {
            $_GET['page'] = $queryParams['page'];
        }
        if(Yii::$app->request->getIsPjax()) {
            $this->layout = false;
        }
        Yii::$app->session->set($this->MainModel.'QueryParams',$queryParams);
        $this->searchModel = new $this->MainModelSearch;
        $this->dataProvider = $this->searchModel->search($queryParams);
    }
    /**
     * Lists all Faq models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->getSearchCriteria();
        $this->layout = '//table';
        return $this->render('index', [
            'searchModel' => $this->searchModel,
            'dataProvider' => $this->dataProvider,
        ]);
    }

    /**
     * Lists all Faq models.
     * @return mixed
     */
    public function actionPdf()
    {
        $this->getSearchCriteria();
        $this->layout = '//blank';
        $this->dataProvider->pagination = false;
        $content =  $this->render('pdf', [
            'dataProvider' => $this->dataProvider,
        ]);

        $mpdf = new \mPDF();
        $mpdf->WriteHTML($content);

        Yii::$app->response->getHeaders()->set('Content-Type', 'application/pdf');
        Yii::$app->response->getHeaders()->set('Content-Disposition', 'attachment; filename="'.$this->getCompatibilityId().'.pdf"');
        return $mpdf->Output($this->getCompatibilityId().'.pdf', 'S');
    }

    /**
     * Lists all Faq models.
     * @return mixed
     
    public function actionCsv()
    {
        $this->getSearchCriteria();
        $this->dataProvider->pagination = false;
        $query = $this->dataProvider->query;
        
        $config = new ExporterConfig();
        $exporter = new Exporter($config);
        Yii::$app->response->getHeaders()->set('Content-Type', 'application/csv');
        Yii::$app->response->getHeaders()->set('Content-Disposition', 'attachment; filename="'.$this->getCompatibilityId().'.csv"');

        $exporter->export('php://output', $query->asArray()->all());
    }
    */    
    /**
     * Lists all Faq models.
     * @return mixed
     */
    public function actionPagination()
    {
        Yii::$app->session->set($this->MainModel.'Pagination',Yii::$app->request->queryParams['records']);
        $this->redirect( ['index'] );
    }

    /**
     * Displays a single Faq model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = '//form';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Faq model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = '//form';
        $model = new $this->MainModel;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->saveHistory($model);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Faq model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function saveHistory($model)
    {
        if(isset($model->{$this->historyField})) {
            $url_components = explode("\\", get_class($model));
            $url_components[2] = trim(preg_replace("([A-Z])", " $0", $url_components[2]), " ");                

            $history = new History;
            $history->name = $model->{$this->historyField} . ' ('.$url_components[2].')';
            $history->url = Url::toRoute(['update', 'id' => $model->id]) ;
            $history->save();
        }            
    }

    /**
     * Updates an existing Faq model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = '//form';
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->saveHistory($model);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Faq model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        if(Yii::$app->request->getIsAjax()) {
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
        if(isset($_POST['items'])) {
            foreach($_POST['items'] as $id) {
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
        if(isset($_POST['items'])) {
            foreach($_POST['items'] as $id) {
                $model = $this->findModel($id);
                if($model = $this->findModel($id)) {
                    $model->status = "active";
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
        if(isset($_POST['items'])) {
            foreach($_POST['items'] as $id) {
                $model = $this->findModel($id);
                if($model = $this->findModel($id)) {
                    $model->status = "inactive";
                    $model->save(false);
                }
            }
        }
    }

    /**
     * Deletes an existing Faq model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionStatus($id)
    {
        $model = $this->findModel($id);
        if($model->status == "active") {
            $model->status = "inactive";
        } else {
            $model->status = "active";
        }
        $model->save(false);
        if(Yii::$app->request->getIsAjax()) {
            \Yii::$app->response->format = 'json';
            return ['success' => true];
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Faq model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Faq the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        $model = call_user_func_array(array($this->MainModel, 'findOne'), array($id));
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * Sets the bulk actions that can be performed on the table of models
     * @param string $grid the ID of the grid that will be updated
     */
    public function bulkButtons($grid ='')
    {
        $buttons = array();
        if(\Yii::$app->user->checkAccess('update::' . $this->getCompatibilityId())) {
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
        if(\Yii::$app->user->checkAccess('delete::' . $this->getCompatibilityId())) {
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
     * Sets the bulk actions that can be performed on the table of models
     * @param string $grid the ID of the grid that will be updated
     */
    public function allButtons($grid ='')
    {
        $buttons = array();
        if(\Yii::$app->user->checkAccess('read::' . $this->getCompatibilityId())) {
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