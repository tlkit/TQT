// JavaScript Document

var addTime = function(time) {
    /*
     *	1 hour = 38px;
     *	1 day = 600px;
     *	reference width of circle element: 600px;
     */
    var K_hour = 38;

    var limit = K('up_calendar').getElementsByTagName('input');
    //max = 60;
    /*if (limit && limit.length > 59) {
     alert("Lá»‹ch Ä‘Äƒng tin Ä‘Ã£ quÃ¡ giá»›i háº¡n 60 lÆ°á»£t má»—i ngÃ y.");
     return;
     }*/

    var pointer = K.create.element({
        style: {
            position: "absolute",
            top: "0px",
            width: "16px",
            height: "18px",
            cursor: "pointer",
            background: "url('style/images/drag_time/blue.gif') center no-repeat"
        },
        event: {
            mouseover: function(event) {
                var tooltip = K('tooltip').show();
                pointer.appendChild(tooltip);
                //var src = K.get.eventSource(event);
                var result = K('result');
                result.innerHTML = "";
                result.appendChild(document.createTextNode(pointer.interval));

            },
            mouseout: function(event) {
                K('tooltip').hide();
            }
        }
    });

    pointer.interval = time ? time : "00:00";

    if (time) {
        var exp = time.split(":");
        pointer.style.left =  (Math.round(K_hour * exp[0] + K_hour/60 * exp[1])) + "px";
    }


    K(pointer).initDragDrop({
        onMove: function() {
            var event = this.event;
            var element = this.self;
            var root = K('up_calendar');
            var rootX = K.get.X(root);
            var X = K.get.X(event) - rootX;
            element.style.top = "0px";

            if (X < 0) {
                element.style.left = "0px";
            } else if (X > 912) {
                element.style.left =  912  + "px";
            } else {
                var hour 	=  parseInt(X/K_hour);
                var minute 	=  Math.round((60/K_hour) * Math.round(X - K_hour * hour))

                minute = (minute < 10) ? "0" + minute : minute;
                var interval = 1 * hour < 10 ? "0" + hour + ":" + minute : hour + ":" + minute;
                K(element).first().value = interval;
                var result = K('result');
                result.innerHTML = "";
                result.appendChild(document.createTextNode(interval));
                element.interval = interval;
                element.style.left = X + "px";
            }
        }
    });

    var store = K.create.element({
        tagName: "input",
        className: "interval",
        attribute: {
            type: "hidden"
        }
    });

    pointer.appendChild(store);
    K('up_calendar').appendChild(pointer);
    pointer.first().value = pointer.interval;
};

var removeTime = function(object, event) {
    var event = event || window.event;
    event.cancelBubble = true;
    var parent = object.parentNode;
    var pointer = parent.parentNode;
    parent.style.display = "none";
    var up_calendar = K('up_calendar').appendChild(parent);
    K.remove.element(pointer);
};

var recoverTime = function(str){
    if(str != '')
    {
        var arrTime = str.split("|");
        var length 	= arrTime.length;

        for (var i = 0; i < length; ++i)
        {
            addTime(arrTime[i]);
        }
    }
};
	

