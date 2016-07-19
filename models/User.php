<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;


/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $fullname
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $role
 * @property string $date_created
 *
 * @property Checkin[] $checkins
 * @property Checkout[] $checkouts
 * @property LogHistory[] $logHistories
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
// 	public $auth_key;
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username'], 'string', 'max' => 50],
            [['password'], 'string', 'min' => 6],
            [['password'], 'string', 'max' => 32],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',

        ];
    }

     /** INCLUDE USER LOGIN VALIDATION FUNCTIONS**/
     /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
/* modified */
    public static function findIdentityByAccessToken($token, $type = null)
    {
          return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $dbUser = self::find()
            ->where([
                "username" => $username
            ])
            ->one();
            var_dump($dbUser);
    if (!count($dbUser)) {
        return null;
    }
    return new static($dbUser);
        //return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
//     	$hash = self::find()->where(['username'=>$username])->one()->password;
         return Yii::$app->security->validatePassword($password, $this->password);
       // return $this->password === $password;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
   public function setPassword($password)
   {
       $this->password_hash = Yii::$app->security->generatePasswordHash($password);
   }
//    public function generateAuthKey()
//    {
//    	$this->auth_key = Yii::$app->security->generateRandomString();
//    }

}