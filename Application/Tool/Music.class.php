<?php 
  /**
    * 搜索百度mp3
    * @param $key   歌曲名
    * @return array 返回所有内容列表
          'song_id'             => 歌曲百度id
          'song'                => 歌曲名称
          'singer'              => 歌手
          'album'               => 专辑
          'singerPicSmall'      => 歌曲小图
          'singerPicLarge'      => 歌曲大图
          'albumPicSmall'       => 专辑小图
          'albumPicLarge'       => 专辑大图
          'lrc'                 => 歌词
          'mp3Link'             => mp3地址
    */
namespace Tool;

class Music{
    private $url=array(
           //搜搜音乐地址 http://cgi.music.soso.com/fcgi-bin/m.q?w=[歌名/歌手名]&p=[页数]&t=[格式]
           //格式: -1-全部 0-MP3 1-RM ，2-WMA
          "SosoUrl"=>"http://cgi.music.soso.com/fcgi-bin/m.q?w={0}&p={1}&t=-1",
          // 百度音乐地址 http://mp3.baidu.com/m?f=ms&rf=idx&tn=baidump3&ct=134217728&lf=&rn=&word=[歌名/歌手名]&lm=[格式]&pg=[页数]
          // -格式：-1-全部 0-MP3 1-RM ，2-WMA
          "BaiduUrl"=>"http://mp3.baidu.com/m?f=ms&rf=idx&tn=baidump3&ct=134217728&lf=&rn=&word={0}&lm=-1&pg={1}",
          //百度音乐快搜地址 http://box.zhangmen.baidu.com/x?op=12&count=1&title=[歌名]$$[歌手名]$$$$
          "BaiduQuickUrl"=>"http://box.zhangmen.baidu.com/x?op=12&count=1&title={0}\$\${2}\$\$\$\$",
          //千千静听歌词信息地址 http://ttlrcct.qianqian.com/dll/lyricsvr.dll?sh?Artist=[歌手名]&Title=[歌名]
          "TTLrcListUrl"=>"http://ttlrcct.qianqian.com/dll/lyricsvr.dll?sh?Artist={0}&Title={1}",
          // 千千静听歌词地址 http://ttlrccnc.qianqian.com/dll/lyricsvr.dll?dl?Id=[歌曲ID]&Code=[title和artist]&uid=03&mac=002421585787&hds=WD-WMAV22344505"
          "TTLrcUrl"=>"http://ttlrccnc.qianqian.com/dll/lyricsvr.dll?dl?Id={0}&Code={1}&uid=03&mac=002421585787&hds=WD-WMAV22344505",
        );

    public  function search($key,$p=1){
        //$url = str_replace('{1}',str_replace('{0}',$key,$this->url['SosoUrl']),$p);
        $url=$this->url['BaiduQuickUrl'];
        $url=str_replace('{1}',$p,str_replace('{0}',urlencode($key),$url));

        $data =$this->get_con($url);
        
        return $data;
    }

        
    /**
    * 访问网址并取得其内容
    * @param $url String 网址
    * @param $postFields Array 将该数组中的内容用POST方式传递给网址中
    * @param $cookie_file string cookie文件
    * @param $r_or_w string 写cookie还是读cookie或是两都都有，r读，w写，a两者，null没有cookie
    * @return String 返回网址内容
    */
    private  function get_con($url, $postFields = null, $cookie_file = null, $r_or_w = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);     // 模拟用户使用的浏览器  
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);                         // 使用自动跳转   
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);                             // 自动设置Referer
        
        if ($cookie_file && ($r_or_w == 'a' || $r_or_w == 'w')) 
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);                 // 存放Cookie信息的文件名称
        if ($cookie_file && ($r_or_w == 'a' || $r_or_w == 'r')) 
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);             // 读取上面所储存的Cookie信息
            
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);                                 // 设置超时限制防止死循环
        curl_setopt($ch, CURLOPT_HEADER, 0);                                 // 显示返回的Header区域内容
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     
        if (is_array($postFields) && 0 < count($postFields)){
            $postBodyString = "";
            foreach ($postFields as $k => $v)
            {
                $postBodyString .= "$k=" . urlencode($v) . "&";
            }
            unset($k, $v);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString,0,-1));
        }
     
        $reponse = curl_exec($ch);
        if (curl_errno($ch))
            throw new Exception(curl_error($ch),0);
        else
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);      
        curl_close($ch);
        return $reponse;
    }
}