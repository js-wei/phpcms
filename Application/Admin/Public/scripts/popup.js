if(!Array.prototype.push){Array.prototype.push=function (){var startLength=this.length;for(var i=0;i<arguments.length;i++)this[startLength+i]=arguments[i];return this.length;}};
function G(){var elements=new Array();for(var i=0;i<arguments.length;i++){var element=arguments[i];if(typeof element=='string')element=document.getElementById(element);if(arguments.length==1)return element;elements.push(element);};return elements;};
Function.prototype.bindAsEventListener=function (object){var __method=this;return function (event){__method.call(object,event||window.event);};};
Object.extend_p=function (destination,source){for(property in source){destination[property]=source[property];};return destination;};
if(!window.Event){var Event=new Object();};Object.extend_p(Event,{observers:false,element:function (event){return event.target||event.srcElement;},isLeftClick:function (event){return (((event.which)&&(event.which==1))||((event.button)&&(event.button==1)));},pointerX:function (event){return event.pageX||(event.clientX+(document.documentElement.scrollLeft||document.body.scrollLeft));},pointerY:function (event){return event.pageY||(event.clientY+(document.documentElement.scrollTop||document.body.scrollTop));},stop:function (event){if(event.preventDefault){event.preventDefault();event.stopPropagation();}else {event.returnValue=false;event.cancelBubble=true;};},findElement:function (event,tagName){var element=Event.element(event);while(element.parentNode&&(!element.tagName||(element.tagName.toUpperCase()!=tagName.toUpperCase())))element=element.parentNode;return element;},_observeAndCache:function (element,name,observer,useCapture){if(!this.observers)this.observers=[];if(element.addEventListener){this.observers.push([element,name,observer,useCapture]);element.addEventListener(name,observer,useCapture);}else if(element.attachEvent){this.observers.push([element,name,observer,useCapture]);element.attachEvent('on'+name,observer);};},unloadCache:function (){if(!Event.observers)return ;for(var i=0;i<Event.observers.length;i++){Event.stopObserving.apply(this,Event.observers[i]);Event.observers[i][0]=null;};Event.observers=false;},observe:function (element,name,observer,useCapture){var element=G(element);useCapture=useCapture||false;if(name=='keypress'&&(navigator.appVersion.match(/Konqueror|Safari|KHTML/)||element.attachEvent))name='keydown';this._observeAndCache(element,name,observer,useCapture);},stopObserving:function (element,name,observer,useCapture){var element=G(element);useCapture=useCapture||false;if(name=='keypress'&&(navigator.appVersion.match(/Konqueror|Safari|KHTML/)||element.detachEvent))name='keydown';if(element.removeEventListener){element.removeEventListener(name,observer,useCapture);}else if(element.detachEvent){element.detachEvent('on'+name,observer);};}});Event.observe(window,'unload',Event.unloadCache,false);
var Class_Pop=function (){var _class=function (){this.initialize.apply(this,arguments);};for(i=0;i<arguments.length;i++){superClass=arguments[i];for(member in superClass.prototype){_class.prototype[member]=superClass.prototype[member];};};_class.child=function (){return new Class(this);};_class.extend_p=function (f){for(property in f){_class.prototype[property]=f[property];};};return _class;};
function space(flag){if(flag=="begin"){var ele=document.getElementById("ft");if(typeof(ele)!="undefined"&&ele!=null)ele.id="ft_popup";ele=document.getElementById("usrbar");if(typeof(ele)!="undefined"&&ele!=null)ele.id="usrbar_popup";}else if(flag=="end"){var ele=document.getElementById("ft_popup");if(typeof(ele)!="undefined"&&ele!=null)ele.id="ft";ele=document.getElementById("usrbar_popup");if(typeof(ele)!="undefined"&&ele!=null)ele.id="usrbar";};};
var Popup=new Class_Pop();
Popup.prototype={
	iframeIdName:'ifr_popup',initialize:function (config){
		this.config=Object.extend_p({contentType:1,isHaveTitle:true,scrollType:'no',isBackgroundCanClick:false,isSupportDraging:true,isShowShadow:true,isReloadOnClose:true,width:400,height:300},config||{});
		this.info={shadowWidth:4,title:"",contentUrl:"",contentHtml:"",callBack:null,parameter:null,confirmCon:"",alertCon:"",someHiddenTag:"select,object,embed",someHiddenEle:"",overlay:0,coverOpacity:60};
		this.color={cColor:"#EEEEEE",bColor:"#FFFFFF",tColor:"#709CD2",wColor:"#FFFFFF"};
		this.dropClass=null;
		this.someToHidden=[];
		if(!this.config.isHaveTitle)this.config.isSupportDraging=false;
		this.iniBuild();
	},
	setContent:function (arrt,val){
		if(val!=''){
			switch(arrt){
				case 'width':this.config.width=val; break;
				case 'height':this.config.height=val;break;
				case 'title':this.info.title=val;break;
				case 'contentUrl':this.info.contentUrl=val;break;
				case 'contentHtml':this.info.contentHtml=val;break;
				case 'callBack':this.info.callBack=val;break;
				case 'parameter':this.info.parameter=val;break;
				case 'confirmCon':this.info.confirmCon=val;break;
				case 'alertCon':this.info.alertCon=val;break;
				case 'someHiddenTag':this.info.someHiddenTag=val;break;
				case 'someHiddenEle':this.info.someHiddenEle=val;break;
				case 'overlay':this.info.overlay=val;
			};
		};
	},
	setContents:function(options){
	   if(null == options || {} == options) return;
	   for(var key in options) this.setContent(key, options[key]);
	},
	iniBuild:function (){
		var oDiv=document.createElement('div');
		oDiv.id='dialogCase';
		document.body.appendChild(oDiv);
	},
	build:function (){
		p=this.posi();
		var baseZIndex=10001+this.info.overlay*10;
		var showZIndex=baseZIndex+2;
		var showZIndex2=baseZIndex+1;
		if(this.info.title ==undefined || this.info.title==null){this.info.title="";}
		var html='<div id="dialogBox" style="z-index:'+showZIndex+';position:absolute;top:'+p[0]+'px;left:'+p[1]+'px;width:'+this.config.width+'px;height:'+this.config.height+'px;">\
				<div style="position:relative;z-index:'+showZIndex2+';top:0;left:0;width:'+this.config.width+'px;background:#fff;border:1px solid #B7B7B7;filter : progid:DXImageTransform.Microsoft.DropShadow(color=#DCDCDC,offX=4,offY=4,positives=true);">\
					<div style="position:relative;height:20px;padding:10px 10px 10px 10px;overflow:hidden;font-size:14px;font-weight:bold;cursor:nomal;">'+this.info.title+'<div style="cursor:pointer;position:absolute;right:10px;top:10px;width:18px;height:18px;border:1px solid #FEB423;font:bold 10px/18px 黑体;text-align:center;color:#FEB423;overflow:hiddden;" id="dialogBoxClose">X</div></div>\
						<iframe scrolling="no" style="width:100%;height:'+(this.config.height-22)+'px;overflow:hidden;" frameborder="0" src="'+this.info.contentUrl+'"></iframe>\
					</div>\
			</div>';
		         
		html+='<div id="dialogBoxShadow" style="position:absolute;z-index:'+baseZIndex+';top:'+(p[0]+4)+'px;left:'+(p[1]+4)+'px;width:'+(this.config.width+2)+'px;height:'+(this.config.height+2)+'px;background:#c3c3c3;">fefewewf</div>';
		var cB='filter: alpha(opacity='+this.info.coverOpacity+');opacity:'+this.info.coverOpacity/100+';';
		var cover='<div id="dialogBoxBG" style="position:absolute;top:0px;left:0px;width:100%;height:100%;z-index:'+baseZIndex+';'+cB+'background-color:'+this.color.cColor+';display:;"></div>';
		G('dialogCase').innerHTML=cover + html;
		
		G('dialogBoxBG').style.height=document.body.scrollHeight;
		Event.observe(G('dialogBoxClose'),"click",this.reset.bindAsEventListener(this),false);
		//Event.observe(document,"keypress",this.keydown.bindAsEventListener(this),false);
		return this;
	},
	keydown:function(event){
		if(event.keyCode==27){this.close();}
	},
	lastBuild:function (){
	},
	reBuild:function (){
		G('dialogBody').height=G('dialogBody').clientHeight;
	},
	show:function (){this.hiddenSome();
		this.middle();
	},
	forCallback:function (){return this.info.callBack(this.info.parameter);},
	shadow:function (){
	},
	middle:function (){
		var oDialog=G('dialogBox');
		oDialog['style']['display']='';
		if(!this.config.isBackgroundCanClick)G('dialogBoxBG').style.display='';
	},
	posi:function (){
		var myWidth = 0, myHeight = 0;
		var sTop=0,sleft=0;
		if( typeof( window.innerWidth ) == 'number' ) {
			myWidth = window.innerWidth;
			myHeight = window.innerHeight;
		}else if(document.documentElement&&(document.documentElement.clientWidth||document.documentElement.clientHeight)){
			myWidth = document.documentElement.clientWidth;
			myHeight = document.documentElement.clientHeight;
		} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
			myWidth = document.body.clientWidth;
			myHeight = document.body.clientHeight;
		}
		sTop = (myHeight-this.config.height)/2 + document.documentElement.scrollTop;
		sleft = (myWidth -this.config.width)/2;
		if(sTop<1)sTop="20";
		if(sleft<1)sleft="20";
		return [sTop,sleft];
	},
	reset:function (){
		if(this.config.isReloadOnClose){top.location.reload();};
		this.close();
	},
	close:function (){
		G('dialogBox').style.display='none';
		G('dialogBoxShadow').style.display='none';
		if(!this.config.isBackgroundCanClick)G('dialogBoxBG').style.display='none';
		//Event.unloadCache();
		this.showSome();
	},
	hiddenSome:function (){var tag=this.info.someHiddenTag.split(",");if(tag.length==1&&tag[0]=="")tag.length=0;for(var i=0;i<tag.length;i++){this.hiddenTag(tag[i]);};var ids=this.info.someHiddenEle.split(",");if(ids.length==1&&ids[0]=="")ids.length=0;for(var i=0;i<ids.length;i++){this.hiddenEle(ids[i]);};space("begin");},hiddenTag:function (tagName){var ele=document.getElementsByTagName(tagName);if(ele!=null){for(var i=0;i<ele.length;i++){if(ele[i].style.display!="none"&&ele[i].style.visibility!='hidden'){ele[i].style.visibility='hidden';this.someToHidden.push(ele[i]);};};};},hiddenEle:function (id){var ele=document.getElementById(id);if(typeof(ele)!="undefined"&&ele!=null){ele.style.visibility='hidden';this.someToHidden.push(ele);}},showSome:function (){for(var i=0;i<this.someToHidden.length;i++){this.someToHidden[i].style.visibility='visible';};space("end");}};
