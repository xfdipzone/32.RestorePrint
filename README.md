# 32.RestorePrint
php 将print_r处理后的数据还原为原始数组的方法

## 介绍
php print_r方法可以把变量打印显示，使变量易于理解。如果变量是string,integer或float，将打印变量值本身，如果变量是array，将会按照一定格式显示键和元素。object与数组类似。print_r用于打印数组较多。

php原生没有把print_r方法打印后的数据还原为原始数组，因此写了下面这个方法，实现将print_r处理后的数据还原为原始数组。
<br>
<br>
## 演示代码
```php
<?php
require 'RestorePrint.class.php';

$print_r_data = <<<TXT
Array
(
    [name] => fdipzone
    [gender] => male
    [age] => 18
    [profession] => programmer
    [detail] => Array
        (
            [grade] => 1
            [addtime] => 2016-10-31
        )
)
TXT;

// 显示打印的数据
echo '显示打印的数据<br>';
echo '<pre>'.$print_r_data.'</pre>';

$oRestorePrint = new RestorePrint;
$oRestorePrint->set('Array', 'group');
$oRestorePrint->set(' [', 'brackets,[');
$oRestorePrint->set('] => ', 'brackets,]');
$oRestorePrint->set(')', 'brackets,)');

$oRestorePrint->parse($print_r_data);
$result = $oRestorePrint->res;

echo '还原为数组<br>';
var_dump($result);
?>
```

<br>

## 输出
```
显示打印的数据
Array
(
    [name] => fdipzone
    [gender] => male
    [age] => 18
    [profession] => programmer
    [detail] => Array
        (
            [grade] => 1
            [addtime] => 2016-10-31
        )
)
还原为数组
array (size=5)
  'name' => string 'fdipzone' (length=8)
  'gender' => string 'male' (length=4)
  'age' => string '18' (length=2)
  'profession' => string 'programmer' (length=10)
  'detail' => 
    array (size=2)
      'grade' => string '1' (length=1)
      'addtime' => string '2016-10-31' (length=10)
```
