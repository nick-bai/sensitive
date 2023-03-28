<?php


use anxu\sensitive\Node;
use PHPUnit\Framework\TestCase;

class NodeTest extends TestCase
{
    /**
     * @var Node
     */
    protected $node;

    protected function setUp()
    {
        $this->node = new Node('ROOT', true);
    }


    public function testGetValue()
    {
        $this->assertEquals('ROOT', $this->node->getValue());
    }

    /**
     * @depends testGetValue
     */
    public function testSetValue()
    {
        $this->node->setValue('test');

        $this->assertEquals('test', $this->node->getValue());
    }
    
    public function testAddSubNodeAndGetSubNode()
    {
        $node = new Node('test', true);
        $this->node->addSubNode($node);

        $this->assertInstanceOf(Node::class, $this->node->getSubNode($node->getValue()));
        $this->assertSame($node, $this->node->getSubNode($node->getValue()));

    }

    public function testIsEnd()
    {
        $this->assertEquals(true, $this->node->isEnd());
    }

    /**
     * @depends testIsEnd
     */
    public function testSetEnd()
    {
        $this->node->setEnd(false);
        $this->assertEquals(false, $this->node->isEnd());
    }

    protected function tearDown()
    {
        $this->node = null;
    }
}
