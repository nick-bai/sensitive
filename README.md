Sensitive word
=========================
基于DFA算法，实现敏感词的判断 和 过滤

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require nickbai/sensitive
```

Usage
-----
1.将敏感词转为二维节点数组
```php
$words=[
    '苹果',
    '香蕉'
];
$nodes =  Utils::words2Node($words);

//[
//    [
//        Node('苹', false),
//        Node('果', true)
//    ],
//    [
//        Node('香', false),
//        Node('蕉', true)
//    ],
//]
```

2.构建字典树
```php
$tree = new Tree($nodes);
// $tree = new Tree();
// $tree->appendMultiple($nodes)
```
3.创建敏感词处理类，处理文本
```php
$sensitive = new SensitiveWords($tree);
//$sensitive = new SensitiveWords();
//$sensitive->setTree($tree);

$text = '苹果正好吃，我不爱吃香蕉, 香梨才是王道，香水有毒';
//如果文本包含敏感词，则返回包含的敏感词数组；否则返回false
$res = $sensitive->has($text);

//用指定字符，替换文本中敏感词
$string = $sensitive->filter($text,'#');
```

### 例子


```php
//敏感词数组;
$words=['苹果','香蕉'];

$nodes =  Utils::words2Node($words);
$tree = new Tree($nodes);
//如果敏感词数量比较大，字典树构建会比较慢，建议将构建好的字典树进行缓存
$sensitive = new SensitiveWords($tree);

$text = '苹果正好吃，我不爱吃香蕉, 香梨才是王道，香水有毒';
$res = $sensitive->has($text);
$string = $sensitive->filter($text,'#');
```