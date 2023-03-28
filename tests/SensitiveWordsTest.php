<?php


use anxu\sensitive\SensitiveWords;
use anxu\sensitive\Tree;
use anxu\sensitive\Node;
use anxu\sensitive\Utils;
use PHPUnit\Framework\TestCase;

class SensitiveWordsTest extends TestCase
{
    /**
     * @var SensitiveWords;
     */
    private $sensitive;

    protected function setUp()
    {
        $tree = new Tree($this->getWords());
        $this->sensitive = new SensitiveWords($tree);
    }

    protected function getWords()
    {
        $words = [
            '苹果',
            '香蕉',
            '香梨',
        ];
        return Utils::words2Node($words);
    }


    public function testHas()
    {
        $text = '苹果正好吃，我不爱吃香蕉, 香梨才是王道，香水有毒';
        $res = $this->sensitive->has($text);
        $this->assertCount(3, $res);
        $this->assertEquals(true, in_array('苹果', $res));
        $this->assertEquals(true, in_array('香蕉', $res));
    }


    public function testFilter()
    {
        $text = '苹果正好吃，我不爱吃香蕉, 香梨才是王道，香水有毒';
        $after = '**正好吃，我不爱吃**, **才是王道，香水有毒';
        $res = $this->sensitive->filter($text);
        $this->assertEquals($after, $res);

        $after = '#正好吃，我不爱吃#, #才是王道，香水有毒';
        $res = $this->sensitive->filter($text, '#');
        $this->assertEquals($after, $res);
    }


    protected function tearDown()
    {
        $this->sensitive = null;
    }

}
