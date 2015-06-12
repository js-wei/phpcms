/// <reference path="jquery-vsdoc.js" />
$(document).ready(TB_launch);

function closethickbox() {
    window.top.document.getElementById('_DialogBGDiv').click();
}

function closeRefresh() {
    window.top.document.getElementById('_DialogBGDiv').click();
    window.parent.frames["main_right"].location.reload(); //这句可以刷新一下弹窗窗口的页面：falcon
}

function TB_launch() {
    $("a.thickbox").live("click", function () {
        var t = this.title;
        var TB_WIDTH = (Number($(this).attr("bwidth")) || 800);
        var TB_HEIGHT = (Number($(this).attr("bheight")) || 550);
        isRefresh = Number($(this).attr("isrefresh") || 0); //关闭后是否刷新页面，默认不刷新：falcon
        autoClose = Number($(this).attr("autoclose") || 0);
        OpenBlogDialog(this.href, t, TB_WIDTH, TB_HEIGHT);
        //        TB_show(t, this.href, this);
        this.blur();
        return false;
    });

    $("#_DialogBGDiv").live("click", function () { //点击遮罩自动关闭 
        if (autoClose == 1) {
            var pw = _q$E.getTopLevelWindow();
            if (pw.Dialog._Array.length > 0) {
                var diag = pw.Dialog.getInstance(pw.Dialog._Array[pw.Dialog._Array.length - 1]);
                diag.CancelButton.onclick.apply(diag.CancelButton, []);
            }
        }
    });
}

TB_show = function (t, url, obj) {
    var TB_WIDTH = (Number($(obj).attr("bwidth")) || 200);
    var TB_HEIGHT = (Number($(obj).attr("bheight")) || 200);
    OpenBlogDialog(url, t, TB_WIDTH, TB_HEIGHT);
    //        TB_show(t, this.href, this);
    obj.blur();
    return false;
}

OpenBlogDialog = function (url, title, width, height) {
    var diag = new Dialog("ifrmBlog");
    diag.Width = width;
    diag.Height = height;
    diag.Title = title;
    diag.innerHTML = '<iframe id="iframBlog" name="iframBlog" frameborder="0" marginwidth="0" marginheight="0"width="' + width + 'px" height="' + height + 'px;" src="' + url + '"></iframe>';
    diag.show();
}

var IMGFOLDERPATH = '/Plug/thickbox/images/'; //图片路径配置
var CONTEXTPATH = ''; //弹出框内页面路径配置
var isIE = navigator.userAgent.toLowerCase().indexOf("msie") != -1;
var isIE6 = navigator.userAgent.toLowerCase().indexOf("msie 6.0") != -1;
var isGecko = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;
var isQuirks = document.compatMode == "BackCompat";

var isRefresh = 0; //关闭后是否刷新页面，默认不刷新：falcon
var autoClose = 1;

function _q$(ele) {
    if (typeof (ele) == 'string') {
        ele = document.getElementById(ele)
        if (!ele) {
            return null;
        }
    }
    if (ele) {
        Core.attachMethod(ele);
    }
    return ele;
}
function _q$T(tagName, ele) {
    ele = _q$(ele);
    ele = ele || document;
    var ts = ele.getElementsByTagName(tagName); //此处返回的不是数组
    var arr = [];
    var len = ts.length;
    for (var i = 0; i < len; i++) {
        arr.push(_q$(ts[i]));
    }
    return arr;
}
function stopEvent(event) {//阻止一切事件执行,包括浏览器默认的事件
    event = window.event || event;
    if (!event) {
        return;
    }
    if (isGecko) {
        event.preventDefault();
        event.stopPropagation();
    }
    event.cancelBubble = true
    event.returnValue = false;
}

Array.prototype.remove = function (s) {
    for (var i = 0; i < this.length; i++) {
        if (s == this[i]) {
            this.splice(i, 1);
        }
    }
}

if (window.HTMLElement) {//给FF添加IE专有的属性和方法
    try {
        HTMLElement.prototype.__defineGetter__("parentElement", function () {
            if (this.parentNode == this.ownerDocument) return null;
            return this.parentNode;
        });
        HTMLElement.prototype.__defineSetter__("outerHTML", function (sHTML) {
            var r = this.ownerDocument.createRange();
            r.setStartBefore(this);
            var df = r.createContextualFragment(sHTML);
            this.parentNode.replaceChild(df, this);
            return sHTML;
        });
        HTMLElement.prototype.__defineGetter__("outerHTML", function () {
            var attr;
            var attrs = this.attributes;
            var str = "<" + this.tagName;
            for (var i = 0; i < attrs.length; i++) {
                attr = attrs[i];
                if (attr.specified)
                    str += " " + attr.name + '="' + attr.value + '"';
            }
            if (!this.canHaveChildren)
                return str + ">";
            return str + ">" + this.innerHTML + "</" + this.tagName + ">";
        });
        HTMLElement.prototype.__defineSetter__("innerText", function (sText) {
            var parsedText = document.createTextNode(sText);
            this.innerHTML = parsedText;
            return parsedText;
        });
        HTMLElement.prototype.__defineGetter__("innerText", function () {
            var r = this.ownerDocument.createRange();
            r.selectNodeContents(this);
            return r.toString();
        });
    } catch (e) { }
}

