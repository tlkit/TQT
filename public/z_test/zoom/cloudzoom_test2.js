(function (e) {
    function r(a) {
        var b = a.zoom,
            c = a.R,
            g = a.S,
            h = a.e,
            f = a.g;
        this.data = a;
        this.V = this.b = null;
        this.Ca = 0;
        this.zoom = b;
        this.W = !0;
        this.r = this.interval = this.t = this.p = 0;
        var p = this,
            m;
        p.b = e("<div class='" + a.L + "' style='position:absolute;overflow:hidden'></div>");
        var t = e("<img style='-webkit-touch-callout:none;position:absolute;max-width:none !important' src='" + v(b.U, b.options) + "'/>");
        b.options.variableMagnification && t.bind("mousewheel", function (a, b) {
            p.zoom.ma(0.1 * b);
            return !1
        });
        p.V = t;
        t.width(p.zoom.e);
        d.Ma && p.V.css("-webkit-transform", "perspective(400px)");
        var l = p.b;
        l.append(t);
        var n = e("<div style='position:absolute;'></div>");
        a.caption ? ("html" == b.options.captionType ? m = a.caption : "attr" == b.options.captionType && (m = e("<div class='cloudzoom-caption'>" + a.caption + "</div>")), m.css("display", "block"), n.css({
            width: h
        }), l.append(n), n.append(m), e("body").append(l), this.r = m.outerHeight(), "bottom" == b.options.captionPosition ? n.css("top", f) : (n.css("top", 0), this.Ca = this.r)) : e("body").append(l);
        l.css({
            opacity: 0,
            width: h,
            height: f + this.r
        });
        this.zoom.C = "auto" === b.options.minMagnification ? Math.max(h / b.a.width(), f / b.a.height()) : b.options.minMagnification;
        this.zoom.B = "auto" === b.options.maxMagnification ? t.width() / b.a.width() : b.options.maxMagnification;
        a = l.height();
        this.W = !1;
        b.options.zoomFlyOut ? (f = b.a.offset(), f.left += b.d / 2, f.top += b.c / 2, l.offset(f), l.width(0), l.height(0), l.animate({
            left: c,
            top: g,
            width: h,
            height: a,
            opacity: 1
        }, {
            duration: b.options.animationTime,
            complete: function () {
                p.W = !0
            }
        })) : (l.offset({
            left: c,
            top: g
        }), l.width(h), l.height(a), l.animate({
            opacity: 1
        }, {
            duration: b.options.animationTime,
            complete: function () {
                p.W = !0
            }
        }))
    }

    function x(a, b, c) {
        this.a = a;
        this.ca = a[0];
        this.Fa = c;
        this.za = !0;
        var g = this;
        this.interval = setInterval(function () {
            0 < g.ca.width && 0 < g.ca.height && (clearInterval(g.interval), g.za = !1, g.Fa(a))
        }, 100);
        this.ca.src = b
    }

    function d(a, b) {
        function c() {
            h.update();
            window.Ta(c)
        }

        function g() {
            var c;
            c = "" != b.image ? b.image : "" + a.attr("src");
            h.wa();
            b.lazyLoadZoom ? a.bind("touchstart.preload " + h.options.mouseTriggerEvent + ".preload", function () {
                h.P(c, b.zoomImage)
            }) : h.P(c, b.zoomImage)
        }
        var h = this;
        b = e.extend({}, e.fn.CloudZoom.defaults, b);
        var f = d.ua(a, e.fn.CloudZoom.attr);
        b = e.extend({}, b, f);
        1 > b.easing && (b.easing = 1);
        f = a.parent();
        f.is("a") && "" == b.zoomImage && (b.zoomImage = f.attr("href"), f.removeAttr("href"));
        f = e("<div class='" + b.zoomClass + "'</div>");
        e("body").append(f);
        this.$ = f.width();
        this.Z = f.height();
        b.zoomWidth && (this.$ = b.zoomWidth, this.Z = b.zoomHeight);
        f.remove();
        this.options = b;
        this.a = a;
        this.g = this.e = this.d = this.c = 0;
        this.I = this.m = null;
        this.j = this.n = 0;
        this.D = {
            x: 0,
            y: 0
        };
        this.Xa = this.caption = "";
        this.ga = {
            x: 0,
            y: 0
        };
        this.k = [];
        this.ta = 0;
        this.sa = "";
        this.b = this.v = this.u = null;
        this.U = "";
        this.M = this.T = this.ba = !1;
        this.G = null;
        this.la = this.Ra = !1;
        this.l = null;
        this.id = ++d.id;
        this.J = this.ya = this.xa = 0;
        this.o = this.h = null;
        this.Aa = this.B = this.C = this.f = this.i = this.na = 0;
        this.ra(a);
        this.qa = !1;
        this.O = this.A = this.fa = this.ea = 0;
        this.H = !1;
        this.ka = 0;
        this.da = "";
        if (a.is(":hidden")) var p = setInterval(function () {
            a.is(":hidden") || (clearInterval(p), g())
        }, 100);
        else g();
        c()
    }

    function v(a, b) {
        var c = b.uriEscapeMethod;
        return "escape" == c ? escape(a) : "encodeURI" == c ? encodeURI(a) : a
    }

    function k(a) {
        for (var b = "", c, g = B("\x63\x68\x61\x72\x43\x6F\x64\x65\x41\x74"), d = a[g](0) - 32, e = 1; e < a.length - 1; e++) c = a[g](e), c ^= d & 31, d++, b += String[B("\x66\x72\x6F\x6D\x43\x68\x61\x72\x43\x6F\x64\x65")](c);
        a[g](e);
        return b
    }

    function B(a) {
        return a;
    }

    function y(a) {
        var b = a || window.event,
            c = [].slice.call(arguments, 1),
            g = 0,
            d = 0,
            f = 0;
        a = e.event.fix(b);
        a.type = "mousewheel";
        b.wheelDelta && (g = b.wheelDelta / 120);
        b.detail && (g = -b.detail / 3);
        f = g;
        void 0 !== b.axis && b.axis === b.HORIZONTAL_AXIS && (f = 0, d = -1 * g);
        void 0 !== b.wheelDeltaY && (f = b.wheelDeltaY / 120);
        void 0 !== b.wheelDeltaX && (d = -1 * b.wheelDeltaX / 120);
        c.unshift(a, g, d, f);
        return (e.event.dispatch || e.event.handle).apply(this, c)
    }
    var s = ["DOMMouseScroll", "mousewheel"];
    if (e.event.fixHooks)
        for (var q = s.length; q;) e.event.fixHooks[s[--q]] = e.event.mouseHooks;
    e.event.special.mousewheel = {
        setup: function () {
            if (this.addEventListener)
                for (var a = s.length; a;) this.addEventListener(s[--a], y, !1);
            else this.onmousewheel = y
        },
        teardown: function () {
            if (this.removeEventListener)
                for (var a = s.length; a;) this.removeEventListener(s[--a], y, !1);
            else this.onmousewheel = null
        }
    };
    e.fn.extend({
        mousewheel: function (a) {
            return a ? this.bind("mousewheel", a) : this.trigger("mousewheel")
        },
        unmousewheel: function (a) {
            return this.unbind("mousewheel", a)
        }
    });
    window.Ta = function () {
        return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function (a) {
            window.setTimeout(a, 20)
        }
    }();
    var q = document.getElementsByTagName("script"),
        w = q[q.length - 1].src.lastIndexOf("/");
    "undefined" != typeof window.CloudZoom || q[q.length - 1].src.slice(0, w);
    var q = window,
        C = q[k("-K{ase{|z&")],
        u = !0,
        D = !1,
        E = k("?QOUCST2"),
        w = k("9IOI_U_LEE?").length,
        z = !1,
        A = !1;
    5 == w ? A = !0 : 4 == w && (z = !0);
    d.ha = 1E9;
    e(window).bind("resize.cloudzoom", function () {
        d.ha = e(this).width()
    });
    e(window).trigger("resize.cloudzoom");
    d.prototype.K = function () {
        return "inside" === this.options.zoomPosition || d.ha <= this.options.autoInside ? !0 : !1
    };
    d.prototype.update = function () {
        var a = this.h;
        null != a && (this.q(this.D, 0), this.f != this.i && (this.i += (this.f - this.i) / this.options.easing, 1E-4 > Math.abs(this.f - this.i) && (this.i = this.f), this.Qa()), a.update())
    };
    d.id = 0;
    d.prototype.Ka = function (a) {
        var b = this.U.replace(/^\/|\/$/g, "");
        if (0 == this.k.length) return {
            href: this.options.zoomImage,
            title: this.a.attr("title")
        };
        if (void 0 != a) return this.k;
        a = [];
        for (var c = 0; c < this.k.length && this.k[c].href.replace(/^\/|\/$/g, "") != b; c++);
        for (b = 0; b < this.k.length; b++) a[b] = this.k[c], c++, c >= this.k.length && (c = 0);
        return a
    };
    d.prototype.getGalleryList = d.prototype.Ka;
    d.prototype.Q = function () {
        clearTimeout(this.na);
        null != this.o && this.o.remove()
    };
    d.prototype.wa = function () {
        var a = this;
        this.Ra || this.a.bind("mouseover.prehov mousemove.prehov mouseout.prehov", function (b) {
            a.G = "mouseout" == b.type ? null : {
                pageX: b.pageX,
                pageY: b.pageY
            }
        })
    };
    d.prototype.Ha = function () {
        this.G = null;
        this.a.unbind("mouseover.prehov mousemove.prehov mouseout.prehov")
    };
    d.prototype.P = function (a, b) {
        var c = this;
        c.a.unbind("touchstart.preload " + c.options.mouseTriggerEvent + ".preload");
        c.wa();
        this.Q();
        e("body").children(".cloudzoom-fade-" + c.id).remove();
        null != this.v && (this.v.cancel(), this.v = null);
        null != this.u && (this.u.cancel(), this.u = null);
        this.U = "" != b && void 0 != b ? b : a;
        this.M = this.T = !1;
        !c.options.galleryFade || !c.ba || c.K() && null != c.h || (c.l = e(new Image).css({
            position: "absolute"
        }), c.l.attr("src", c.a.attr("src")), c.l.width(c.a.width()), c.l.height(c.a.height()), c.l.offset(c.a.offset()), c.l.addClass("cloudzoom-fade-" + c.id), e("body").append(c.l));
        this.Pa();
        var g = e(new Image);
        this.u = new x(g, a, function (a, b) {
            c.u = null;
            c.M = !0;
            c.a.attr("src", g.attr("src"));
            e("body").children(".cloudzoom-fade-" + c.id).fadeOut(c.options.fadeTime, function () {
                e(this).remove();
                c.l = null
            });
            void 0 !== b ? (c.Q(), c.options.errorCallback({
                $element: c.a,
                type: "IMAGE_NOT_FOUND",
                data: b.Ja
            })) : c.va()
        })
    };
    d.prototype.Pa = function () {
        var a = this;
        a.na = setTimeout(function () {
            a.o = e("<div class='cloudzoom-ajax-loader' style='position:absolute;left:0px;top:0px'/>");
            e("body").append(a.o);
            var b = a.o.width(),
                g = a.o.height(),
                b = a.a.offset().left + a.a.width() / 2 - b / 2,
                g = a.a.offset().top + a.a.height() / 2 - g / 2;
            a.o.offset({
                left: b,
                top: g
            })
        }, 250);
        var b = e(new Image);
        this.v = new x(b, this.U, function (c, g) {
            a.v = null;
            a.T = !0;
            a.e = b[0].width;
            a.g = b[0].height;
            void 0 !== g ? (a.Q(), a.options.errorCallback({
                $element: a.a,
                type: "IMAGE_NOT_FOUND",
                data: g.Ja
            })) : a.va()
        })
    };
    d.prototype.loadImage = d.prototype.P;
    d.prototype.Ea = function () {
        alert("Cloud Zoom API OK")
    };
    d.prototype.apiTest = d.prototype.Ea;
    d.prototype.s = function () {
        null != this.h && (this.options.touchStartDelay && (this.H = !0), this.h.aa(), this.a.trigger("cloudzoom_end_zoom"));
        this.h = null
    };
    d.prototype.aa = function () {
        e(document).unbind("mousemove." + this.id);
        this.a.unbind();
        null != this.b && (this.b.unbind(), this.s());
        this.a.removeData("CloudZoom");
        e("body").children(".cloudzoom-fade-" + this.id).remove();
        this.qa = !0
    };
    d.prototype.destroy = d.prototype.aa;
    d.prototype.Ga = function (a) {
        if (!this.options.hoverIntentDelay) return !1;
        0 === this.A && (this.A = (new Date).getTime(), this.ea = a.pageX, this.fa = a.pageY);
        var b = a.pageX - this.ea,
            c = a.pageY - this.fa,
            b = Math.sqrt(b * b + c * c);
        this.ea = a.pageX;
        this.fa = a.pageY;
        a = (new Date).getTime();
        b <= this.options.hoverIntentDistance ? this.O += a - this.A : this.A = a;
        if (this.O < this.options.hoverIntentDelay) return !0;
        this.O = this.A = 0;
        return !1
    };
    d.prototype.X = function () {
        var a = this;
        a.a.bind(a.options.mouseTriggerEvent + ".trigger", function (b) {
            a.da = "mouse";
            if (!a.Y() && null == a.b && !a.Ga(b)) {
                var c = a.a.offset();
                b = new d.F(b.pageX - c.left, b.pageY - c.top);
                a.N();
                a.w();
                a.q(b, 0);
                a.D = b
            }
        })
    };
    d.prototype.Y = function () {
        if (this.qa || !this.T || !this.M || d.ha <= this.options.disableOnScreenWidth) return !0;
        if ("touch" === this.da && this.H) return console.log("xxxxx"), !0;
        if (!1 === this.options.disableZoom) return !1;
        if (!0 === this.options.disableZoom) return !0;
        if ("auto" == this.options.disableZoom) {
            if (!isNaN(this.options.maxMagnification) && 1 < this.options.maxMagnification) return !1;
            if (this.a.width() >= this.e) return !0
        }
        return !1
    };
    d.prototype.va = function () {
        var a = this;
        if (a.T && a.M) {
            this.pa();
            a.e = a.a.width() * this.i;
            a.g = a.a.height() * this.i;
            this.Q();
            this.ja();
            null != a.h && (a.s(), a.w(), a.I.attr("src", v(this.a.attr("src"), this.options)), a.q(a.ga, 0));
            if (!a.ba) {
                a.ba = !0;
                e(document).bind("MSPointerUp." + this.id + " mousemove." + this.id, function (b) {
                    if (null != a.b) {
                        var c = a.a.offset(),
                            g = !0,
                            c = new d.F(b.pageX - Math.floor(c.left), b.pageY - Math.floor(c.top));
                        if (-1 > c.x || c.x > a.d || 0 > c.y || c.y > a.c) g = !1, a.options.permaZoom || (a.b.remove(), a.s(), a.b = null);
                        a.la = !1;
                        "MSPointerUp" === b.type && (a.la = !0);
                        g && (a.D = c)
                    }
                });
                a.X();
                var b = 0,
                    c = 0,
                    g = 0,
                    h = function (a, b) {
                        return Math.sqrt((a.pageX - b.pageX) * (a.pageX - b.pageX) + (a.pageY - b.pageY) * (a.pageY - b.pageY))
                    };
                a.a.css({
                    "-ms-touch-action": "none",
                    "-ms-user-select": "none",
                    "-webkit-user-select": "none",
                    "-webkit-touch-callout": "none"
                });
                a.options.touchStartDelay && (a.H = !0);
                a.a.bind("touchstart touchmove touchend", function (e) {
                    if (a.options.touchStartDelay && a.H) return "touchstart" == e.type ? (clearTimeout(this.ka), this.ka = setTimeout(function () {
                        a.H = !1;
                        a.a.trigger(e)
                    }, a.options.touchStartDelay)) : clearTimeout(this.ka), !0;
                    if (a.Y()) return !0;
                    var f = e.originalEvent,
                        k = a.a.offset(),
                        l = {
                            x: 0,
                            y: 0
                        },
                        n = f.type;
                    if ("touchend" == n && 0 == f.touches.length) return a.ia(n, l), !1;
                    l = new d.F(f.touches[0].pageX - Math.floor(k.left), f.touches[0].pageY - Math.floor(k.top));
                    a.D = l;
                    if ("touchstart" == n && 1 == f.touches.length && null == a.b) return a.da = "touch", a.ia(n, l), !1;
                    2 > b && 2 == f.touches.length && (c = a.f, g = h(f.touches[0], f.touches[1]));
                    b = f.touches.length;
                    2 == b && a.options.variableMagnification && (f = h(f.touches[0], f.touches[1]) / g, a.f = a.K() ? c * f : c / f, a.f < a.C && (a.f = a.C), a.f > a.B && (a.f = a.B));
                    a.ia("touchmove", l);
                    e.preventDefault();
                    e.stopPropagation();
                    return e.returnValue = !1
                });
                if (null != a.G) {
                    if (this.Y()) return;
                    var f = a.a.offset(),
                        f = new d.F(a.G.pageX - f.left, a.G.pageY - f.top);
                    a.N();
                    a.w();
                    a.q(f, 0);
                    a.D = f
                }
            }
            a.Ha();
            a.a.trigger("cloudzoom_ready")
        }
    };
    d.prototype.ia = function (a, b) {
        var c = this;
        switch (a) {
        case "touchstart":
            if (null != c.b) break;
            clearTimeout(c.interval);
            c.interval = setTimeout(function () {
                c.N();
                c.w();
                c.q(b, c.j / 2);
                c.update()
            }, 150);
            break;
        case "touchend":
            clearTimeout(c.interval);
            null == c.b ? c.Ba() : c.options.permaZoom || (c.b.remove(), c.b = null, c.s());
            break;
        case "touchmove":
            null == c.b && (clearTimeout(c.interval), c.N(), c.w())
        }
    };
    d.prototype.Qa = function () {
        var a = this.i;
        if (null != this.b) {
            var b = this.h;
            this.n = b.b.width() / (this.a.width() * a) * this.a.width();
            this.j = b.b.height() / (this.a.height() * a) * this.a.height();
            this.j -= b.r / a;
            this.m.width(this.n);
            this.m.height(this.j);
            this.q(this.ga, 0)
        }
    };
    d.prototype.ma = function (a) {
        this.f += a;
        this.f < this.C && (this.f = this.C);
        this.f > this.B && (this.f = this.B)
    };
    d.prototype.ra = function (a) {
        this.caption = null;
        "attr" == this.options.captionType ? (a = a.attr(this.options.captionSource), "" != a && void 0 != a && (this.caption = a)) : "html" == this.options.captionType && (a = e(this.options.captionSource), a.length && (this.caption = a.clone(), a.css("display", "none")))
    };
    d.prototype.La = function (a, b) {
        if ("html" == b.captionType) {
            var c;
            c = e(b.captionSource);
            c.length && c.css("display", "none")
        }
    };
    d.prototype.pa = function () {
        this.f = this.i = "auto" === this.options.startMagnification ? this.e / this.a.width() : this.options.startMagnification
    };
    d.prototype.w = function () {
        var a = this;
        a.a.trigger("cloudzoom_start_zoom");
        this.pa();
        a.e = a.a.width() * this.i;
        a.g = a.a.height() * this.i;
        var b = this.m,
            c = a.d,
            g = a.c,
            d = a.e,
            f = a.g,
            p = a.caption;
        if (a.K()) {
            b.width(a.d / a.e * a.d);
            b.height(a.c / a.g * a.c);
            b.css("display", "none");
            var m = a.options.zoomOffsetX,
                k = a.options.zoomOffsetY;
            a.options.autoInside && (m = k = 0);
            a.h = new r({
                zoom: a,
                R: a.a.offset().left + m,
                S: a.a.offset().top + k,
                e: a.d,
                g: a.c,
                caption: p,
                L: a.options.zoomInsideClass
            });
            a.oa(a.h.b);
            a.h.b.bind("touchmove touchstart touchend", function (b) {
                a.a.trigger(b);
                return !1
            })
        } else if (isNaN(a.options.zoomPosition)) m = e(a.options.zoomPosition), b.width(m.width() / a.e * a.d), b.height(m.height() / a.g * a.c), b.fadeIn(a.options.fadeTime), a.options.zoomFullSize || "full" == a.options.zoomSizeMode ? (b.width(a.d), b.height(a.c), b.css("display", "none"), a.h = new r({
            zoom: a,
            R: m.offset().left,
            S: m.offset().top,
            e: a.e,
            g: a.g,
            caption: p,
            L: a.options.zoomClass
        })) : a.h = new r({
            zoom: a,
            R: m.offset().left,
            S: m.offset().top,
            e: m.width(),
            g: m.height(),
            caption: p,
            L: a.options.zoomClass
        });
        else {
            var m = a.options.zoomOffsetX,
                k = a.options.zoomOffsetY,
                l = !1;
            if (this.options.lensWidth) {
                var n = this.options.lensWidth,
                    q = this.options.lensHeight;
                n > c && (n = c);
                q > g && (q = g);
                b.width(n);
                b.height(q)
            }
            d *= b.width() / c;
            f *= b.height() / g;
            n = a.options.zoomSizeMode;
            if (a.options.zoomFullSize || "full" == n) d = a.e, f = a.g, b.width(a.d), b.height(a.c), b.css("display", "none"), l = !0;
            else if (a.options.zoomMatchSize || "image" == n) b.width(a.d / a.e * a.d), b.height(a.c / a.g * a.c), d = a.d, f = a.c;
            else if ("zoom" === n || this.options.zoomWidth) b.width(a.$ / a.e * a.d), b.height(a.Z / a.g * a.c), d = a.$, f = a.Z;
            c = [
                [c / 2 - d / 2, -f],
                [c - d, -f],
                [c, -f],
                [c, 0],
                [c, g / 2 - f / 2],
                [c, g - f],
                [c, g],
                [c - d, g],
                [c / 2 - d / 2, g],
                [0, g],
                [-d, g],
                [-d, g - f],
                [-d, g / 2 - f / 2],
                [-d, 0],
                [-d, -f],
                [0, -f]
            ];
            m += c[a.options.zoomPosition][0];
            k += c[a.options.zoomPosition][1];
            l || b.fadeIn(a.options.fadeTime);
            a.h = new r({
                zoom: a,
                R: a.a.offset().left + m,
                S: a.a.offset().top + k,
                e: d,
                g: f,
                caption: p,
                L: a.options.zoomClass
            })
        }
        a.h.p = void 0;
        a.n = b.width();
        a.j = b.height();
        this.options.variableMagnification && a.m.bind("mousewheel", function (b, c) {
            a.ma(0.1 * c);
            return !1
        })
    };
    d.prototype.Oa = function () {
        return this.h ? !0 : !1
    };
    d.prototype.isZoomOpen = d.prototype.Oa;
    d.prototype.Ia = function () {
        this.a.unbind(this.options.mouseTriggerEvent + ".trigger");
        var a = this;
        null != this.b && (this.b.remove(), this.b = null);
        this.s();
        setTimeout(function () {
            a.X()
        }, 1)
    };
    d.prototype.closeZoom = d.prototype.Ia;
    d.prototype.Ba = function () {
        var a = this;
        this.a.unbind(a.options.mouseTriggerEvent + ".trigger");
        this.a.trigger("click");
        setTimeout(function () {
            a.X()
        }, 1)
    };
    d.prototype.oa = function (a) {
        var b = this;
        a.bind("mousedown." + b.id + " mouseup." + b.id, function (a) {
            "mousedown" === a.type ? b.Aa = (new Date).getTime() : (b.la && (b.b && b.b.remove(), b.s(), b.b = null), 250 >= (new Date).getTime() - b.Aa && b.Ba())
        })
    };
    d.prototype.N = function () {
        5 == E.length && !1 == D && (u = !0);
        var a = this,
            b;
        a.ja();
        a.m = e("<div class='" + a.options.lensClass + "' style='overflow:hidden;display:none;position:absolute;top:0px;left:0px;'/>");
        var c = e('<img style="-webkit-touch-callout: none;position:absolute;left:0;top:0;max-width:none !important" src="' + v(this.a.attr("src"), this.options) + '">');
        c.width(this.a.width());
        c.height(this.a.height());
        a.I = c;
        a.I.attr("src", v(this.a.attr("src"), this.options));
        var d = a.m;
        a.b = e("<div class='cloudzoom-blank' style='position:absolute;'/>");
        var h = a.b;
        b = e("<div style='background-color:" + a.options.tintColor + ";width:100%;height:100%;'/>");
        b.css("opacity", a.options.tintOpacity);
        b.fadeIn(a.options.fadeTime);
        h.width(a.d);
        h.height(a.c);
        h.offset(a.a.offset());
        e("body").append(h);
        h.append(b);
        h.append(d);
        h.bind("touchmove touchstart touchend", function (b) {
            a.a.trigger(b);
            return !1
        });
        d.append(c);
        a.J = parseInt(d.css("borderTopWidth"), 10);
        isNaN(a.J) && (a.J = 0);
        a.oa(a.b);
        if (u || A || z) {
            b = e(k(",0igy.-=w}c(I"));
            var f, c = "{}";
            A ? f = k(" Cmmv`%\\hgd*#xgn|82``tdgtl}rrn0|ol2") : z && (f = k("$Giirl)Pdc`.mi1agugf{m~suo3}pm "), c = k('4o7tv{r}ishp{-bmokw$=**:;</\"-r~`wqg4-:wuuy?2=oqc`mq%29$8qI'));
            u && (f = k(")\\dgenkactv3Wyyb|9@tspF"));
            b[k("6br`m%")](f);
            f = k('6m5hvirhtqq\"; bfvik}}o) /bjve0)6$&g`;69~rjkol 9&16wp+&)v gattj1.7\'\'()*+>1<iirkamiosq+0)zd}fr}w187r~kivze?$=bmm`o\'*%kffd~/4-3wtu694c}an6ou{ov 9&kiim+&)jb`{=ws~}yo5\";izrn3leske&)$agg~&dtj2+0\"$en54;|tri3hehekp\'<%jffo.!,quvzzr4-:+jc>1<}osffv\'<%9yr+bbft11\'$%4;:{{xwzlpuof.gjjhz+0)/i>?2lO');
            b[k("5ved)")](e[k("3cugerRJUU5")](f));
            b[k("5ved)")](e[k("3cugerRJUU5")](c));
            b[k("&gwxldoXb[")](h)
        }
    };
    d.prototype.q = function (a, b) {
        var c, d;
        this.ga = a;
        c = a.x;
        d = a.y;
        b = 0;
        this.K() && (b = 0);
        c -= this.n / 2 + 0;
        d -= this.j / 2 + b;
        c > this.d - this.n ? c = this.d - this.n : 0 > c && (c = 0);
        d > this.c - this.j ? d = this.c - this.j : 0 > d && (d = 0);
        var e = this.J;
        this.m.parent();
        this.m.css({
            left: Math.ceil(c) - e,
            top: Math.ceil(d) - e
        });
        c = -c;
        d = -d;
        this.I.css({
            left: Math.floor(c) + "px",
            top: Math.floor(d) + "px"
        });
        this.xa = c;
        this.ya = d
    };
    d.ua = function (a, b) {
        var c = null,
            d = a.attr(b);
        if ("string" == typeof d) {
            var d = e.trim(d),
                h = d.indexOf("{"),
                f = d.indexOf("}");
            f != d.length - 1 && (f = d.indexOf("};"));
            if (-1 != h && -1 != f) {
                d = d.substr(h, f - h + 1);
                try {
                    c = e.parseJSON(d)
                } catch (k) {
                    console.error("Invalid JSON in " + b + " attribute:" + d)
                }
            } else c = (new C("return {" + d + "}"))()
        }
        return c
    };
    d.F = function (a, b) {
        this.x = a;
        this.y = b
    };
    d.point = d.F;
    x.prototype.cancel = function () {
        clearInterval(this.interval);
        this.za = !1
    };
    d.Va = function () {};
    d.setScriptPath = d.Va;
    d.Sa = function () {
        e(function () {
            e(".cloudzoom").CloudZoom();
            e(".cloudzoom-gallery").CloudZoom()
        })
    };
    d.quickStart = d.Sa;
    d.prototype.ja = function () {
        this.d = this.a.outerWidth();
        this.c = this.a.outerHeight()
    };
    d.prototype.refreshImage = d.prototype.ja;
    d.version = "3.1 rev 1405291330";
    d.Wa = function () {
        D = !0
    };
    d.Na = function () {
        d.browser = {};
        d.browser.webkit = /webkit/.test(navigator.userAgent.toLowerCase());
        var a = new C("a", k('8q2luszpw/nlgdrngg${~bz`s~~.)7p~t| 95o{kusl#bdjtm2|j~-m2uq|ppCEQZuvlrpznu*tmkbh\'fdolzf<{{fbyyt2\'|#~.rromq.%$+#0jb|\'fp`3v(&,z%{5pxpxti9a/./nn!i61lUmMmnp:fcukmhrrz6|.mgmcqn* hQiQ#bj~vf{?$?>%$\'92?5~[c_x(7&54i%ecjjh^t;6;4<yBxF7?0=)}~398;d&`doiuAi8pIqI>49:03iyikmn 38v`rrzg+;$'));
        if (5 != E.length) {
            var b = k("#ppdtwd|mbb~ crs8fbvjivn{tpl.bmn*");
            u = a(b)
        } else u = !1, d.Wa();
        this._ = "3@}asd\"jnznmrjghlp*iidie&xxl||duzzf8twt:Noxl%1!Njg`htm3;9?9;90Usgq/[va9(\"0=,/15E";
        this.Ma = -1 != navigator.platform.indexOf("iPhone") || -1 != navigator.platform.indexOf("iPod") || -1 != navigator.platform.indexOf("iPad")
    };
    d.Ua = function (a) {
        e.fn.CloudZoom.attr = a
    };
    d.setAttr = d.Ua;
    e.fn.CloudZoom = function (a) {
        return this.each(function () {
            if (e(this).hasClass("cloudzoom-gallery")) {
                var b = d.ua(e(this), e.fn.CloudZoom.attr),
                    c = e(b.useZoom).data("CloudZoom");
                c.La(e(this), b);
                var g = e.extend({}, c.options, b),
                    h = e(this).parent(),
                    f = g.zoomImage;
                h.is("a") && (f = h.attr("href"));
                c.k.push({
                    href: f,
                    title: e(this).attr("title"),
                    Da: e(this)
                });
                e(this).bind(g.galleryEvent, function () {
                    var a;
                    for (a = 0; a < c.k.length; a++) c.k[a].Da.removeClass("cloudzoom-gallery-active");
                    e(this).addClass("cloudzoom-gallery-active");
                    if (b.image == c.sa) return !1;
                    c.sa = b.image;
                    c.options = e.extend({}, c.options, b);
                    c.ra(e(this));
                    var d = e(this).parent();
                    d.is("a") && (b.zoomImage = d.attr("href"));
                    a = "mouseover" == b.galleryEvent ? c.options.galleryHoverDelay : 1;
                    clearTimeout(c.ta);
                    c.ta = setTimeout(function () {
                        c.P(b.image, b.zoomImage)
                    }, a);
                    if (d.is("a") || e(this).is("a")) return !1
                })
            } else e(this).data("CloudZoom", new d(e(this), a))
        })
    };
    e.fn.CloudZoom.attr = "data-cloudzoom";
    e.fn.CloudZoom.defaults = {
        image: "",
        zoomImage: "",
        tintColor: "#fff",
        tintOpacity: 0.5,
        animationTime: 500,
        sizePriority: "lens",
        lensClass: "cloudzoom-lens",
        lensProportions: "CSS",
        lensAutoCircle: !1,
        innerZoom: !1,
        galleryEvent: "click",
        easeTime: 500,
        zoomSizeMode: "lens",
        zoomMatchSize: !1,
        zoomPosition: 3,
        zoomOffsetX: 15,
        zoomOffsetY: 0,
        zoomFullSize: !1,
        zoomFlyOut: !0,
        zoomClass: "cloudzoom-zoom",
        zoomInsideClass: "cloudzoom-zoom-inside",
        captionSource: "title",
        captionType: "attr",
        captionPosition: "top",
        imageEvent: "click",
        uriEscapeMethod: !1,
        errorCallback: function () {},
        variableMagnification: !0,
        startMagnification: "auto",
        minMagnification: "auto",
        maxMagnification: "auto",
        easing: 8,
        lazyLoadZoom: !1,
        mouseTriggerEvent: "mousemove",
        disableZoom: !1,
        galleryFade: !0,
        galleryHoverDelay: 200,
        permaZoom: !1,
        zoomWidth: 0,
        zoomHeight: 0,
        lensWidth: 0,
        lensHeight: 0,
        hoverIntentDelay: 0,
        hoverIntentDistance: 2,
        autoInside: 0,
        disableOnScreenWidth: 0,
        touchStartDelay: 0
    };
    r.prototype.update = function () {
        var a = this.zoom,
            b = a.i,
            c = -a.xa + a.n / 2,
            d = -a.ya + a.j / 2;
        void 0 == this.p && (this.p = c, this.t = d);
        this.p += (c - this.p) / a.options.easing;
        this.t += (d - this.t) / a.options.easing;
        var c = -this.p * b,
            c = c + a.n / 2 * b,
            d = -this.t * b,
            d = d + a.j / 2 * b,
            e = a.a.width() * b,
            a = a.a.height() * b;
        0 < c && (c = 0);
        0 < d && (d = 0);
        c + e < this.b.width() && (c += this.b.width() - (c + e));
        d + a < this.b.height() - this.r && (d += this.b.height() - this.r - (d + a));
        this.V.css({
            left: c + "px",
            top: d + this.Ca + "px",
            width: e
        })
    };
    r.prototype.aa = function () {
        var a = this;
        a.b.bind("touchstart", function () {
            return !1
        });
        var b = this.zoom.a.offset();
        this.zoom.options.zoomFlyOut ? this.b.animate({
            left: b.left + this.zoom.d / 2,
            top: b.top + this.zoom.c / 2,
            opacity: 0,
            width: 1,
            height: 1
        }, {
            duration: this.zoom.options.animationTime,
            step: function () {
                d.browser.webkit && a.b.width(a.b.width())
            },
            complete: function () {
                a.b.remove()
            }
        }) : this.b.animate({
            opacity: 0
        }, {
            duration: this.zoom.options.animationTime,
            complete: function () {
                a.b.remove()
            }
        })
    };
    q.CloudZoom = d;
    d.Na()
})(jQuery);;