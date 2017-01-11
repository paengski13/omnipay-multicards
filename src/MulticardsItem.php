<?php
/**
 * Multicards Item
 */

namespace Omnipay\Multicards;

use Omnipay\Common\Item;

/**
 * Class MulticardsItem
 *
 * @package Omnipay\Multicards
 */
class MulticardsItem extends Item
{
    /**
     * {@inheritDoc}
     */
    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    /**
     * Set the item code
     */
    public function setAmount($value)
    {
        return $this->setParameter('amount', $value);
    }
}
