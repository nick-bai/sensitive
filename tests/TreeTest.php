<?php


use anxu\sensitive\Tree;
use anxu\sensitive\Node;
use PHPUnit\Framework\TestCase;

class TreeTest extends TestCase
{
    /**
     * @var Tree
     */
    protected $tree;

    protected function setUp()
    {
        $this->tree = new Tree();
    }


    public function testAppend()
    {
        $chars = [
            new Node('你'),
            new Node('好', true)
        ];
        $this->tree->append($chars);

        $root = $this->tree->getRootNode();
        $this->assertInstanceOf(Node::class, $root->getSubNode('你'));
        $this->assertSame($chars[0], $root->getSubNode('你'));

        $root = $chars[0];
        $this->assertInstanceOf(Node::class, $root->getSubNode('好'));
        $this->assertSame($chars[1], $root->getSubNode('好'));

    }

    public function testAppendMultiple()
    {
        $words = [
            [
                new Node('苹'),
                new Node('果', true)
            ],
            [
                new Node('苹'),
                new Node('果'),
                new Node('汁', true)
            ]
        ];
        $this->tree->appendMultiple($words);

        $root = $this->tree->getRootNode();
        $node1 = $root->getSubNode('苹');
        $this->assertInstanceOf(Node::class, $node1);
        $this->assertEquals('苹', $node1->getValue());

        $node2 = $node1->getSubNode('果');
        $this->assertInstanceOf(Node::class, $node2);
        $this->assertEquals('果', $node2->getValue());
        $this->assertEquals(true, $node2->isEnd());

        $node3 = $node2->getSubNode('汁');
        $this->assertInstanceOf(Node::class, $node3);
        $this->assertEquals('汁', $node3->getValue());
        $this->assertEquals(true, $node3->isEnd());
    }


    public function testGetRootNode()
    {
        $this->assertEquals('ROOT', $this->tree->getRootNode()->getValue());
    }

    protected function tearDown()
    {
        $this->tree = null;
    }
}
