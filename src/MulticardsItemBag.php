<?php
/**
 * Multicards Item bag
 */

namespace Omnipay\Multicards;

use Omnipay\Common\ItemBag;

/**
 * Class MulticardsItemBag
 *
 * @package Omnipay\Multicards
 */
class MulticardsItemBag extends ItemBag
{
    /**
     * Add an item to the bag
     *
     * @see Item
     *
     * @param ItemInterface|array $item An existing item, or associative array of item parameters
     */
    public function add($item)
    {
        if ($item instanceof ItemInterface) {
            $this->items[] = $item;
        } else {
            $this->items[] = new MulticardsItem($item);
        }
    }
}
