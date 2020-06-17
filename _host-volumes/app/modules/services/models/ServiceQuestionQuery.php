<?php

namespace app\modules\services\models;

/**
 * This is the ActiveQuery class for [[ServiceQuestion]].
 *
 * @see ServiceQuestion
 */
class ServiceQuestionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ServiceQuestion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ServiceQuestion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
