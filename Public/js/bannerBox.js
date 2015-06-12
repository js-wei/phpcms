(function(){
$.fn.BannerBox=function(options){
	$defaults = {
			auto: true,
			timespan:2500,
			speed:1000,
			point:true
		};

	  $this=$(this);
	  $speed=0;
	  $index_two=0;
	  $opts = $.extend($defaults,options);

	  $('div.banner-container').css({
	  	'height': 'aotu',
	  	'overflow': 'hidden',
	  	'position': 'relative',
	  	'width':$('ul.banner-image-content>li>img').width()
	  });
	  $('ul.banner-image-content').css({
	  	'list-style-type': 'none',
	  	'width': '999999px'
	  }).children('li').css('float', 'left');
	  $length=$('.banner-image-content li').length;
	  $html='<div class="banner-list"><ul class="banner-list-content">';
	  for (var i = 0; i <$length; i++) {
			if(i==0){
				$html+='<li class="active">&#8226;</li>';
			}else{
				$html+='<li>&#8226;</li>';
			}
	  };

	  $html+='</ul></div>';
	  if($opts.point){
	  		$height=$('.banner-image-content li').outerHeight();
	  		
			$this.append($html);
			$('ul.banner-list-content>li').css('font-size','50px');
			$size=$('ul.banner-list-content>li').css('font-size');

	  		$size=parseInt($size.replace('/px/', ''));

	  		$height=$height-$size;
			$('div.banner-list').css({
				'position': 'absolute',
				'float': 'right',
				'right':'50%'
			}).css('top', $height+'px');
			$('ul.banner-list-content>li').css({
				'list-style-type': 'none',
				'float': 'left',
				'cursor':'pointer',
				'padding':'0px',
				'margin':'0px',
				'width':'15px',
			});
	  }
	  $speed=$opts.speed;
	  $continer=$('.banner-image').width();

	  //$('ul.banner-list-content').width(($length+1)*$size);
	  $('.banner-list-content li').on('mouseover',function() {
			$(this).addClass('active').siblings().removeClass('active');
			$index=$(this).index();
			$index_two=$index;
			$left=$continer * -$index;
			$('.banner-image-content').animate({'margin-left':$left+'px'},$speed);
	  });
	  if($opts.auto){
			stockInterval = setInterval(autoScroll, $opts.timespan); 
			$('.banner-list-content li,.banner-image-content li').each(function() {
				$(this).on('mouseover', function(event) {
					clearInterval(stockInterval);
				});
				$(this).on('mouseout', function(event) {
					stockInterval = setInterval(autoScroll, $opts.timespan); 
				});
			});
	  }

	function autoScroll(){	
		$length=$('.banner-image-content li').length-1;
		$index_two<$length?$index_two++:$index_two=0;
		$left=$continer * -$index_two;
		$('.banner-image-content').animate({
			'margin-left':$left+'px'
			},
			$speed, function() {
			$('.banner-list li').eq($index_two).addClass('active').siblings().removeClass('active');
		});
		
	}
	 
 }	

})(jQuery);