var _q$E = {};
_q$E._q$A = function (attr, ele) {
    ele = ele || this;
    ele = _q$(ele);
    return ele.getAttribute ? ele.getAttribute(attr) : null;
}
_q$E.getTopLevelWindow = function () {
    var pw = window;
    while (pw != pw.parent) {
        pw = pw.parent;
    }
    return pw;
}
_q$E.hide = function (ele) {
    ele = ele || this;
    ele = _q$(ele);
    ele.style.display = 'none';
}
_q$E.show = function (ele) {
    ele = ele || this;
    ele = _q$(ele);
    ele.style.display = '';
}
_q$E.visible = function (ele) {
    ele = ele || this;
    ele = _q$(ele);
    if (ele.style.display == "none") {
        return false;
    }
    return true;
}

var Core = {};
Core.attachMethod = function (ele) {
    if (!ele || ele["_q$A"]) {
        return;
    }
    if (ele.nodeType == 9) {
        return;
    }
    var win;
    try {
        if (isGecko) {
            win = ele.ownerDocument.defaultView;
        } else {
            win = ele.ownerDocument.parentWindow;
        }
        for (var prop in _q$E) {
            ele[prop] = win._q$E[prop];
        }
    } catch (ex) {
        //alert("Core.attachMethod:"+ele)//有些对象不能附加属性，如flash
    }
}

function Dialog(strID) {
    if (!strID) {
        alert("错误的Dialog ID！");
        return;
    }
    this.ID = strID;
    this.isModal = true;
    this.Width = 400;
    this.Height = 300;
    this.Top = 0;
    this.Left = 0;
    this.ParentWindow = null;
    this.onLoad = null;
    this.Window = null;

    this.Title = "";
    this.URL = null;
    this.innerHTML = null
    this.innerElementId = null
    this.DialogArguments = {};
    this.WindowFlag = false;
    this.Message = null;
    this.MessageTitle = null;
    this.ShowMessageRow = false;
    this.ShowButtonRow = true;
    this.Icon = null;
    this.bgdivID = null;
}

Dialog._Array = [];

Dialog.prototype.showWindow = function () {
    if (isIE) {
        this.ParentWindow.showModalessDialog(this.URL, this.DialogArguments, "dialogWidth:" + this.Width + ";dialogHeight:" + this.Height + ";help:no;scroll:no;status:no");
    }
    if (isGecko) {
        var sOption = "location=no,menubar=no,status=no;toolbar=no,dependent=yes,dialog=yes,minimizable=no,modal=yes,alwaysRaised=yes,resizable=no";
        this.Window = this.ParentWindow.open('', this.URL, sOption, true);
        var w = this.Window;
        if (!w) {
            alert("发现弹出窗口被阻止，请更改浏览器设置，以便正常使用本功能!");
            return;
        }
        w.moveTo(this.Left, this.Top);
        w.resizeTo(this.Width, this.Height + 30);
        w.focus();
        w.location.href = this.URL;
        w.Parent = this.ParentWindow;
        w.dialogArguments = this.DialogArguments;
    }
}

