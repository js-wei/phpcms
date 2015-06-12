<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lsl
 * Date: 13-8-28
 * Time: 下午2:58
 * 敏感词过滤工具类
 * 使用方法
 * echo FilterTool::filterContent("你妈的我操一色狼杂种二山食物","*",DIR."config/word.txt",$GLOBALS["p_memcache"]["bad_words"]);
 */
namespace Tool;
class FilterTool {
    public static $keyword = array();
    /**
     * 从文件中加载敏感词
     * @param $filename
     * @return array
     */
    static function getBadWords($filename){
        $file_handle = fopen($filename, "r");
        while (!feof($file_handle)) {
            $line = trim(fgets($file_handle));
            array_push(self::$keyword,$line);
        }
        fclose($file_handle);
        return self::$keyword;
    }
    /**
     * @param $content 待处理字符串
     * @param $target  替换后的字符
     * @param $filename  敏感词配置文件
     * @param $memconfig 缓存配置文件
     * @return 处理后的字符串
     */
    static function filterContent($content,$target,$filename,$memconfig){
        $mem = new BadWordsMemcache($filename,$memconfig);
        $keyword = $mem->getList();
        if(count($keyword) == 0){
            $keyword = self::getBadWords($filename);
        }
        return strtr($content, array_combine($keyword, array_fill(0,count($keyword), $target)));
    }
 
}
 
/**
 * 敏感词缓存处理类
 * Class BadWordsMemcache
 * User: lsl
 */
class BadWordsMemcache{
    var $memcache;
    var $key;
    var $list;
    var $filename;
    function __construct($filename,$memconfig) {
        $this->filename = $filename;
        if(!class_exists("P_Memcache")){
            require_once DIR."lib/memcache.class.php";
        }
        $this->key = "bad_words";
        $this->memcache = new P_Memcache();
        $this->memcache->config = $memconfig;
        $this->memcache->connect();
        print_r($this->memcache);
        $this->init();
    }
    function __destruct() {
        $this->memcache->close();
    }
    /**
     * 初始化
     * @param bool $isReset
     */
    function init($isReset = false){
        $this->list = $this->memcache->get($this->key)?$this->memcache->get($this->key):array();
        if(count($this->list)==0 || $isReset){
            $this->list = filterTools::getBadWords($this->filename);
            $this->memcache->set($this->key, $this->list);
            $log_data = Log::formatData($this->list);
            Log::logWrite($log_data, 'bad.words','init');
        }
    }
    /**
     * 获取列表
     * @return mixed
     */
    function getList(){
        return $this->list;
    }
}