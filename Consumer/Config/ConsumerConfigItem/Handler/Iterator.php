<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Framework\MessageQueue\Consumer\Config\ConsumerConfigItem\Handler;

use Magento\Framework\MessageQueue\Consumer\Config\ConsumerConfigItem\HandlerInterface;
use Magento\Framework\MessageQueue\Consumer\Config\ConsumerConfigItem\HandlerInterfaceFactory;

/**
 * Consumer handler config iterator.
 */
class Iterator implements \Iterator, \ArrayAccess
{
    /**
     * Consumer config handler item.
     *
     * @var HandlerInterface
     */
    private $flyweight;

    /**
     * Config data.
     *
     * @var array
     */
    private $data;

    /**
     * Initialize dependencies.
     *
     * @param HandlerInterfaceFactory $itemFactory
     */
    public function __construct(HandlerInterfaceFactory $itemFactory)
    {
        $this->flyweight = $itemFactory->create();
    }

    /**
     * Set data.
     * 
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get current item.
     *
     * @return HandlerInterface
     */
    public function current()
    {
        return $this->flyweight;
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        next($this->data);
        if (current($this->data)) {
            $this->initFlyweight(current($this->data));
        }
    }

    /**
     * Initialize flyweight object.
     *
     * @param array $data
     * @return void
     */
    private function initFlyweight(array $data)
    {
        $this->flyweight->setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        key($this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return (bool)current($this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        reset($this->data);
        if (current($this->data)) {
            $this->initFlyweight(current($this->data));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset)) {
            return null;
        }
        $item = clone $this->flyweight;
        $item->setData($this->data[$offset]);
        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}
