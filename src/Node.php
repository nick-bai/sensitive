<?php


namespace anxu\sensitive;


class Node
{
    private $_end = false;
    private $_value;


    /**
     * @var Node[] 当前节点子节点
     */
    private $_subNodes = array();

    public function __construct($value = '', $end = false)
    {
        $this->setEnd($end);
        $this->setValue($value);
    }

    /**
     * 是否为最后一个字符节点
     *
     * @return bool
     */
    public function isEnd(): bool
    {
        return $this->_end;
    }

    /**
     * @param bool $isEnd
     * @return Node
     */
    public function setEnd(bool $isEnd): Node
    {
        $this->_end = $isEnd;
        return $this;
    }

    /**
     * @return string 获取节点的值
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * @param string $value
     * @return Node
     */
    public function setValue($value)
    {
        $this->_value = $value;
        return $this;
    }

    /**
     * 添加子节点
     *
     * @param Node $node
     * @return $this
     */
    public function addSubNode(Node $node)
    {
        $key = $node->getValue();
        $this->_subNodes[$key] = $node;
        return $this;
    }

    /**
     * 根据节点名称获取节点
     *
     * @param $key
     * @return Node|null
     */
    public function getSubNode($key)
    {
        return isset($this->_subNodes[$key]) ? $this->_subNodes[$key] : null;
    }
}