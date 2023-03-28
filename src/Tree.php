<?php


namespace anxu\sensitive;


class Tree
{
    /**
     * @var Node 字典树根节点
     */
    private $_rootNode;


    public function __construct($nodes = null)
    {
        $this->_rootNode = new Node('ROOT');

        if (!empty($nodes)) {
            $this->appendMultiple($nodes);
        }
    }

    /**
     * 添加敏感词到字典树中
     *
     * @param Node[] $nodes 敏感词节点数组
     *
     * @example
     * 敏感词："你好", 对应的节点数组:
     * [
     *      Node('你', false),
     *      Node('好', true)
     * ]
     *
     */
    public function append($nodes)
    {
        $rootNode = $this->_rootNode;

        for ($i = 0, $count = count($nodes); $i < $count; $i++) {
            $node = $nodes[$i];
            $tmpNode = $rootNode->getSubNode($node->getValue());

            if (null === $tmpNode) {
                $rootNode->addSubNode($node);
                $tmpNode = $node;
            } else {
                if ($node->isEnd()) {
                    $tmpNode->setEnd(true);
                }
            }
            $rootNode = $tmpNode;
        }
    }

    /**
     * 添加多个敏感词到字典树
     *
     * @param $words
     *
     * @example
     * 敏感词："你好"、"苹果", 对应的节点数组:
     * [
     *      [
     *          Node('你', false),
     *          Node('好', true)
     *      ],
     *      [
     *          Node('苹', false),
     *          Node('果', true)
     *      ],
     * ]
     *
     */
    public function appendMultiple($words)
    {
        foreach ($words as $word) {
            $this->append($word);
        }
    }

    /**
     * 获取字典树根节点
     * @return Node
     */
    public function getRootNode()
    {
        return $this->_rootNode;
    }

}