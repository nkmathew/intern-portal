<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "courses".
 *
 * @property integer $id
 * @property string $course_code
 * @property string $course_name
 * @property integer $duration
 * @property string $stage_caption
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'courses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_code', 'course_name'], 'required'],
            [['duration'], 'integer'],
            [['course_code', 'course_name', 'stage_caption'], 'string', 'max' => 255],
            [['course_code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course_code' => 'Course Code',
            'course_name' => 'Course Name',
            'duration' => 'Duration',
            'stage_caption' => 'Stage Caption',
        ];
    }
}
