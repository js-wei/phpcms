(function(){
$.fn.ad=function(options){
	$defaults = {
			xPos = 300; 
			yPos = 200; 
			step = 1; 
			delay = 30; 
			height = 0; 
			Hoffset = 0; 
			Woffset = 0; 
			yon = 0; 
			xon = 0; 
			pause = true; 
		};

	$this=$(this);
	$opts = $.extend($defaults,options);


	function changePos(){ 
	  width = document.body.clientWidth; 
	  height = document.body.clientHeight; 
	  Hoffset = $this[0].offsetHeight; 
	  Woffset = $this[0].offsetWidth; 
	 
	  $this.css('left', xPos + document.body.scrollLeft);
	  $this.css('top', yPos + document.body.scrollTop);
	  if(yon){
	    yPos = yPos + step;
	  }else{
	    yPos = yPos - step;
	  } 
	  if(yPos < 0){
	    yon = 1;
		yPos = 0;
	  } 
	  if(yPos >= (height - Hoffset)){
	    yon = 0;
	    yPos = (height - Hoffset);
	  } 
	  if(xon){
	    xPos = xPos + step;
	  } else{
	    xPos = xPos - step;
	  } 
	  if (xPos < 0){
	    xon = 1;xPos = 0;
	  } 
	  if (xPos >= (width - Woffset)){
	    xon = 0;
	    xPos = (width - Woffset); 
	  } 
	} 

	function start() { 
	    $this[0].visibility = "visible";   
	    interval = setInterval('changePos()', delay); 
	} 

	function pause_resume(pause) { 
	  if(pause==1)  { 
	    clearInterval(interval); 
	    pause = false;
	  }else{ 
	    interval = setInterval('changePos()',delay); 
	    pause = true; 
	  } 
	} 

})(jQuery);