<?php

namespace app\controllers;

use Yii;
use app\models\staff\Staff;
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
class StaffController extends Controller {

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
        return $this->redirect('/staff/checklogs');
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
        ]);
        if (Yii::$app->request->get()) {
            Staff::peterCheck();
            $this->redirect('/staff/checklogs');
        } else {
            return $this->render('checklogs', [
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionLogtime() {
        $dataProvider = new ActiveDataProvider([
            'query' => LoginLogout::find()->where(['user_id' => Yii::$app->user->getId()]),
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
