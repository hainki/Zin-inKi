<?php

namespace app\models\staff;

use Yii;
use app\object\User;
use app\object\CheckIn;
use app\object\CheckOut;
use yii\base\Model;
/**
 * This is the model class for table "check_in".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $time
 *
 * @property ChangedTime[] $changedTimes
 * @property User $user
 */
class Staff extends Model
{
	public static function peterCheck(){
		$user_id = Yii::$app->user->getId();
		switch(strtolower(Yii::$app->request->get()['a'])){
			case "check-in":
				$checkIn = new CheckIn;
				if(!($result = CheckIn::find()->where(['user_id'=> $user_id,'date'=>date("Y-m-d")])->one())){
					$checkIn->user_id = $user_id;
					$checkIn->date = date("Y-m-d");
					$checkIn->time = date("h:i:sa");
					$checkIn->save();
				}
				break;
			case "check-out":
				$checkOut = new CheckOut;
				if(!($result = CheckOut::find()->where(['user_id'=> $user_id,'date'=>date("Y-m-d")])->one())){
					$checkOut->user_id = $user_id;
					$checkOut->date = date("Y-m-d");
					$checkOut->time = date("h:i:sa");
					$checkOut->save();
				}
				break;
		}
	}
}
