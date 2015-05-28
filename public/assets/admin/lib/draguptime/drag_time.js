	/*
	*	Create by uoon (vnjs.net);
	*	eMail: mnx2012@gmail.com;
	*	clean code from Kombai;
	*/
	
	var K = function(R) {
		var E = document.getElementById(R) || R;
		if (E.Element || K.check.isElement(E)) {
			E = E.Element || E;
			E.add = function(r) {
				var ADN = this;
				r.element = ADN;
				K.add(r);
				return K({Element: ADN});
			};
			E.hide = function() {
				var ADN = this;
				ADN.style.display = "none";
				return K({Element: ADN});
			};
			E.show = function() {
				var ADN = this;
				ADN.style.display = "block";
				ADN.style.visibility = "visible";
				return K({Element: ADN});
			};
			E.last = function() {
				var ADN = this;
				return K.get.lastChild(ADN);
			};
			E.first = function() {
				var ADN = this;
				return K.get.firstChild(ADN);
			};
			E.initDragDrop = function(r) {
				if (r === undefined) {
					var r = {};
				}
				var ADN = this;
				ADN.store = {
					x: 0,
					y: 0,
					X: 0,
					Y: 0
				};
				ADN.event = {  
					mouseDown: function() {},
					mouseMove: function() {},
					mouseUp: function() {}
				};
				ADN.run = {
					drag: r.onDrag || function() {},
					move: r.onMove || function() {},
					drop: r.onDrop || function() {}			
				};
				ADN.drop = function() {
					ADN.store = null;
					ADN.event = null;
					ADN.run = null;
					ADN.drop = function() {};
					ADN.onmousedown = ignore;
				};
				ADN.penetrate = function(enviroment) {
					if (!K.check.isElement(enviroment)) {
						return false;
					}
					var Xmin = K.get.X(enviroment);
					var Xmax = Xmin + enviroment.offsetWidth;
					var Ymin = K.get.Y(enviroment);
					var Ymax = Ymin + enviroment.offsetHeight;
					var X = ADN.store.X;
					var Y = ADN.store.Y;
					return (Xmin < X && X < Xmax && Ymin < Y && Y < Ymax) ? true : false;
				};
				ADN.event.mouseDown = function(event) {
					var event = event || window.event;
					if (!(event.button == 2 || event.which == 3)) {
						var position = K.get.currentStyle(ADN, "position");
						ADN.style.position = (position != "absolute") ? "relative" : "absolute";
						var left = K.get.currentStyle(ADN, "left");
						ADN.style.left = parseInt(left) ? left : "0px";
						var top = K.get.currentStyle(ADN, "top");
						ADN.style.top = parseInt(top) ? top : "0px";
						ADN.store.x = event.clientX;
						ADN.store.y = event.clientY;
						ADN.event.mouseMove = function(event) {
							var event = event || window.event;
							ADN.style.left = parseInt(ADN.style.left) + (event.clientX - ADN.store.x) + "px";
							ADN.style.top = parseInt(ADN.style.top) + (event.clientY - ADN.store.y) + "px";
							ADN.store.x = event.clientX;
							ADN.store.y = event.clientY;
							ADN.store.X = K.get.X(event);
							ADN.store.Y = K.get.Y(event);
							ADN.run.move.call({self: ADN, event: event});
							return false;
						};
						ADN.event.mouseUp = function(event) {
							var event = event || window.event;
							document.onmousemove = null;
							document.onmouseup = null;
							ADN.onmouseup = null;
							ADN.event.mouseUp = null;
							ADN.event.mouseMove = null;
							ADN.run.drop.call({self: ADN, event: event});
							return false;
						};
						document.onmousemove = ADN.event.mouseMove;
						document.onmouseup = function(event) {
							var event = event || window.event;
							var S = K.get.eventSource(event);
							if (S != ADN) {
								document.onmousemove = null;
							}
							ADN.event.mouseUp(event);
						};
						ADN.onmouseup = ADN.event.mouseUp;
						ADN.run.drag.call({self: ADN, event: event});
						return false;
					}
				};
				ADN.onmousedown = ADN.event.mouseDown;
				function ignore(event) {
					var event = event || window.event;
					event.cancelBubble = true;
				}
				function ignoreDagDrop(group) {
					if (group && group.length) {
						for (var o = 0; o < group.length; ++ o) {
							group[o].onmousedown = function(event) {
								var event = event || window.event;
								event.cancelBubble = true;
							}
						}
					}
				}
				(function() {
					var aForm = ADN.getElementsByTagName("form");
					if (aForm && aForm.length) {
						ignoreDagDrop(aForm);
					} else {
						var aInput = ADN.getElementsByTagName("input");
						ignoreDagDrop(aInput);
						var aIframe = ADN.getElementsByTagName("iframe");
						ignoreDagDrop(aIframe);
						var aTextarea = ADN.getElementsByTagName("textarea");
						ignoreDagDrop(aTextarea);
					}
				})();
				return K({Element: ADN});
			};
		}
		try {
			return E;
		} finally {
			E = null;
		}
	};
	
	K.add = function(r) {
		var setting = {
			element: null,
			className: null,
			style: null,
			event: null,
			attribute: null
		};
		for (var o in setting) {
			if (!Object.prototype[o] && r[o] !== undefined) {
				setting[o] = r[o];
			}	
		}
		(function () {
			with (setting) {
				if (!element) {
					return;
				}	
				if (className != null) {
					addClassName(element, className);
				}
				if (style != null) {
					addStyle(element, style);
				}
				if (event != null && event instanceof Object) {
					addEvent(element, event);
				}
				if (attribute != null && attribute instanceof Object) {
					addAttribute(element, attribute);
				}
			}
		})();
		function addClassName(e, c) {
			var eC = e.className;
			eC = (eC != "") ? eC += " " + c : c;
		}
		function addStyle(e, s) {
			if ((/string/).test(typeof s)) {
				e.setAttribute("style", s);
			} else if (s.constructor == Object) {
				for (var o in s) {
					e.style[o] = s[o];
				}
			}
		}
		function addEvent(e, evt) {
			for (var o in evt) {
				if (!Object.prototype[o]) {
					if (e.addEventlistenerer) {
			            e.addEventlistenerer(o, evt[o], false);
			        } else if (e.attachEvent) {
			            e.attachEvent("on" + o, evt[o]);
			        } else {
						e["on" + o] = evt[o];
					}
				}
			}
		}
		function addAttribute(e, a) {
			for (var o in a) {
				if (!Object.prototype[o]) {
					e.setAttribute(o.toString(), a[o]);
				}
			}
		}
	};
	
	K.get = {
		eventSource: function(event) {
			return (event && event.target) ? event.target : window.event.srcElement;
		},
		currentStyle: function(e, p) {
			var d = document, dV = "defaultView", gCS = "getComputedStyle", gPV = "getPropertyValue";
			if (e.currentStyle) {  
				if (p == "opacity") {
					var v = e.currentStyle["filter"];
					var m = v.match(/(.*)opacity\s*=\s*(\w+)(.*)/i);
					if (m) {
						var r = parseFloat(m[2]);
						return isNaN(r) ? 100 : r;
					}
					return 100;
				} 
				return e.currentStyle[p];
			} else if (d[dV] && d[dV][gCS]) {
				p = p.replace(/[(A-Z)]/g, function(match){return "-" + match.toLowerCase()});
				var r = d[dV][gCS](e, null)[gPV](p);
				return (p == "opacity") ? r*100 : r;
			} else {
				return null;
			}
		},
		X: function(r) {
			var d = document, dE = "documentElement", gE = "getElementById";
			var e = (/string/).test(typeof r) ? d[gE](r) : r ? r : window.event;
			if (e.nodeName) {
				var x = 0;
				while (e) {
					x += e.offsetLeft;
					e = e.offsetParent;
				}
				return x;
			} else if (e.clientX !== undefined) {
				return (e.clientX + d.body.scrollLeft + d[dE].scrollLeft);
			}
		},
		Y: function(r) {
			var d = document, dE = "documentElement", gE = "getElementById";
			var e = (/string/).test(typeof r) ? d[gE](r) : r ? r : window.event;
			if (e.nodeName) {
				var y = 0;
				while (e) {
					y += e.offsetTop;
					e = e.offsetParent;
				}
				return y;
			} else if (e.clientY !== undefined) {
				return (e.clientY + d.body.scrollTop + d[dE].scrollTop);
			}
		},
		firstChild: function(r) {
			var d = document, tN = "tagName", fC = "firstChild", nS = "nextSibling", gE = "getElementById";
			var e = (/string/).test(typeof r) ? d[gE](r) : r;
			return (e && e[tN]) ? ((e[fC] && e[fC][tN]) ? e[fC] : (e[fC] ? e[fC][nS] : null)) : null;
		},
		lastChild: function(r) {
			var d = document, tN = "tagName",  lC = "lastChild", pS = "previousSibling", gE = "getElementById";
			var e = (/string/).test(typeof r) ? d[gE](r) : r;
			return (e && e[tN]) ? ((e[lC] && e[lC][tN]) ? e[lC] : (e[lC] ? e[lC][pS] : null)) : null;
		}
	};

	K.check = {
		isObject: function(r) {
			return (r != null && r instanceof Object);
		},
		isElement: function(r) {
			return (r && r.tagName && r.nodeType == 1);
		}
	};
	
	K.create = {
		element: function(r) {
			var setting = {
				tagName: "div",
				id: null,
				innerHTML: null,
				className: null,
				//K.add;
				event: null,
				style: null,
				attribute: null
			};
			for (var o in setting) {
				if (!Object.prototype[o] && r[o] != undefined) {
					setting[o] = r[o];
				}
			}
			var newNode = document.createElement(setting.tagName);
			if (setting.id) {
				newNode.id = setting.id;
			}
			if (setting.innerHTML) {
				newNode.innerHTML = setting.innerHTML;
			}
			if (setting.className) {
				newNode.className = setting.className;
			}
			//working with K.add;
			if (K.add && K.add instanceof Function) {
				K.add({
					element: newNode,
					event: setting.event,
					style: setting.style,
					attribute: setting.attribute
				});
			}
			return newNode;
		}
	};
	
	K.remove = {
		element: function(r) {
			var p = "parentNode", rC = "removeChild", dg = document.getElementById;
			var e = (/string/).test(typeof r) ? dg(r) : r;
			(r && r[p]) ? r[p][rC](r) : false;
		}
	};