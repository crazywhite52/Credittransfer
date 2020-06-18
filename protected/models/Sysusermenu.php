<?php

/**
 * This is the model class for table "sysusermenu".
 *
 * The followings are the available columns in table 'sysusermenu':
 * @property integer $menu_id
 * @property integer $program_id
 * @property string $user_id
 * @property integer $views
 * @property integer $creates
 * @property integer $edits
 * @property integer $deletes
 * @property integer $approves
 * @property integer $printed
 */
class Sysusermenu extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Sysusermenu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection()
	{
		return Yii::app()->msystem;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sysusermenu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('menu_id', 'required'),
			array('menu_id, program_id, views, creates, edits, deletes, approves, printed', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('menu_id, program_id, user_id, views, creates, edits, deletes, approves, printed', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'menu_id' => 'Menu',
			'program_id' => 'Program',
			'user_id' => 'User',
			'views' => 'Views',
			'creates' => 'Creates',
			'edits' => 'Edits',
			'deletes' => 'Deletes',
			'approves' => 'Approves',
			'printed' => 'Printed',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('menu_id',$this->menu_id);
		$criteria->compare('program_id',$this->program_id);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('views',$this->views);
		$criteria->compare('creates',$this->creates);
		$criteria->compare('edits',$this->edits);
		$criteria->compare('deletes',$this->deletes);
		$criteria->compare('approves',$this->approves);
		$criteria->compare('printed',$this->printed);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}