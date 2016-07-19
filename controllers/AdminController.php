<?php

namespace app\controllers;

use Yii;
use app\models\admin\Admin;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
//Object
use app\object\User;
use app\object\LoginLogout;
use yii\data\ArrayDataProvider;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    return Yii::$app->user->identity->role;
                }
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Admin models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admin model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Admin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate_staff() {
        $model = new User();
        if ($request = Yii::$app->request->post()) {
            $request['User']['created_date'] = date('Y-m-d h:i:sa');
            $request['User']['password'] = Yii::$app->getSecurity()->generatePasswordHash($request['User']['password']);
            if ($model->load($request) && $model->save()) {
                return $this->redirect(['index', 'model' => $model]);
            } goto renderDefault;
        } goto renderDefault;

        renderDefault: {
            return $this->render('create_staff', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSet_role($id) {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'model' => $model]);
        } else {
            return $this->render('set_role', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Admin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionChecklogs() {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $sql = "SELECT ci.date as 'date',ci.time as 'check_in_time',co.time as 'check_out_time'
                    FROM check_in as ci 
                    LEFT OUTER JOIN check_out as co
                    ON ci.date = co.date
                    WHERE ci.user_id = :id
		";
        $dataProvider = new ArrayDataProvider([
            'allModels' => Yii::$app->db->createCommand($sql)->bindValue(':id', Yii::$app->user->getId())->queryAll(),
            'pagination' => [
                'pageSize' => 10,]
        ]);
        if (Yii::$app->request->get()) {
            Admin::peterCheck();
            $this->redirect('/admin/checklogs');
        } else {
            return $this->render('checklogs', [
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionLogtime() {
        $dataProvider = new ActiveDataProvider([
            'query' => LoginLogout::find()->where(['user_id' => Yii::$app->user->getId()]),
            'pagination' => [
                'pageSize' => 10,]
        ]);
        return $this->render('viewLogsTime', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
