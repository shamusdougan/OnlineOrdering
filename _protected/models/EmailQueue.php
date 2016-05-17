<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email_queue".
 *
 * @property integer $id
 * @property string $from
 * @property string $to
 * @property string $subject
 * @property resource $htmlBody
 * @property resource $attachment1
 * @property string $attachment1_filename
 * @property string $attachment1_type
 * @property resource $attachment2
 * @property string $attachment2_filename
 * @property string $attachment2_type
 */
class EmailQueue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_queue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from', 'to', 'subject', 'htmlBody'], 'required'],
            [['htmlBody', 'attachment1', 'attachment2'], 'string'],
            [['from', 'to', 'subject', 'attachment1_filename', 'attachment1_type', 'attachment2_filename', 'attachment2_type'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from' => 'From',
            'to' => 'To',
            'subject' => 'Subject',
            'htmlBody' => 'Html Body',
            'attachment1' => 'Attachment1',
            'attachment1_filename' => 'Attachment1 Filename',
            'attachment1_type' => 'Attachment1 Type',
            'attachment2' => 'Attachment2',
            'attachment2_filename' => 'Attachment2 Filename',
            'attachment2_type' => 'Attachment2 Type',
        ];
    }
    
    
    public function send()
    {
		$message = Yii::$app->mailer->compose()
		    ->setFrom($this->from)
		    ->setTo($this->to)
		    ->setSubject($this->subject)
		    ->sethtmlBody($this->htmlBody);
		if($this->attachment1)
			{
			$message->attachContent($this->attachment1, ['fileName' => $this->attachment1_filename, 'contentType' => $this->attachment1_type]);
			}
		    
		if(!$message->send())
			{
			return "Error Sending Email , Subject: "	.$this->subject;
			}
		
		$this->delete();
		return;
		
		
	}
}
