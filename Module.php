<?php
namespace frontend\modules\payum;

use Payum\Core\PayumBuilder;
use Payum\Core\Payum;
use frontend\modules\payum\storage\ActiveRecordStorage as ActiveRecordStorage;

class Module extends \yii\base\Module
{

    public $gateways;

    public function init()
    {

        foreach($this->gateways as $gateway){
          $this->params[$gateway['gateway']] = (new PayumBuilder())
              ->addDefaultStorages()
              ->addGateway($gateway['gateway'], $gateway)
              ->getPayum();
        }

        parent::init();

    }
}
