<?php

namespace app\controllers;

use Yii;
use app\object\User;
use app\models\login\LoginForm;
use app\object\LoginLogout;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LoginController implements the CRUD actions for Login model.
 */
class LoginController extends Controller
{
    /**
     * @inheritdoc
     */
	private $model;
	//Yii::$app->session;
	
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Login models.
     * @return mixed
     */
    public function actionIndex()
    {
    	if(!Yii::$app->user->isGuest){
    		$role = Yii::$app->user->identity->role;
    		if($role) return $this->redirect('/admin');
    		else return $this->redirect('/staff');
    	}
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
        	date_default_timezone_set('Asia/Ho_Chi_Minh');
        	$in = new LoginLogout;
        	$in->user_id = Yii::$app->user->getId();
        	$in->login_time = date('Y-m-d h:i:sa');
        	$in->save();
            return $this->redirect('/login');
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Login model.
     * @param integer $id
     * @return mixed
     */
//    	public function actionLogin(){
//         $model = new LoginForm();
//         if ($model->load(Yii::$app->request->post()) && $model->login()) {
//              return $this->goBack();
//         }
//         return $this->render('index', [
//             'model' => $model,
//         ]);
//    	}
   	public function actionLogout(){
   			date_default_timezone_set('Asia/Ho_Chi_Minh');
   			$out = LoginLogout::find()->where(['user_id'=>Yii::$app->user->getId()])->orderBy(['id' => SORT_DESC])->one();
	   		$out->logout_time = date('Y-m-d H:i:sa');
	   		$out->save();
   			Yii::$app->user->logout();
	   		return $this->goHome();
   	}
   	
    protected function findModel($id)
    {
        if (($model = Login::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
