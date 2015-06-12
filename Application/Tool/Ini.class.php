<?php
namespace Tool;

class Ini{
	/**
	 * [set 设置指定的PHP Ini]
	 * @param [type] $key   [Ini键]
	 * @param [type] $value [Ini值]
	 */
	public function set($key,$value){
		return ini_set($key,$value);
	}
	/**
	 * [get 获取指定的PHP Ini信息]
	 * @param  [type] $key [Ini键]
	 * @return [type]      [description]
	 */
	public function get($key){
		return ini_get($key);
	}
	/**
	 * [getAll 获取PHP Ini信息]
	 * @return [type] [description]
	 */
	public function getAll(){
		return ini_get_all();
	}
	/**
	 * [restore 恢复 PHP Ini到原始状态]
	 * @param  [type] $key [Ini键]
	 * @return [type]      [description]
	 */
	public function restore($key){
		return ini_restore($key);
	}
	/**
	 * [getPath 得到PHP Ini路径]
	 * @return [type] [description]
	 */
	public function getPath(){
		return php_ini_loaded_file();
	}
	/**
	 * [getIni 获取PHP Ini信息]
	 * @return [type] [description]
	 */
	public function getIni(){
		$path=$this->getPath();
		$ini=file_get_contents($path);
		return $this->parse_ini_string_m($ini);
	}
	/**
	 * [parse_ini_string_m 序列获取PHP Ini文件]
	 * @param  [type] $str [description]
	 * @return [type]      [description]
	 */
	private function parse_ini_string_m($str) {
	    if(empty($str)) return false;
	    $lines = explode("\n", $str);
	    $ret = Array();
	    $inside_section = false;

	    foreach($lines as $line) {
	        $line = trim($line);
	        if(!$line || $line[0] == "#" || $line[0] == ";") continue;
	        if($line[0] == "[" && $endIdx = strpos($line, "]")){
	            $inside_section = substr($line, 1, $endIdx-1);
	            continue;
	        }

	        if(!strpos($line, '=')) continue;
	        $tmp = explode("=", $line, 2);

	        if($inside_section) {
	            $key = rtrim($tmp[0]);
	            $value = ltrim($tmp[1]);

	            if(preg_match("/^\".*\"$/", $value) || preg_match("/^'.*'$/", $value)) {
	                $value = mb_substr($value, 1, mb_strlen($value) - 2);
	            }

	            $t = preg_match("^\[(.*?)\]^", $key, $matches);
	            if(!empty($matches) && isset($matches[0])) {

	                $arr_name = preg_replace('#\[(.*?)\]#is', '', $key);
	                if(!isset($ret[$inside_section][$arr_name]) || !is_array($ret[$inside_section][$arr_name])) {
	                    $ret[$inside_section][$arr_name] = array();
	                }
	                if(isset($matches[1]) && !empty($matches[1])) {
	                    $ret[$inside_section][$arr_name][$matches[1]] = $value;
	                } else {
	                    $ret[$inside_section][$arr_name][] = $value;
	                }

	            } else {
	                $ret[$inside_section][trim($tmp[0])] = $value;
	            }            
	        } else {     
	            $ret[trim($tmp[0])] = ltrim($tmp[1]);
	        }
	    }
	    return $ret;
	}
}