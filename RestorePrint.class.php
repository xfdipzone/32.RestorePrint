<?php
/**
 * 将print_r处理后的数据还原为原始数组
 * Date:    2016-10-31
 * Author:  fdipzone
 * Ver:     1.0
 */
class RestorePrint{ // class start

    public $res = array();
    protected $dict = array();
    protected $buf = '';
    protected $keyname = '';
    protected $stack = array();

    public function __construct() {
        $this->stack[] =& $this->res;
    }

    public function __call($method, $param){
        echo $this->buf .' not defined mehtod:'.$method. ' param:'.implode(',', $param);
    }

    public function set($word, $value=''){
        if(is_array($word)){
            foreach($word as $k=>$v){
                $this->set($k, $v);
            }
        }
        $p =& $this->dict;
        foreach(str_split($word) as $ch){
            if(!isset($p[$ch])){
                $p[$ch] = array();
            }
            $p =& $p[$ch];
        }
        $p['val'] = $value;
        return $this;
    }

    public function parse($str){
        $this->doc = $str;
        $this->len = strlen($str);
        $i = 0;
        while($i < $this->len){
            $t = $this->find($this->dict, $i);
            if($t){
                $i = $t;
                $this->buf = '';
            }else{
                $this->buf .= $this->doc{$i++};
            }
        }
    }

    protected function find(&$p, $i){
        if($i >= $this->len){
            return $i;
        }
        $t = 0;
        $n = $this->doc{$i};
        if(isset($p[$n])){
            $t = $this->find($p[$n], $i+1);
        }
        if($t){
            return $t;
        }
        if(isset($p['val'])){
            $arr = explode(',', $p['val']);
            call_user_func_array(array($this, array_shift($arr)), $arr);
            return $i;
        }
        return $t;
    }

    protected function group(){
        if(!$this->keyname){
            return ;
        }
        $cnt = count($this->stack)-1;
        $this->stack[$cnt][$this->keyname] = array();
        $this->stack[] =& $this->stack[$cnt][$this->keyname];
        $this->keyname = '';
    }

    protected function brackets($c){
        $cnt = count($this->stack)-1;
        switch($c){
            case ')':
                if($this->keyname){
                    $this->stack[$cnt][$this->keyname] = trim($this->buf);
                }
                $this->keyname = '';
                array_pop($this->stack);
                break;
            
            case '[':
                if($this->keyname){
                    $this->stack[$cnt][$this->keyname] = trim($this->buf);
                }
                break;
            
            case ']':
                $this->keyname = $this->buf;
                break;
        }
        $this->buf = '';
    }

} // class end
?>