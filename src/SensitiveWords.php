<?php


namespace anxu\sensitive;

class SensitiveWords
{
    /**
     * @var Tree 字典树.
     */
    private $_tree;

    /**
     * @param Tree $tree
     * @return SensitiveWords
     */
    public function setTree(Tree $tree): SensitiveWords
    {
        $this->_tree = $tree;
        return $this;
    }

    public function __construct(Tree $tree = null)
    {
        if ($tree !== null) {
            $this->setTree($tree);
        }
    }

    /**
     * 确定文本中是否包含敏感词
     *
     * @param string $text
     * @return array|boolean  如果包含则返回敏感词数组；否则返回 false
     */
    public function has($text)
    {
        $sensitiveWords = [];
        //将文本拆分为单个字符的数据
        $words = Utils::splitText2Array($text);
        $count = count($words);
        //当前匹配字符位置
        $position = 0;
        //开始匹配字符的位置
        $begin = 0;
        //字典树 root 节点
        $tmp = $this->_tree->getRootNode();
        //挨个字符，进行循环判断
        while ($position < $count) {
            $char = $words[$position];
            $subNode = $tmp->getSubNode($char);
            if (null === $subNode) {//根节点的所有子节点中没有该字符,开始匹配的位置+1，当前匹配位置 设为 开始匹配的位置;
                $begin++;
                $position = $begin;
                $tmp = $this->_tree->getRootNode();
            } elseif ($subNode->isEnd()) {//有子节点，且isEnd为true，说明发现了敏感词,根据敏感字符数组，获取敏感词；然后清空字符数组;
                //敏感词
                $word = $this->getSensitiveWord($words, $begin, $position);
                if (!in_array($word, $sensitiveWords)) {
                    array_push($sensitiveWords, $word);
                }

                //从下一个位置开始，继续匹配其他字符
                $position++;
                $tmp = $subNode;
//                $begin = $position;
//                $tmp = $this->_tree->getRootNode();
            } else {//所有子节点中有该字符，但不是结束字符;继续循环；begin 位置不变，匹配位置加1
                $tmp = $subNode;
                $position++;
            }
        }

        return empty($sensitiveWords) ? false : $sensitiveWords;
    }

    /**
     * 过滤替换文本中敏感词.
     *
     * @param string $text
     * @param string $placeholder
     * @return string
     */
    public function filter($text, $placeholder = "**")
    {
        $words = $this->has($text);
        if (!$words) {
            return $text;
        }
        $values = [];
        for ($i = 0; $i < count($words); $i++) {
            $values[] = $placeholder;
        }
        $keys = array_combine($words, $values);

        return strtr($text, $keys);
    }

    /**
     * 获取敏感词
     *
     * @param array $words
     * @param $begin
     * @param $position
     * @return string
     */
    protected function getSensitiveWord(array $words, $begin, $position)
    {
        return implode(array_slice($words, $begin, $position - $begin + 1));
    }
}