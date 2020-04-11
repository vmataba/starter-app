<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property int $file_type_id
 * @property string $file_type
 * @property string $name
 * @property string $ip_address
 * @property string $browser_description
 * @property int $is_active
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 */
class File extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['file_type_id', 'file_type', 'name', 'ip_address', 'browser_description'], 'required'],
            [['file_type_id', 'is_active', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['file_type'], 'string', 'max' => 64],
            [['name', 'ip_address'], 'string', 'max' => 128],
            [['browser_description'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'file_type_id' => 'File Type ID',
            'file_type' => 'File Type',
            'name' => 'Name',
            'ip_address' => 'Ip Address',
            'browser_description' => 'Browser Description',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
    
    public function getType(){
        return FileType::findOne($this->file_type_id);
    }

}
