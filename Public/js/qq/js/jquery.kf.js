var online=new Array();
(function(){
	$.fn.kefu=function(options){
	   $defaults = {
			qq:'524314430,12345665',
			title:'我的QQ在线客服',
			keywords:'我的QQ在线客服',
			
	   };

	  $this=$(this);
	  $opts = $.extend($defaults,options);
	  $title=$opts.title;
	  $keywords=$opts.keywords;
	  $qq=$opts.qq; 
	  $reset_qq='';
	  $conmost=0;
	  if($qq.indexOf('*')>0){
	  		$conmost=1;
	  		$temp=$qq.split('*');
		  	for (var i = 0; i < $temp.length-1; i++) {
			  	$tempitem=$temp[i].split('|');
		  		$reset_qq += $tempitem[0].replace(/,/g,':'); 
			};
	  }else{
	  	$reset_qq=$qq.replace(/,/g,':');
	  }

	  if($reset_qq.charAt($reset_qq.length-1)!=':'){
	  	 $reset_qq+=':';
	  }
	  
	  
	  
      $html='<div id="kf"><div class="kf-continer" id="kf-default"><div class="kf-continer-top"><a href="javascript:void(0);" id="kf-close"></a></div><div class="kf-continer-middle"><ul class="kf-list">';

	  $.getScript('http://webpresence.qq.com/getonline?Type=1&'+$reset_qq, function(data) {
	  	  	//执行代码
	  		$qq=$qq.split(':');
	  		$qq_status='';
	  		
	  		for (var i = 0; i <= online.length - 1; i++) {
	  			if($conmost==1){
	  				$tempitem=$temp[i].split('|');
		  			$i= i + 1;
		  			if(online[i]==1){
		  				$html +='<li style="background:url('+$js+'/qq/face/1.gif) no-repeat 0 5px; padding-left:25px;height:30px;line-height:30px;margin-left:10px;">'+'<a href="javascript:vod(0);" id="open-dialog" data-role="'+$qq[i]+','+$title+','+$keywords+'">'+ $tempitem[1] +'</a>'+'</li>';
		  			}else{
		  				$html +='<li style="background:url('+$js+'/qq/face/1_f.gif) no-repeat 0 5px; padding-left:25px;height:30px;line-height:30px;margin-left:10px;">'+'<a href="javascript:vod(0);">'+ $tempitem[1] +'</a>'+'</li>'
		  			}
	  			}else{
	  				$i= i + 1;
		  			if(online[i]==1){
		  				$html +='<li style="background:url('+$js+'/qq/face/1.gif) no-repeat 0 5px; padding-left:25px;height:30px;line-height:30px;margin-left:10px;">'+'<a href="javascript:vod(0);" id="open-dialog" data-role="'+$qq[i]+','+$title+','+$keywords+'">客服'+ $i +'</a>'+'</li>';
		  			}else{
		  				$html +='<li style="background:url('+$js+'/qq/face/1_f.gif) no-repeat 0 5px; padding-left:25px;height:30px;line-height:30px;margin-left:10px;">'+'<a href="javascript:vod(0);">客服'+ $i +'</a>'+'</li>'
		  			}
	  			}
	  		};

	  		$html +='</ul></div><div class="kf-continer-bottom"></div></div><div id="kf-simple" style="display:none;"></div></div>';

	  		$this.append($html);
	  		$kfHeight=$('#kf').height();
	  		$client=$(document).height();
	  		$('#kf').css('top',(($client-$kfHeight)/2.5)+'px');
	  		$('#kf-close').on('click', function(event) {
	  			event.preventDefault();
	  			$('#kf-default').hide();
	  			$('#kf-simple').show();
	  		});

	  		$('#kf-simple').on('click', function(event) {
	  			$('#kf-default').show();
	  			$('#kf-simple').hide();
	  		});

	  		$('#open-dialog').on('click', function(event) {
	  			event.preventDefault();
	  			$query=$(this).attr('data-role').split(',');
	  			window.open('http://wpa.qq.com/msgrd?v=3&uin='+$query[0]+'&site='+$query[1]+'&menu=no', '_blank', 'height=502, width=644,toolbar=no,scrollbars=no,menubar=no,status=no');
	  		});

	   });
	}	
})(jQuery);


