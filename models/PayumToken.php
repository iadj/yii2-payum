<?php

namespace frontend\modules\payum\models;

use Yii;
use Payum\Core\Security\TokenInterface;
use Payum\Core\Security\Util\Random;
/**
 * This is the model class for table "payment_payum_token".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $hash
 * @property string $payment_name
 * @property string $after_url
 * @property string $target_url
 * @property integer $details_id
 */
class PayumToken extends \yii\db\ActiveRecord implements TokenInterface
{
        /**
       * {@inheritDoc}
       */
      public function init()
      {
          $this->hash = Random::generateToken();
      }

      /**
 * {@inheritDoc}
 */
public function setHash($hash)
{
    $this->hash = $hash;
}

/**
 * {@inheritDoc}
 */
public function setTargetUrl($targetUrl)
{
    $this->target_url = $targetUrl;
}

/**
 * {@inheritDoc}
 */
public function setAfterUrl($afterUrl)
{
    return $this->after_url = $afterUrl;
}


    /**
     * {@inheritDoc}
     */
    public function setPaymentName($paymentName)
    {
        $this->payment_name = $paymentName;
    }

    /**
 * {@inheritDoc}
 */
public function setDetails($details)
{
    $this->details_id = $details->getId();
}


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payum_token';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'details_id'], 'integer'],
            [['hash', 'after_url', 'target_url'], 'string', 'max' => 255],
            [['payment_name'], 'string', 'max' => 64],
            ['after_url, target_url', 'safe'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'hash' => 'Hash',
            'payment_name' => 'Payment Name',
            'after_url' => 'After Url',
            'target_url' => 'Target Url',
            'details_id' => 'Details ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetails()
    {
        return $this->hasOne(PayumPayment::className(), ['id' => 'details_id']);
    }

}
