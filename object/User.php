<?php 

namespace app\object;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;

class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
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
            [['username', 'password', 'fullname', 'date_of_birth', 'created_date'], 'required'],
            [['role'], 'boolean'],
            [['date_of_birth', 'created_date'], 'safe'],
            [['username'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 70],
            [['fullname'], 'string', 'max' => 100],
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
            'role' => 'is Admin',
            'fullname' => 'Fullname',
            'date_of_birth' => 'Date Of Birth',
            'created_date' => 'Created Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChangedTimes()
    {
        return $this->hasMany(ChangedTime::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCheckIns()
    {
        return $this->hasMany(CheckIn::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCheckOuts()
    {
        return $this->hasMany(CheckOut::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoginLogouts()
    {
        return $this->hasMany(LoginLogout::className(), ['user_id' => 'id']);
    }
    public static function findIdentity($id)
    {
    	return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
    	foreach (self::$users as $user) {
    		if ($user['accessToken'] === $token) {
    			return new static($user);
    		}
    	}
    	return null;
    }
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
    	$user = self::find()->select("id,username,password,role")->where(['username' => $username])->one();
    	if($user) return new static($user);
    	return null;
    }
    /**
     * @inheritdoc
     */
    public function getId()
    {
    	return $this->id;
    }
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
    	return $this->authKey;
    }
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
    	return $this->authKey === $authKey;
    }
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
    	return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
}