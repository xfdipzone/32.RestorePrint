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