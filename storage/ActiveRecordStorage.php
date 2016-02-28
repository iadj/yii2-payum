<?php
namespace frontend\modules\payum\storage;

use Payum\Core\Storage\AbstractStorage;
use Payum\Core\Storage\StorageInterface;

use Payum\Core\Model\Identity;
use yii\db\ActiveRecord;

class ActiveRecordStorage extends AbstractStorage
{

    /**
     * {@inheritDoc}
     */
    public function doUpdateModel($model)
    {
        $model->save();
    }
    /**
     * {@inheritDoc}
     */
    public function doDeleteModel($model)
    {
        $model->delete();
    }
    /**
     * {@inheritDoc}
     */
    public function doGetIdentity($model)
    {
        if ($model->isNewRecord) {
            throw new LogicException('The model must be persisted before usage of this method');
        }
        return new Identity($model->{$model->primaryKey()}, $model);
    }
    /**
     * {@inheritDoc}
     */
    public function doFind($id)
    {
        return $this->className()->findOne($id);
    }
    /**
     * {@inheritDoc}
     */
    public function findBy(array $criteria)
    {
        return $this->className()->findOne($criteria);
    }
}
