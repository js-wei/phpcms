!function() {
	function o(a) {
		var c, d, e, f, g, h, b = i.filter(".active");
		c = a ? a : b.length && b.next(".slider-item").length > 0 ? b.next() : i.eq(0), c.css("z-index", 2), d = i.index(c), n.eq(d).addClass("active").siblings().removeClass("active"), e = b.find("b"), e.length && e.animate({
			top: -50,
			opacity: 0
		}, 300), f = c.find("b"), f.length && (g = f.find("img"), h = g.attr("data-src"), h && g.attr("src", h).removeAttr("data-src"), f.animate({
			top: 0,
			opacity: 1
		}, 400)), b.fadeOut(300, function() {
			b.css("z-index", 1).show().removeClass("active"), c.css("z-index", 3).addClass("active")
		})
	}
	function q() {
		p = setInterval(function() {
			o()
		}, 5e3)
	}
	var b, d, e, f, g, i, j, k, l, m, n, p, r;
	if($("#slider").find(".slider-item").length>1){
	for (f = $("#slider"), g = $("#slider_index"), f.parent(), i = f.find(".slider-item"), j = g.find(".slider-index"), k = 0, l = i.length, m = []; l > k; k++) m.push('<span class="slider-index-item' + (0 == k ? " active" : "") + '">' + (k + 1) + "</span>");
	}
	j.append(m.join("")), n = j.find(".slider-index-item"), i.show(), q(), n.hover(function(a) {
		if (!$(this).hasClass("active")) {
			a.preventDefault();
			var b = n.index($(this));
			r = setTimeout(function() {
				clearInterval(p), clearTimeout(r), o(i.eq(b)), q()
			}, 300)
		}
	}, function() {
		clearTimeout(r)
	}), f.hover(function() {
		clearInterval(p)
	}, function() {
		q()
	})
}();