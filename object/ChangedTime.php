<?php 

namespace app\object;

class ChangedTime extends \yii\db\ActiveRecord
{
	public $id,
			$check_in_id,
			$check_out_id,
			$time,
			$user_id;
	
    public static function tableName()
    {
        return 'changed_time';
    }
    
}