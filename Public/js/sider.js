(function(){
$.fn.Banner=function(options){
	　var defaults = {
			auto: true,
			timespan:1500,
			point:true,
			type:1
　　　　};
	  $this=$(this);
	  $('.banner-image>li').first().css('z-index',99);
　　  var opts = $.extend(defaults,options);
	  $length=$('.banner-image li').length;
	  $html='<div class="banner-list"><ul>';
	  for (var i = 0; i <$length; i++) {
			if(i==0){
				$html+='<li class="acrive">&#8226;</li>';
			}else{
				$html+='<li>&#8226;</li>';
			}
	  };

	  $html+='</ul></div>';
	  if(opts.point){
		$this.append($html);
		$('.banner-list>ul').css('z-index',100).width($length*50);	//设置生成的点
	  }
	  $top=$('.banner-image>li').outerHeight()-50;	
	  $left= ($('.banner-image>li').outerWidth()-100)/2;
	  $('.banner-list>ul').css('left',$left+'px').css('top',$top+'px');	//重置位置

	  $('.banner-list li').on('mouseover',function() {
			$(this).addClass('acrive').siblings().removeClass('acrive');
			$index=$(this).index();
			$show=$('.banner-image li').eq($index);
			$('.banner-list>ul').css('z-index',100);
			$show.css('z-index',99).siblings().removeAttr('style');
	  });
	  if(opts.auto){
			stockInterval = setInterval(autoScroll, opts.timespan); 
			$('.banner-list li').each(function() {
				$(this).on('mouseover', function(event) {
					clearInterval(stockInterval);
				});
				$(this).on('mouseout', function(event) {
					stockInterval = setInterval(autoScroll, opts.timespan); 
				});
			});
	  }
	 
 }	
$index_two=0;
function autoScroll(){	
	$length=$('.banner-image li').length;
	$index_two<$length?$index_two++:$index_two=0;
	$show=$('.banner-image li').eq($index_two);
	$show.css('z-index',99).siblings().removeAttr('style');
	$('.banner-list>ul').css('z-index',100);
	$('.banner-list li').eq($index_two).addClass('acrive').siblings().removeClass('acrive');
}	
})(jQuery);