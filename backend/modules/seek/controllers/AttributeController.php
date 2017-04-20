<?php


namespace backend\modules\seek\controllers;

use Yii;
use backend\modules\seek\models\Seek;
use yii\data\SqlDataProvider;
use common\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AttributeController implements the CRUD actions for Seek model.
 */

class AttributeController extends BaseController
{

    public $enableCsrfValidation = false;
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'view', 'upload', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Seek models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT id, cover_id, status, name FROM {{%seek}} WHERE created_by = :user_id',
            'params' => [':user_id' => Yii::$app->user->id],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);


    }

    /**
     * Displays a single Seek model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * 上传图片到相册
     * @param integer $id 相册ID
     */
    public function actionUpload($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $model->upload();
        }

        return $this->render('upload', [
            'model' => $this->findModel($id),

        ]);
    }

    /**
     * Creates a new Seek model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Seek();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Seek model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Seek model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Seek model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Seek the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Seek::findOne($id)) !== null) {

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}