Dialog.prototype.show = function () {
    var pw = _q$E.getTopLevelWindow();
    var doc = pw.document;
    var cw = doc.compatMode == "BackCompat" ? doc.body.clientWidth : doc.documentElement.clientWidth;
    var ch = doc.compatMode == "BackCompat" ? doc.body.clientHeight : doc.documentElement.clientHeight; //必须考虑文本框处于页面边缘处，控件显示不全的问题
    var sl = Math.max(doc.documentElement.scrollLeft, doc.body.scrollLeft);
    var st = Math.max(doc.documentElement.scrollTop, doc.body.scrollTop); //考虑滚动的情况
    var sw = Math.max(doc.documentElement.scrollWidth, doc.body.scrollWidth);
    var sh = Math.max(doc.documentElement.scrollHeight, doc.body.scrollHeight); //考虑滚动的情况
    sw = Math.max(sw, cw);
    sh = Math.max(sh, ch);
    //	alert("\n"+cw+"\n"+ch+"\n"+sw+"\n"+sh)

    if (!this.ParentWindow) {
        this.ParentWindow = window;
    }
    this.DialogArguments._DialogInstance = this;
    this.DialogArguments.ID = this.ID;

    if (!this.Height) {
        this.Height = this.Width / 2;
    }

    if (this.Top == 0) {
        this.Top = (ch - this.Height - 30) / 2 + st - 8;
    }
    if (this.Left == 0) {
        this.Left = (cw - this.Width - 12) / 2 + sl;
    }
    if (this.ShowButtonRow) {//按钮行高36
        this.Top -= 18;
    }
    if (this.WindowFlag) {
        this.showWindow();
        return;
    }
    var arr = [];
    arr.push("<table id='falcon' style='-moz-user-select:none;' oncontextmenu='stopEvent(event);' onselectstart='stopEvent(event);' border='0' cellpadding='0' cellspacing='0' width='" + (this.Width + 26) + "'>");
    arr.push("  <tr style='cursor:move;' id='_draghandle_" + this.ID + "'>");
    arr.push("    <td width='13' height='33' style=\"background-image:url(" + IMGFOLDERPATH + "dialog_lt.png) !important;background-image: none;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + IMGFOLDERPATH + "dialog_lt.png', sizingMethod='crop');\"><div style='width:13px;'></div></td>");
    arr.push("    <td height='33' style=\"background-image:url(" + IMGFOLDERPATH + "dialog_ct.png) !important;background-image: none;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + IMGFOLDERPATH + "dialog_ct.png', sizingMethod='crop');\"><div style=\"float:left;font-weight:bold; color:#FFFFFF; padding:9px 0 0 4px;\"><img src=\"" + IMGFOLDERPATH + "icon_dialog.gif\" align=\"absmiddle\">&nbsp;" + this.Title + "</div>");
    arr.push("      <div style=\"position: relative;cursor:pointer; float:right; margin:5px 0 0; _margin:4px 0 0;height:17px; width:28px; background-image:url(" + IMGFOLDERPATH + "dialog_closebtn.gif)\" onMouseOver=\"this.style.backgroundImage='url(" + IMGFOLDERPATH + "dialog_closebtn_over.gif)'\" onMouseOut=\"this.style.backgroundImage='url(" + IMGFOLDERPATH + "dialog_closebtn.gif)'\" drag='false' onClick=\"Dialog.getInstance('" + this.ID + "').CancelButton.onclick.apply(Dialog.getInstance('" + this.ID + "').CancelButton,[]);\"></div></td>");
    arr.push("    <td width='13' height='33' style=\"background-image:url(" + IMGFOLDERPATH + "dialog_rt.png) !important;background-image: none;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + IMGFOLDERPATH + "dialog_rt.png', sizingMethod='crop');\"><div style=\"width:13px;\"></div></td>");
    arr.push("  </tr>");
    arr.push("  <tr drag='false'><td width='13' style=\"background-image:url(" + IMGFOLDERPATH + "dialog_mlm.png) !important;background-image: none;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + IMGFOLDERPATH + "dialog_mlm.png', sizingMethod='crop');\"></td>");
    arr.push("    <td align='center' valign='top'><a href='#;' id='_forTab_" + this.ID + "'></a>");
    arr.push("    <table width='100%' border='0' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>");
    arr.push("        <tr id='_MessageRow_" + this.ID + "' style='display:none'>");
    arr.push("          <td height='50' valign='top'><table id='_MessageTable_" + this.ID + "' width='100%' border='0' cellspacing='0' cellpadding='8' style=\" background:#EAECE9 url(" + IMGFOLDERPATH + "dialog_bg.jpg) no-repeat right top;\">");
    arr.push("              <tr><td width='25' height='50' align='right'><img id='_MessageIcon_" + this.ID + "' src='" + IMGFOLDERPATH + "window.gif' width='32' height='32'></td>");
    arr.push("                <td align='left' style='line-height:16px;'>");
    arr.push("                <h5 class='fb' id='_MessageTitle_" + this.ID + "'>&nbsp;</h5>");
    arr.push("                <div id='_Message_" + this.ID + "'>&nbsp;</div></td>");
    arr.push("              </tr></table></td></tr>");
    arr.push("        <tr><td align='center' valign='top'><div style='position:relative;width:" + this.Width + "px;height:" + this.Height + "px;'>");
    arr.push("         <div  id='_Covering_" + this.ID + "' style='position:absolute; height:100%; width:100%;display:none;'>&nbsp;</div>");
    if (this.innerHTML) {
        arr.push(this.innerHTML);
    } else if (this.innerElementId) {
    } else if (this.URL) {
        arr.push("          <iframe src='");
        if (this.URL.substr(0, 7) == "http://" || this.URL.substr(0, 1) == "/") {
            arr.push(this.URL);
        } else {
            arr.push(CONTEXTPATH + this.URL);
        }
        arr.push("' id='_DialogFrame_" + this.ID + "' allowTransparency='true'  width='100%' height='100%' frameborder='0' style=\"background-color: #transparent; border:none;\"></iframe>");
    }
    arr.push("        </div></td></tr >");
    arr.push("        <tr style='display:none;'  drag='false' id='_ButtonRow_" + this.ID + "'><td height='36'>");
    arr.push("            <div id='_DialogButtons_" + this.ID + "' style='text-align:right; border-top:#dadee5 1px solid; padding:8px 20px; background-color:#f6f6f6;'>");
    arr.push("           	<input id='_ButtonOK_" + this.ID + "'  type='button' value='确 定'>");
    arr.push("           	<input id='_ButtonCancel_" + this.ID + "'  type='button' onclick=\"Dialog.getInstance('" + this.ID + "').close();\" value='取 消'>");
    arr.push("            </div></td></tr>");
    arr.push("      </table><a href='#;' onfocus='_q$(\"_forTab_" + this.ID + "\").focus();'></a></td>");
    arr.push("    <td width='13' style=\"background-image:url(" + IMGFOLDERPATH + "dialog_mrm.png) !important;background-image: none;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + IMGFOLDERPATH + "dialog_mrm.png', sizingMethod='crop');\"></td></tr>");
    arr.push("  <tr><td width='13' height='13' style=\"background-image:url(" + IMGFOLDERPATH + "dialog_lb.png) !important;background-image: none;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + IMGFOLDERPATH + "dialog_lb.png', sizingMethod='crop');\"></td>");
    arr.push("    <td style=\"background-image:url(" + IMGFOLDERPATH + "dialog_cb.png) !important;background-image: none;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + IMGFOLDERPATH + "dialog_cb.png', sizingMethod='crop');\"></td>");
    arr.push("    <td width='13' height='13' style=\"background-image:url(" + IMGFOLDERPATH + "dialog_rb.png) !important;background-image: none;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + IMGFOLDERPATH + "dialog_rb.png', sizingMethod='crop');\"></td>");
    arr.push("  </tr></table>");
    this.TopWindow = pw;

    var bgdiv = pw._q$("_DialogBGDiv");
    if (!bgdiv) {
        bgdiv = pw.document.createElement("div");
        bgdiv.id = "_DialogBGDiv";
        _q$E.hide(bgdiv);
        pw._q$T("body")[0].appendChild(bgdiv);
        if (isIE6) {
            var bgIframeBox = pw.document.createElement('<div style="position:relative;width:100%;height:100%;"></div>');
            var bgIframe = pw.document.createElement('<iframe src="about:blank" style="filter:alpha(opacity=1);" width="100%" height="100%"></iframe>');
            var bgIframeMask = pw.document.createElement('<div src="about:blank" style="position:absolute;background-color:#333;filter:alpha(opacity=1);width:100%;height:100%;"></div>');
            bgIframeBox.appendChild(bgIframeMask);
            bgIframeBox.appendChild(bgIframe);

            bgdiv.appendChild(bgIframeBox);

            var bgIframeDoc = bgIframe.contentWindow.document;
            bgIframeDoc.open();
            bgIframeDoc.write("<body style='background-color:#333' oncontextmenu='return false;'></body>");
            bgIframeDoc.close();
        }
    }

    var div = pw._q$("_DialogDiv_" + this.ID);
    if (!div) {
        div = pw.document.createElement("div");
        _q$E.hide(div);
        div.id = "_DialogDiv_" + this.ID;
        //div.className = "dialogdiv";
        //div.setAttribute("dragStart","Dialog.dragStart");
        pw._q$T("body")[0].appendChild(div);
    }
    /*div.onmousedown = function(evt){
    var w = _q$E.getTopLevelWindow();
    //w.DragManager.onMouseDown(evt||w.event,this);//拖拽处理
    }*/

    this.DialogDiv = div;
    div.innerHTML = arr.join('\n');
    if (this.innerElementId) {
        var innerElement = _q$(this.innerElementId);
        innerElement.style.position = "";
        innerElement.style.display = "";
        if (isIE) {
            var fragment = pw.document.createElement("div");
            fragment.innerHTML = innerElement.outerHTML;
            innerElement.outerHTML = "";
            pw._q$("_Covering_" + this.ID).parentNode.appendChild(fragment)
        } else {
            pw._q$("_Covering_" + this.ID).parentNode.appendChild(innerElement)
        }
    }
    pw._q$("_DialogDiv_" + this.ID).DialogInstance = this;
    if (this.URL)
        pw._q$("_DialogFrame_" + this.ID).DialogInstance = this;
    pw.Drag.init(pw._q$("_draghandle_" + this.ID), pw._q$("_DialogDiv_" + this.ID)); //注册拖拽方法
    if (!isIE) {
        pw._q$("_DialogDiv_" + this.ID).dialogId = this.ID;
        pw._q$("_DialogDiv_" + this.ID).onDragStart = function () { _q$("_Covering_" + this.dialogId).style.display = "" }
        pw._q$("_DialogDiv_" + this.ID).onDragEnd = function () { _q$("_Covering_" + this.dialogId).style.display = "none" }
    }

    this.OKButton = pw._q$("_ButtonOK_" + this.ID);
    this.CancelButton = pw._q$("_ButtonCancel_" + this.ID);

    //显示标题图片
    if (this.ShowMessageRow) {
        _q$E.show(pw._q$("_MessageRow_" + this.ID));
        if (this.MessageTitle) {
            pw._q$("_MessageTitle_" + this.ID).innerHTML = this.MessageTitle;
        }
        if (this.Message) {
            pw._q$("_Message_" + this.ID).innerHTML = this.Message;
        }
    }

    //显示按钮栏
    if (!this.ShowButtonRow) {
        pw._q$("_ButtonRow_" + this.ID).hide();
    }
    if (this.CancelEvent) {
        this.CancelButton.onclick = this.CancelEvent;
    }
    if (this.OKEvent) {
        this.OKButton.onclick = this.OKEvent;
    }
    if (!this.AlertFlag) {
        _q$E.show(bgdiv);
        this.bgdivID = "_DialogBGDiv";
    } else {
        bgdiv = pw._q$("_AlertBGDiv");
        if (!bgdiv) {
            bgdiv = pw.document.createElement("div");
            bgdiv.id = "_AlertBGDiv";
            _q$E.hide(bgdiv);
            pw._q$T("body")[0].appendChild(bgdiv);
            if (isIE6) {
                var bgIframeBox = pw.document.createElement('<div style="position:relative;width:100%;height:100%;"></div>');
                var bgIframe = pw.document.createElement('<iframe src="about:blank" style="filter:alpha(opacity=1);" width="100%" height="100%"></iframe>');
                var bgIframeMask = pw.document.createElement('<div src="about:blank" style="position:absolute;background-color:#333;filter:alpha(opacity=1);width:100%;height:100%;"></div>');
                bgIframeBox.appendChild(bgIframeMask);
                bgIframeBox.appendChild(bgIframe);
                bgdiv.appendChild(bgIframeBox);
                var bgIframeDoc = bgIframe.contentWindow.document;
                bgIframeDoc.open();
                bgIframeDoc.write("<body style='background-color:#333' oncontextmenu='return false;'></body>");
                bgIframeDoc.close();
            }
            bgdiv.style.cssText = "background-color:#333;position:absolute;left:0px;top:0px;opacity:0.4;filter:alpha(opacity=40);width:100%;height:" + sh + "px;z-index:991";
        }
        _q$E.show(bgdiv);
        this.bgdivID = "_AlertBGDiv";
    }
    this.DialogDiv.style.cssText = "position:absolute; display:block;z-index:" + (this.AlertFlag ? 992 : 990) + ";left:" + this.Left + "px;top:" + this.Top + "px";

    //判断当前窗口是否是对话框，如果是，则将其置在bgdiv之后
    if (!this.AlertFlag) {
        var win = window;
        var flag = false;
        while (win != win.parent) {//需要考虑父窗口是弹出窗口中的一个iframe的情况
            if (win._DialogInstance) {
                win._DialogInstance.DialogDiv.style.zIndex = 959;
                flag = true;
                break;
            }
            win = win.parent;
        }
        if (!flag) {
            bgdiv.style.cssText = "background-color:#333;position:absolute;left:0px;top:0px;opacity:0.4;filter:alpha(opacity=40);width:100%;height:" + sh + "px;z-index:960;";
        }
        //this.ParentWindow._q$D = this;
    }
    var pwbody = doc.getElementsByTagName(isQuirks ? "BODY" : "HTML")[0];
    pwbody.style.overflow = "hidden"; //禁止出现滚动条

    pw.Dialog._Array.push(this.ID); //放入队列中，以便于ESC时正确关闭
}

Dialog.prototype.addParam = function (paramName, paramValue) {
    this.DialogArguments[paramName] = paramValue;
}

Dialog.prototype.close = function () {
    if (isRefresh != 0) {
        if (window.parent.frames["main_right"]) {
            window.parent.frames["main_right"].location.reload(); //这句可以刷新一下弹窗窗口的页面：falcon
        } else {
            window.location.reload();
        }
    }
    if (this.innerElementId) {
        var innerElement = _q$E.getTopLevelWindow()._q$(this.innerElementId);
        innerElement.style.display = "none";
        if (isIE) {
            //ie下不能跨窗口拷贝元素
            var fragment = document.createElement("div");
            fragment.innerHTML = innerElement.outerHTML;
            innerElement.outerHTML = "";
            _q$T("body")[0].appendChild(fragment)
        } else {
            _q$T("body")[0].appendChild(innerElement)
        }

    }
    if (this.WindowFlag) {
        this.ParentWindow._q$D = null;
        this.ParentWindow._q$DW = null;
        this.Window.opener = null;
        this.Window.close();
        this.Window = null;
    } else {
        //如果上级窗口是对话框，则将其置于bgdiv前
        var pw = _q$E.getTopLevelWindow();
        var doc = pw.document;
        var win = window;
        var flag = false;
        while (win != win.parent) {
            if (win._DialogInstance) {
                flag = true;
                win._DialogInstance.DialogDiv.style.zIndex = 960;
                break;
            }
            win = win.parent;
        }
        if (this.AlertFlag) {
            _q$E.hide(pw._q$("_AlertBGDiv"));
        }
        if (!flag && !this.AlertFlag) {//此处是为处理弹出窗口被关闭后iframe立即被重定向时背景层不消失的问题
            pw.eval('window._OpacityFunc = function(){var w = _q$E.getTopLevelWindow();_q$E.hide(w._q$("_DialogBGDiv"));_q$E.hide(w._q$("falcon"));}'); //此处解决了点击背景窗口仍不消失的问题：falcon
            pw._OpacityFunc();
        } else {
            this.DialogDiv.outerHTML = "";
            var pwbody = doc.getElementsByTagName(isQuirks ? "BODY" : "HTML")[0];
            pwbody.style.overflow = "auto"; //还原滚动条
            pw.Dialog._Array.remove(this.ID);
        }
    }
}

Dialog.prototype.addButton = function (id, txt, func) {
    var html = "<input id='_Button_" + this.ID + "_" + id + "' type='button' value='" + txt + "'> ";
    var pw = _q$E.getTopLevelWindow();
    pw._q$("_DialogButtons_" + this.ID)._q$T("input")[0].getParent("a").insertAdjacentHTML("beforeBegin", html);
    pw._q$("_Button_" + this.ID + "_" + id).onclick = func;
}

Dialog.close = function (evt) {
    window.Args._DialogInstance.close();
}

Dialog.getInstance = function (id) {
    var pw = _q$E.getTopLevelWindow()
    var f = pw._q$("_DialogDiv_" + id);
    if (!f) {
        return null;
    }
    return f.DialogInstance;
}

Dialog.AlertNo = 0;
Dialog.alert = function (msg, func, w, h) {
    var pw = _q$E.getTopLevelWindow()
    var diag = new Dialog("_DialogAlert" + Dialog.AlertNo++);
    diag.ParentWindow = pw;
    diag.Width = w ? w : 300;
    diag.Height = h ? h : 120;
    diag.Title = "系统提示";
    diag.URL = "javascript:void(0);";
    diag.AlertFlag = true;
    diag.CancelEvent = function () {
        diag.close();
        if (func) {
            func();
        }
    };
    diag.show();
    pw._q$("_AlertBGDiv").style.display = "";
    _q$E.hide(pw._q$("_ButtonOK_" + diag.ID));
    var win = pw._q$("_DialogFrame_" + diag.ID).contentWindow;
    var doc = win.document;
    doc.open();
    doc.write("<body oncontextmenu='return false;'></body>");
    var arr = [];
    arr.push("<table height='100%' border='0' align='center' cellpadding='10' cellspacing='0'>");
    arr.push("<tr><td align='right'><img id='Icon' src='" + IMGFOLDERPATH + "icon_alert.gif' width='34' height='34' align='absmiddle'></td>");
    arr.push("<td align='left' id='Message' style='font-size:9pt'>" + msg + "</td></tr></table>");
    var div = doc.createElement("div");
    div.innerHTML = arr.join('');
    doc.body.appendChild(div);
    doc.close();
    var h = Math.max(doc.documentElement.scrollHeight, doc.body.scrollHeight);
    var w = Math.max(doc.documentElement.scrollWidth, doc.body.scrollWidth);
    if (w > 300) {
        win.frameElement.width = w;
    }
    if (h > 120) {
        win.frameElement.height = h;
    }

    diag.CancelButton.value = "确 定";
    diag.CancelButton.focus();
    pw._q$("_DialogButtons_" + diag.ID).style.textAlign = "center";
}

Dialog.confirm = function (msg, func1, func2, w, h) {
    var pw = _q$E.getTopLevelWindow()
    var diag = new Dialog("_DialogAlert" + Dialog.AlertNo++);
    diag.Width = w ? w : 300;
    diag.Height = h ? h : 120;
    diag.Title = "信息确认";
    diag.URL = "javascript:void(0);";
    diag.AlertFlag = true;
    diag.CancelEvent = function () {
        diag.close();
        if (func2) {
            func2();
        }
    };
    diag.OKEvent = function () {
        diag.close();
        if (func1) {
            func1();
        }
    };
    diag.show();
    pw._q$("_AlertBGDiv").style.dispaly = "";
    var win = pw._q$("_DialogFrame_" + diag.ID).contentWindow;
    var doc = win.document;
    doc.open();
    doc.write("<body oncontextmenu='return false;'></body>");
    var arr = [];
    arr.push("<table height='100%' border='0' align='center' cellpadding='10' cellspacing='0'>");
    arr.push("<tr><td align='right'><img id='Icon' src='" + IMGFOLDERPATH + "icon_query.gif' width='34' height='34' align='absmiddle'></td>");
    arr.push("<td align='left' id='Message' style='font-size:9pt'>" + msg + "</td></tr></table>");
    var div = doc.createElement("div");
    div.innerHTML = arr.join('');
    doc.body.appendChild(div);
    doc.close();
    diag.OKButton.focus();
    pw._q$("_DialogButtons_" + diag.ID).style.textAlign = "center";
}

var _DialogInstance = window.frameElement ? window.frameElement.DialogInstance : null;
var Page = {};
Page.onDialogLoad = function () {
    if (_DialogInstance) {
        if (_DialogInstance.Title) {
            document.title = _DialogInstance.Title;
        }
        window.Args = _DialogInstance.DialogArguments;
        _DialogInstance.Window = window;
        window.Parent = _DialogInstance.ParentWindow;
    }
}

Page.onDialogLoad();

PageOnLoad = function () {
    var d = _DialogInstance;
    if (d) {
        try {
            d.ParentWindow._q$D = d;
            d.ParentWindow._q$DW = d.Window;
            var flag = false;
            if (!this.AlertFlag) {
                var win = d.ParentWindow;
                while (win != win.parent) {
                    if (win._DialogInstance) {
                        flag = true;
                        break;
                    }
                    win = win.parent;
                }
                if (!flag) {
                    _q$E.getTopLevelWindow()._q$("_DialogBGDiv").style.opacity = "0.4";
                    _q$E.getTopLevelWindow()._q$("_DialogBGDiv").style.filter = "alpha(opacity=40)";
                }
            }
            if (d.AlertFlag) {
                _q$E.show(_q$E.getTopLevelWindow()._q$("_AlertBGDiv"));
            }
            if (d.ShowButtonRow && _q$E.visible(d.CancelButton)) {
                d.CancelButton.focus();
            }
            if (d.onLoad) {
                d.onLoad();
            }
        } catch (ex) { alert("DialogOnLoad:" + ex.message + "\t(" + ex.fileName + " " + ex.lineNumber + ")"); }
    }
}

Dialog.onKeyDown = function (event) {
    if (event.shiftKey && event.keyCode == 9) {//shift键
        var pw = _q$E.getTopLevelWindow();
        if (pw.Dialog._Array.length > 0) {
            stopEvent(event);
            return false;
        }
    }
    if (event.keyCode == 27) {//ESC键
        var pw = _q$E.getTopLevelWindow();
        if (pw.Dialog._Array.length > 0) {
            //Page.mousedown();
            //Page.click();
            var diag = pw.Dialog.getInstance(pw.Dialog._Array[pw.Dialog._Array.length - 1]);
            diag.CancelButton.onclick.apply(diag.CancelButton, []);
        }
    }
}

Dialog.dragStart = function (evt) {
    //DragManager.doDrag(evt,this.getParent("div"));//拖拽处理
}
Dialog.setPosition = function () {
    if (window.parent != window) return;
    var pw = _q$E.getTopLevelWindow();
    var DialogArr = pw.Dialog._Array;
    if (DialogArr == null || DialogArr.length == 0) return;

    for (i = 0; i < DialogArr.length; i++) {
        pw._q$("_DialogDiv_" + DialogArr[i]).DialogInstance.setPosition();
    }
}
Dialog.prototype.setPosition = function () {
    var pw = _q$E.getTopLevelWindow();
    var doc = pw.document;
    var cw = doc.compatMode == "BackCompat" ? doc.body.clientWidth : doc.documentElement.clientWidth;
    var ch = doc.compatMode == "BackCompat" ? doc.body.clientHeight : doc.documentElement.clientHeight; //必须考虑文本框处于页面边缘处，控件显示不全的问题
    var sl = Math.max(doc.documentElement.scrollLeft, doc.body.scrollLeft);
    var st = Math.max(doc.documentElement.scrollTop, doc.body.scrollTop); //考虑滚动的情况
    var sw = Math.max(doc.documentElement.scrollWidth, doc.body.scrollWidth);
    var sh = Math.max(doc.documentElement.scrollHeight, doc.body.scrollHeight);
    sw = Math.max(sw, cw);
    sh = Math.max(sh, ch);
    this.Top = (ch - this.Height - 30) / 2 + st - 8; //有8像素的透明背景
    this.Left = (cw - this.Width - 12) / 2 + sl;
    if (this.ShowButtonRow) {//按钮行高36
        this.Top -= 18;
    }
    this.DialogDiv.style.top = this.Top + "px";
    this.DialogDiv.style.left = this.Left + "px";
    //pw._q$(this.bgdivID).style.width= sw + "px";
    pw._q$(this.bgdivID).style.height = sh + "px";
}

var Drag = {
    "obj": null,
    "init": function (handle, dragBody, e) {
        if (e == null) {
            handle.onmousedown = Drag.start;
        }
        handle.root = dragBody;

        if (isNaN(parseInt(handle.root.style.left))) handle.root.style.left = "0px";
        if (isNaN(parseInt(handle.root.style.top))) handle.root.style.top = "0px";
        handle.root.onDragStart = new Function();
        handle.root.onDragEnd = new Function();
        handle.root.onDrag = new Function();
        if (e != null) {
            var handle = Drag.obj = handle;
            e = Drag.fixe(e);
            var top = parseInt(handle.root.style.top);
            var left = parseInt(handle.root.style.left);
            handle.root.onDragStart(left, top, e.pageX, e.pageY);
            handle.lastMouseX = e.pageX;
            handle.lastMouseY = e.pageY;
            document.onmousemove = Drag.drag;
            document.onmouseup = Drag.end;
        }
    },
    "start": function (e) {
        var handle = Drag.obj = this;
        e = Drag.fixEvent(e);
        var top = parseInt(handle.root.style.top);
        var left = parseInt(handle.root.style.left);
        //alert(left)
        handle.root.onDragStart(left, top, e.pageX, e.pageY);
        handle.lastMouseX = e.pageX;
        handle.lastMouseY = e.pageY;
        document.onmousemove = Drag.drag;
        document.onmouseup = Drag.end;
        return false;
    },
    "drag": function (e) {
        e = Drag.fixEvent(e);

        var handle = Drag.obj;
        var mouseY = e.pageY;
        var mouseX = e.pageX;
        var top = parseInt(handle.root.style.top);
        var left = parseInt(handle.root.style.left);

        if (isIE) { Drag.obj.setCapture(); } else { e.preventDefault(); }; //作用是将所有鼠标事件捕获到handle对象，对于firefox，以用preventDefault来取消事件的默认动作：

        var currentLeft, currentTop;
        currentLeft = left + mouseX - handle.lastMouseX;
        currentTop = top + (mouseY - handle.lastMouseY);
        handle.root.style.left = currentLeft + "px";
        handle.root.style.top = currentTop + "px";
        handle.lastMouseX = mouseX;
        handle.lastMouseY = mouseY;
        handle.root.onDrag(currentLeft, currentTop, e.pageX, e.pageY);
        return false;
    },
    "end": function () {
        if (isIE) { Drag.obj.releaseCapture(); }; //取消所有鼠标事件捕获到handle对象
        document.onmousemove = null;
        document.onmouseup = null;
        Drag.obj.root.onDragEnd(parseInt(Drag.obj.root.style.left), parseInt(Drag.obj.root.style.top));
        Drag.obj = null;
    },
    "fixEvent": function (e) {//格式化事件参数对象
        var sl = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
        var st = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
        if (typeof e == "undefined") e = window.event;
        if (typeof e.layerX == "undefined") e.layerX = e.offsetX;
        if (typeof e.layerY == "undefined") e.layerY = e.offsetY;
        if (typeof e.pageX == "undefined") e.pageX = e.clientX + sl - document.body.clientLeft;
        if (typeof e.pageY == "undefined") e.pageY = e.clientY + st - document.body.clientTop;
        return e;
    }
};

if (isIE) {
    document.attachEvent("onkeydown", Dialog.onKeyDown);
    window.attachEvent("onload", PageOnLoad);
    window.attachEvent('onresize', Dialog.setPosition);
} else {
    document.addEventListener("keydown", Dialog.onKeyDown, false);
    window.addEventListener("load", PageOnLoad, false);
    window.addEventListener('resize', Dialog.setPosition, false);
}