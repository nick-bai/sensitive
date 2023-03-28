<?php


use anxu\sensitive\Utils;
use PHPUnit\Framework\TestCase;

class UtilsTest extends TestCase
{

    public function testSplitText2Array()
    {
        $text = "苹果汁";
        $chars = Utils::splitText2Array($text);
        $this->assertIsArray($chars);
        $this->assertCount(3, $chars);
        $this->assertEquals($text, implode($chars));
    }

    public function testWords2Node()
    {
        $words = [
            '苹果',
            '香蕉',
            '香梨',
        ];
        $res = Utils::words2Node($words);

        $this->assertCount(3, $res);

        foreach ($words as $k => $v) {
            $chars = Utils::splitText2Array($v);
            foreach ($chars as $i => $char) {
                $node = $res[$k][$i];
                $this->assertEquals($char, $node->getValue());
            }
        }
    }
}
