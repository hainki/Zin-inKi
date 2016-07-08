<?php

namespace app\models\user;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $salt
 */
class User extends \yii\db\ActiveRecord
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
            [['id', 'username', 'password', 'salt','role'], 'required'],
            [['id'], 'integer'],
            [['username'], 'string', ['min' => 6, 'max' => 50]],
            [['password'], 'string', ['min' => 6,'max' => 100]],
            [['salt'], 'string', 'max' => 32],
        	[['role'],'integer']
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
            'salt' => 'Salt',
        	'role' => 'Role'
        ];
    }
    public static function findByUsername($username)
    {
    	$data = (new \yii\db\Query())
		    	->select(['*'])
		    	->from('user')
		    	->where(['username' => $username])
		    	->one();
    	return $data;
    }
}
