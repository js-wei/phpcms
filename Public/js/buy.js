$(document).ready(function() { 
	$('.porp_buy').click(function(event){
		if(isLogin==''){
			$('.open_login_window,.top_login_stauts>.red').click();
			return false;
		}
		var porp_title=$(this).attr('data-title');
		var porp_pid=$(this).attr('data-pid');
		var porp_price1=$(this).attr('data-price');
		var porp_price_type=$(this).attr('data-price-type');
		var url="#";
		var content='<form class="buyform" action="" method="post" ><div><label>数量：</label> <input type="text" id="shop_num" name="shop_num" value=1 maxlength="4" /></div><div><label>价格：</label><span id="buy_price">'+porp_price1+'</span>'+porp_price_type+'<input type="hidden" id="porp_price" name="porp_price" value="'+porp_price1+'" /></div><a id="buy_submit" href="javascript:void(0);" class="a-button-min" >确定</a><div class="error center"></div></form>';
		$('#message-pop-title span').html('购买道具 '+porp_title);
		$('#TB_status').css('margin','0px');
		$('#TB_status').html('');
		$('#TB_status').html(content);
		$('.buyform input').css('width','60px');
		$('#message-pop').find('a').attr('data-url',url);
		$('#true_pop_close').hide();
		$('#TB_overlay').show();$('#message-pop').show();
		porp_price(porp_pid,1);
		$("#shop_num").on('blur',function(){buy_price();});
		$("#shop_num").on('keyup',function(){buy_price();});
		$('#buy_submit').on('click',function(){buy_submit(porp_pid);});
	});
	$('.a-button-shop').click(function(event) {
		/* Act on the event */
		if(isLogin==''){
          event.preventDefault();
          $('#TB_overlay,#login-pop').show();
        }
	});
})


function porp_price(id,buy_no,price){
	//alert(_url);
	$.post(_url+"/buy_price",{"id":id,"buy_no":buy_no,'price':$('.porp_buy').attr('data-price')},function(data){
		if (data.status == 1) {
			$("#porp_price").val(data.info);
			$(".error").html('');
		} else {
			$(".error").html(data.info+"<a href='"+data.url+"' class='blue' target='_blank' >马上充值</a>");
			//$("#shop_num").val(1);
			$("#shop_num").focus();
			return false;
		}
	}, 'json');
}

function buy_price(){ 
	$("#shop_num").val($("#shop_num").val().replace(/[^\d]/g,''));
	var buy_no=$("#shop_num").val();
	if(buy_no==''){$("#shop_num").val(1);return false;}
	if(buy_no<1){$("#shop_num").val(1);return false;}
	var porp_price=$("#porp_price").val();
	var count_price=porp_price*buy_no;
	
	$('#buy_price').html(count_price);
}

function buy_submit(id){
	buy_price();
	var buy_no=$("#shop_num").val();
	$.post(_url+"/buy_submit",{"id":id,"order_num":buy_no,"buytype":2},function(data){
		if (data.status == 1) {
			status='<i class="check_status"></i>';
			$('#TB_status').html(status+'购买成功！查看<a href="'+data.url+'" class="blue" >我的道具</a>');
		} else {
			if(data.status == 2){
				$(".error").html(data.info+"<a href='http://image.17gd.com/orders/orderpay/paytype/bank/id/6' class='blue' target='_blank' >马上充值</a>");
				return false;
			}
			$(".error").html(data.info);
			return false;
		}
	}, 'json');
}


