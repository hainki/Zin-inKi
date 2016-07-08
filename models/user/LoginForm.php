<?php 
use Yii;
use yii\base\Model;
use yii\helpers\Url;
class LoginForm extends Model{
	public $id,
			$username,
			$password,
			$role;
	private $_user = null,
			$session = Yii::$app->session;
	
	
	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
				// username and password are both required
				[['username', 'password'], 'required'],
				// rememberMe must be a boolean value
				['rememberMe', 'boolean'],
				// password is validated by validatePassword()
				['password', 'validatePassword'],
		];
	}
	
	/**
	 * Validates the password.
	 * This method serves as the inline validation for password.
	 *
	 * @param string $attribute the attribute currently being validated
	 * @param array $params the additional name-value pairs given in the rule
	 */
	public function validatePassword($password, $hash)
	{
		if (!$this->hasErrors()) {
			if(Yii::$app->getSecurity()->validatePassword($password, $hash)){
				$this->session->set('Loged',[
						'id'	=> $this->id,
					'username' 	=> $this->username,
						'role' 	=> $this->role
				]);
			}else{
				$this->addError($attribute, 'Incorrect username or password.');
			}
		}
	}
	
	/**
	 * Logs in a user using the provided username and password.
	 * @return boolean whether the user is logged in successfully
	 */
	public function login()
	{
		if ($this->validate()) {
			return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
		}
		return false;
	}
	
	/**
	 * Finds user by [[username]]
	 *
	 * @return User|null
	 */
	public function getUser()
	{
		$this->_user = User::findByUsername($this->username);
		if (!empty($this->_user)) {
			$this->id = $this->_user['id'];
			$this->username = $this->_user['username'];
			$this->password = $this->_user['password'];
			$this->password = $this->_user['role'];
			return true;
		}
		return false;
	}
}
?>