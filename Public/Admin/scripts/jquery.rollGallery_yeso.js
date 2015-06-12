/*******************************

* rollGallery
* Copyright (c) yeso!
* Date: 2010-10-13

说明：
* 必须对包裹子元素的直接父元素应用该方法
* example: $("#picturewrap").rollGallery({ direction:"top",speed:2000,showNum:4,aniMethod:"easeOutCirc"});
* direction:移动方向。可取值为："left" "top"
* speed:速度。单位毫秒
* noStep:设置为：true  则按非步进方式滚动。非步进下动画效果失效。
* speedPx:非步进滚动下的移动速度。单位像素
* showNum:显示个数。即父元素能容纳的子元素个数
* rollNum:一次滚动的个数。注意总个数必须为rollNum的倍数！
* aniSpeed:动画速度
* aniMethod:动画方法（需插件（如：easing）支持）
* childrenSel:子元素筛选器
*******************************/

//http://www.jsfoot.com/jquery/demo/2012-12-10/847.html


//<!--演示内容开始-->
//<style type="text/css">
//*{margin:0;padding:0;list-style-type:none;}
//a,img{border:0;}
//body{font:12px/180% Arial, Helvetica, sans-serif,"宋体";}
//a{color:#333;text-decoration:none;}
//a:hover{color:#3366cc;text-decoration:underline;}
///* demo */
//.demo{width:686px;margin:40px auto;position:relative;}
//.demo h2{font-size:16px;height:44px;color:#3366cc;margin-top:20px;}
//.demo dl dt{font-size:14px;color:#ff6600;margin-top:40px;}
//.demo dl dt,.demo dl dd{line-height:22px;}
///* scrollbox */
//.scrollbox{position:relative;width:670px;height:146px;overflow:hidden;}
//.scrollbox ul{position:absolute;left:0px;top:0px;}
//.scrollbox li{float:left;width:670px;height:63px;overflow:hidden;padding:5px 0px;}
//.scrollbox li a{float:left;display:inline-block;width:156px;height:63px;overflow:hidden;margin-left:10px;}
//.scrollbox li a img{display:block;width:156px;height:63px;background:#eee;}
///* leftlist */
//#leftlist{width:999em;}
///* fontlist */
//#fontlist li{height:22px;line-height:22px;}
//#fontlist li a{width:auto;}
//</style>

//<script type="text/javascript" src="js/jquery.rollGallery_yeso.js"></script>
//<script type="text/javascript"> 
//$(document).ready(function($){
//	
//	$("#toplist").rollGallery({
//		direction:"top",
//		speed:2000,
//		showNum:2
//	});
//	
//	$("#leftlist").rollGallery({
//		direction:"left",
//		speed:2000,
//		showNum:1
//	});
//	
//	$("#fontlist").rollGallery({
//		direction:"top",
//		speed:2000,
//		showNum:2
//	});
//	
//});
//</script>



(function ($) {

    $.fn.rollGallery = function (options) {

        var opts = $.extend({}, $.fn.rollGallery.defaults, options);

        return this.each(function () {
            var _this = $(this);
            var step = 0;
            var maxMove = 0;
            var animateArgu = new Object();
            _this.intervalRGallery = null;

            if (opts.noStep && (!options.speed)) opts.speed = 30;

            if (opts.direction == "left") {
                step = _this.children(opts.childrenSel).outerWidth(true);
            } else {
                step = _this.children(opts.childrenSel).outerHeight(true);
            }

            maxMove = -(step * _this.children(opts.childrenSel).length);
            _this[0].maxMove = maxMove;
            if (opts.rollNum) step *= opts.rollNum;
            animateArgu[opts.direction] = "-=" + step;

            _this.children(opts.childrenSel).slice(0, opts.showNum).clone(true).appendTo(_this);
            _this.mouseover(function () { clearInterval(_this.intervalRGallery); });
            _this.mouseout(function () {
                _this.intervalRGallery = setInterval(function () {
                    if (parseInt(_this.css(opts.direction)) <= maxMove) {
                        _this.css(opts.direction, "0px");
                    }
                    if (opts.noStep) {
                        _this.css(opts.direction, (parseInt(_this.css(opts.direction)) - opts.speedPx + "px"));
                    }
                    else {
                        _this.animate(animateArgu, opts.aniSpeed, opts.aniMethod);
                    }
                }, opts.speed);
            });

            _this.mouseout();
        });

    };

    $.fn.rollGallery.defaults = {
        direction: "left",
        speed: 3000,
        noStep: false,
        speedPx: 1,
        showNum: 1,
        aniSpeed: "slow",
        aniMethod: "swing",
        childrenSel: "*"
    };

})(jQuery);


//        <dd>* direction：移动方向。可取值为："left" "top"</dd>
//		<dd>* speed：速度。单位毫秒</dd>
//		<dd>* noStep：设置为：true  则按非步进方式滚动。非步进下动画效果失效。</dd>
//		<dd>* speedPx：非步进滚动下的移动速度。单位像素</dd>
//		<dd>* showNum：显示个数。即父元素能容纳的子元素个数</dd>
//		<dd>* rollNum：一次滚动的个数。注意总个数必须为rollNum的倍数！</dd>
//		<dd>* aniSpeed：动画速度</dd>
//		<dd>* aniMethod：动画方法（需插件（如：easing）支持）</dd>
//		<dd>* childrenSel：子元素筛选器</dd>
