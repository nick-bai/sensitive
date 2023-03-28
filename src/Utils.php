<?php


namespace anxu\sensitive;


class Utils
{

    /**
     * 将敏感词按字符分割
     *
     * @param string $str
     * @param string $encoding
     * @return array
     */
    public static function splitText2Array($str, $encoding = 'UTF-8')
    {
        $str = strtolower($str);
        $len = mb_strlen($str, $encoding);
        $res = [];
        for ($i = 0; $i < $len; $i++) {
            $res[] = mb_substr($str, $i, 1, $encoding);
        }
        return $res;
    }

    /**
     * 将敏感词 字符串数组 转为 Node数组
     *
     * @param $words
     * @return array
     */
    public static function words2Node($words)
    {
        $nodes=[];
        foreach ($words as $word) {
            $chars = self::splitText2Array($word);
            $data=[];
            for ($i = 0, $count = count($chars); $i < $count; $i++) {
                $char = $chars[$i];
                $isEnd = $i === $count - 1 ? true : false;
                $node = new Node($char, $isEnd);
                $data[] = $node;
            }
            $nodes[]=$data;
        }

        return $nodes;
    }
}