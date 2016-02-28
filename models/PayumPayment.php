<?php

namespace frontend\modules\payum\models;

use Yii;
use Payum\Core\Model\PaymentInterface;

/**
 * This is the model class for table "payment_subscription".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $description
 * @property string $client_email
 * @property string $client_id
 * @property string $currency_code
 * @property integer $total_amount
 * @property integer $currency_digits_after_decimal_point
 *
 * @property User $user
 */
class PayumPayment extends \yii\db\ActiveRecord implements PaymentInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payum_payment';
    }

    /**
     * @inheritdoc
     */
     public function rules()
     {
         return [
             ['number', 'required'],
             ['total_amount, currency_digits_after_decimal_point', 'numerical', 'integerOnly' => true],
             ['number, client_email, client_id, currency_code', 'length', 'max' => 255],
             ['description', 'safe'],
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
            'description' => 'Description',
            'client_email' => 'Client Email',
            'client_id' => 'Client ID',
            'currency_code' => 'Currency Code',
            'total_amount' => 'Total Amount',
            'currency_digits_after_decimal_point' => 'Currency Digits After Decimal Point',
        ];
    }

            /**
         * @param string $currencyCode
         * @param int    $digitsAfterDecimalPoint
         */
        public function setCurrencyCode($currencyCode, $digitsAfterDecimalPoint = 2)
        {
            $this->currency_code = $currencyCode;
            $this->currency_digits_after_decimal_point = $digitsAfterDecimalPoint;
        }

              /**
        * @param string $clientId
        */
       public function setClientId($clientId)
       {
           $this->client_id = $clientId;
       }

               /**
         * {@inheritDoc}
         *
         * @param array|\Traversable $details
         */
        public function setDetails($details)
        {
            if ($details instanceof \Traversable) {
                $details = iterator_to_array($details);
            }

            $this->details = serialize($details);
        }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
 * @return \yii\db\ActiveQuery
 */
public function getPayumTokens()
{
    return $this->hasMany(PayumToken::className(), ['details_id' => 'id']);
}
}
