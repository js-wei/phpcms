function $(id) {  //获取id
    return typeof id === "string" ? document.getElementById(id) : id;
}
//获取tagName
function $$(elem, oParent) {
    return (oParent || document).getElementsByTagName(elem);
}
//获取class
function $$$(className, oParent) {
    var aClass = [];
    var reClass = new RegExp("(//s|^)" + className + "($|//s)");
    var aElem = $$("*", oParent);
    for (var i = 0; i < aElem.length; i++) reClass.test(aElem[i].className) && aClass.push(aElem[i]);
    return aClass
}
//初始化对象
function Roll() {
    this.initialize.apply(this, arguments)
}
Roll.prototype =
{
    initialize: function (obj) {
        var _this = this;
        this.obj = $(obj);
        this.oUp = $$$("up", this.obj)[0];
        this.oDown = $$$("down", this.obj)[0];
        this.oList = $$$("list", this.obj)[0];
        this.aItem = this.oList.children;
        this.timer = null;
        this.iNow = 0;
        this.iHeight = this.aItem[0].offsetHeight;
        this.oUp.onclick = function () {
            _this.up()
        };
        this.oDown.onclick = function () {
            _this.down()
        }
    },
    up: function () {
        this.oList.insertBefore(this.aItem[this.aItem.length - 1], this.oList.firstChild);
        this.oList.style.top = -this.iHeight + "px";
        this.doMove(0)
    },
    down: function () {
        this.doMove(-this.iHeight, function () {
            this.oList.appendChild(this.aItem[0]);
            this.oList.style.top = 0;
        })
    },
    doMove: function (iTarget, callBack) {
        var _this = this;
        clearInterval(this.timer)
        this.timer = setInterval(function () {
            var iSpeed = (iTarget - _this.oList.offsetTop) / 5;
            iSpeed = iSpeed > 0 ? Math.ceil(iSpeed) : Math.floor(iSpeed);
            _this.oList.offsetTop == iTarget ? (clearInterval(_this.timer), callBack && callBack.apply(_this)) : _this.oList.style.top = iSpeed + _this.oList.offsetTop + "px"
        }, 30)
    }
};