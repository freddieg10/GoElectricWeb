jQuery(document).ready(function(l){var e=function(e){this.element=e,this.handleContainer=this.element.find(".cd-product-viewer-handle"),this.handleFill=this.handleContainer.children(".fill"),this.handle=this.handleContainer.children(".handle"),this.imageWrapper=this.element.find(".product-viewer"),this.slideShow=this.imageWrapper.children(".product-sprite"),this.frames=this.element.data("frame"),this.friction=this.element.data("friction"),this.visibleFrame=0,this.loaded=!1,this.animating=!1,this.xPosition=0,this.loadFrames()};function o(e,t){e.css({"-moz-transform":t,"-webkit-transform":t,"-ms-transform":t,"-o-transform":t,transform:t})}e.prototype.loadFrames=function(){var e=this,t=this.slideShow.data("image"),n=l("<img/>");this.loading("0.5"),n.attr("src",t).load(function(){l(this).remove(),e.loaded=!0}).each(function(){image=this,image.complete&&l(image).trigger("load")})},e.prototype.loading=function(t){var n=this;o(this.handleFill,"scaleX("+t+")"),setTimeout(function(){if(n.loaded)n.element.addClass("loaded"),o(n.handleFill,"scaleX(1)"),n.dragImage(),n.handle&&n.dragHandle();else{var e=parseFloat(t)+.1;e<1?n.loading(e):n.loading(parseFloat(t))}},500)},e.prototype.dragHandle=function(){var s=this;s.handle.on("mousedown vmousedown",function(e){s.handle.addClass("cd-draggable");var t=s.handle.outerWidth(),n=s.handleContainer.offset().left,o=s.handleContainer.outerWidth(),i=n-t/2,a=n+o-t/2;s.xPosition=s.handle.offset().left+t-e.pageX,s.element.on("mousemove vmousemove",function(e){s.animating||(s.animating=!0,window.requestAnimationFrame?requestAnimationFrame(function(){s.animateDraggedHandle(e,t,n,o,i,a)}):setTimeout(function(){s.animateDraggedHandle(e,t,n,o,i,a)},100))}).one("mouseup vmouseup",function(e){s.handle.removeClass("cd-draggable"),s.element.off("mousemove vmousemove")}),e.preventDefault()}).on("mouseup vmouseup",function(e){s.handle.removeClass("cd-draggable")})},e.prototype.animateDraggedHandle=function(e,t,n,o,i,a){var s=this,r=e.pageX+s.xPosition-t;r<i?r=i:a<r&&(r=a);var u=Math.ceil(1e3*(r+t/2-n)/o)/10;s.visibleFrame=Math.ceil(u*(s.frames-1)/100),s.updateFrame(),l(".cd-draggable",s.handleContainer).css("left",u+"%").one("mouseup vmouseup",function(){l(this).removeClass("cd-draggable")}),s.animating=!1},e.prototype.dragImage=function(){var o=this;o.slideShow.on("mousedown vmousedown",function(e){o.slideShow.addClass("cd-draggable");var t=o.imageWrapper.offset().left,n=o.imageWrapper.outerWidth();o.frames;o.xPosition=e.pageX,o.element.on("mousemove vmousemove",function(e){o.animating||(o.animating=!0,window.requestAnimationFrame?requestAnimationFrame(function(){o.animateDraggedImage(e,t,n)}):setTimeout(function(){o.animateDraggedImage(e,t,n)},100))}).one("mouseup vmouseup",function(e){o.slideShow.removeClass("cd-draggable"),o.element.off("mousemove vmousemove"),o.updateHandle()}),e.preventDefault()}).on("mouseup vmouseup",function(e){o.slideShow.removeClass("cd-draggable")})},e.prototype.animateDraggedImage=function(e,t,n){var o=this,i=o.xPosition-e.pageX,a=Math.ceil(100*i/(n*o.friction))*(o.frames-1)/100;a=0<a?Math.floor(a):Math.ceil(a);var s=o.visibleFrame+a;s<0?s=o.frames-1:s>o.frames-1&&(s=0),s!=o.visibleFrame&&(o.visibleFrame=s,o.updateFrame(),o.xPosition=e.pageX),o.animating=!1},e.prototype.updateHandle=function(){if(this.handle){var e=100*this.visibleFrame/this.frames;this.handle.animate({left:e+"%"},200)}},e.prototype.updateFrame=function(){var e=-100*this.visibleFrame/this.frames;o(this.slideShow,"translateX("+e+"%)")},l(".cd-product-viewer-wrapper").each(function(){new e(l(this))})}),function(t,n,o){"function"==typeof define&&define.amd?define(["jquery"],function(e){return o(e,t,n),e.mobile}):o(t.jQuery,t,n)}(this,document,function(e,t,o,n){var i,a;(function(h,e,t,p){function m(e){for(;e&&void 0!==e.originalEvent;)e=e.originalEvent;return e}function a(e){for(var t,n,o={};e;){for(n in t=h.data(e,D))t[n]&&(o[n]=o.hasVirtualBinding=!0);e=e.parentNode}return o}function i(){H=!0}function s(){H=!1}function r(){u(),C=setTimeout(function(){A=C=0,S.length=0,Y=!1,i()},h.vmouse.resetTimerDuration)}function u(){C&&(clearTimeout(C),C=0)}function l(e,t,n){var o;return(n&&n[e]||!n&&function(e,t){for(var n;e;){if((n=h.data(e,D))&&(!t||n[t]))return e;e=e.parentNode}return null}(t.target,e))&&(o=function(e,t){var n,o,i,a,s,r,u,l,c,d=e.type;if((e=h.Event(e)).type=t,n=e.originalEvent,o=h.event.props,-1<d.search(/^(mouse|click)/)&&(o=M),n)for(u=o.length;u;)e[a=o[--u]]=n[a];if(-1<d.search(/mouse(down|up)|click/)&&!e.which&&(e.which=1),-1!==d.search(/^touch/)&&(d=(i=m(n)).touches,s=i.changedTouches,r=d&&d.length?d[0]:s&&s.length?s[0]:p))for(l=0,c=X.length;l<c;l++)e[a=X[l]]=r[a];return e}(t,e),h(t.target).trigger(o)),o}function c(e){var t,n=h.data(e.target,y);!Y&&(!A||A!==n)&&((t=l("v"+e.type,e))&&(t.isDefaultPrevented()&&e.preventDefault(),t.isPropagationStopped()&&e.stopPropagation(),t.isImmediatePropagationStopped()&&e.stopImmediatePropagation()))}function d(e){var t,n,o,i=m(e).touches;i&&1===i.length&&((n=a(t=e.target)).hasVirtualBinding&&(A=L++,h.data(t,y,A),u(),s(),E=!1,o=m(e).touches[0],k=o.pageX,x=o.pageY,l("vmouseover",e,n),l("vmousedown",e,n)))}function v(e){H||(E||l("vmousecancel",e,a(e.target)),E=!0,r())}function f(e){if(!H){var t=m(e).touches[0],n=E,o=h.vmouse.moveDistanceThreshold,i=a(e.target);(E=E||Math.abs(t.pageX-k)>o||Math.abs(t.pageY-x)>o)&&!n&&l("vmousecancel",e,i),l("vmousemove",e,i),r()}}function g(e){if(!H){i();var t,n,o=a(e.target);l("vmouseup",e,o),E||(t=l("vclick",e,o))&&t.isDefaultPrevented()&&(n=m(e).changedTouches[0],S.push({touchID:A,x:n.clientX,y:n.clientY}),Y=!0),l("vmouseout",e,o),E=!1,r()}}function w(e){var t,n=h.data(e,D);if(n)for(t in n)if(n[t])return!0;return!1}function b(){}function n(n){var o=n.substr(1);return{setup:function(){w(this)||h.data(this,D,{}),h.data(this,D)[n]=!0,I[n]=(I[n]||0)+1,1===I[n]&&q.bind(o,c),h(this).bind(o,b),W&&(I.touchstart=(I.touchstart||0)+1,1===I.touchstart&&q.bind("touchstart",d).bind("touchend",g).bind("touchmove",f).bind("scroll",v))},teardown:function(){--I[n],I[n]||q.unbind(o,c),W&&(--I.touchstart,I.touchstart||q.unbind("touchstart",d).unbind("touchmove",f).unbind("touchend",g).unbind("scroll",v));var e=h(this),t=h.data(this,D);t&&(t[n]=!1),e.unbind(o,b),w(this)||e.removeData(D)}}}var T,o,D="virtualMouseBindings",y="virtualTouchID",F="vmouseover vmousedown vmousemove vmouseup vclick vmouseout vmousecancel".split(" "),X="clientX clientY pageX pageY screenX screenY".split(" "),P=h.event.mouseHooks?h.event.mouseHooks.props:[],M=h.event.props.concat(P),I={},C=0,k=0,x=0,E=!1,S=[],Y=!1,H=!1,W="addEventListener"in t,q=h(t),L=1,A=0;for(h.vmouse={moveDistanceThreshold:10,clickDistanceThreshold:10,resetTimerDuration:1500},o=0;o<F.length;o++)h.event.special[F[o]]=n(F[o]);W&&t.addEventListener("click",function(e){var t,n,o,i,a,s=S.length,r=e.target;if(s)for(t=e.clientX,n=e.clientY,T=h.vmouse.clickDistanceThreshold,o=r;o;){for(i=0;i<s;i++)if(a=S[i],0,o===r&&Math.abs(a.x-t)<T&&Math.abs(a.y-n)<T||h.data(o,y)===a.touchID)return e.preventDefault(),void e.stopPropagation();o=o.parentNode}},!0)})(e,0,o),e.mobile={},a={touch:"ontouchend"in o},(i=e).mobile.support=i.mobile.support||{},i.extend(i.support,a),i.extend(i.mobile.support,a),function(l,a,s){function c(e,t,n,o){var i=n.type;n.type=t,o?l.event.trigger(n,s,e):l.event.dispatch.call(e,n),n.type=i}var d=l(o),e=l.mobile.support.touch,r="touchmove scroll",n=e?"touchstart":"mousedown",u=e?"touchend":"mouseup",h=e?"touchmove":"mousemove";l.each("touchstart touchmove touchend tap taphold swipe swipeleft swiperight scrollstart scrollstop".split(" "),function(e,t){l.fn[t]=function(e){return e?this.bind(t,e):this.trigger(t)},l.attrFn&&(l.attrFn[t]=!0)}),l.event.special.scrollstart={enabled:!0,setup:function(){function t(e,t){c(i,(n=t)?"scrollstart":"scrollstop",e)}var n,o,i=this;l(i).bind(r,function(e){l.event.special.scrollstart.enabled&&(n||t(e,!0),clearTimeout(o),o=setTimeout(function(){t(e,!1)},50))})},teardown:function(){l(this).unbind(r)}},l.event.special.tap={tapholdThreshold:750,emitTapOnTaphold:!0,setup:function(){var s=this,r=l(s),u=!1;r.bind("vmousedown",function(e){function t(){clearTimeout(i)}function n(){t(),r.unbind("vclick",o).unbind("vmouseup",t),d.unbind("vmousecancel",n)}function o(e){n(),u||a!==e.target?u&&e.preventDefault():c(s,"tap",e)}if(u=!1,e.which&&1!==e.which)return!1;var i,a=e.target;r.bind("vmouseup",t).bind("vclick",o),d.bind("vmousecancel",n),i=setTimeout(function(){l.event.special.tap.emitTapOnTaphold||(u=!0),c(s,"taphold",l.Event("taphold",{target:a}))},l.event.special.tap.tapholdThreshold)})},teardown:function(){l(this).unbind("vmousedown").unbind("vclick").unbind("vmouseup"),d.unbind("vmousecancel")}},l.event.special.swipe={scrollSupressionThreshold:30,durationThreshold:1e3,horizontalDistanceThreshold:30,verticalDistanceThreshold:30,getLocation:function(e){var t=a.pageXOffset,n=a.pageYOffset,o=e.clientX,i=e.clientY;return 0===e.pageY&&Math.floor(i)>Math.floor(e.pageY)||0===e.pageX&&Math.floor(o)>Math.floor(e.pageX)?(o-=t,i-=n):(i<e.pageY-n||o<e.pageX-t)&&(o=e.pageX-t,i=e.pageY-n),{x:o,y:i}},start:function(e){var t=e.originalEvent.touches?e.originalEvent.touches[0]:e,n=l.event.special.swipe.getLocation(t);return{time:(new Date).getTime(),coords:[n.x,n.y],origin:l(e.target)}},stop:function(e){var t=e.originalEvent.touches?e.originalEvent.touches[0]:e,n=l.event.special.swipe.getLocation(t);return{time:(new Date).getTime(),coords:[n.x,n.y]}},handleSwipe:function(e,t,n,o){if(t.time-e.time<l.event.special.swipe.durationThreshold&&Math.abs(e.coords[0]-t.coords[0])>l.event.special.swipe.horizontalDistanceThreshold&&Math.abs(e.coords[1]-t.coords[1])<l.event.special.swipe.verticalDistanceThreshold){var i=e.coords[0]>t.coords[0]?"swipeleft":"swiperight";return c(n,"swipe",l.Event("swipe",{target:o,swipestart:e,swipestop:t}),!0),c(n,i,l.Event(i,{target:o,swipestart:e,swipestop:t}),!0),!0}return!1},eventInProgress:!1,setup:function(){var e,a=this,t=l(a),s={};(e=l.data(this,"mobile-events"))||(e={length:0},l.data(this,"mobile-events",e)),e.length++,(e.swipe=s).start=function(e){if(!l.event.special.swipe.eventInProgress){l.event.special.swipe.eventInProgress=!0;var t,n=l.event.special.swipe.start(e),o=e.target,i=!1;s.move=function(e){n&&!e.isDefaultPrevented()&&(t=l.event.special.swipe.stop(e),i||(i=l.event.special.swipe.handleSwipe(n,t,a,o))&&(l.event.special.swipe.eventInProgress=!1),Math.abs(n.coords[0]-t.coords[0])>l.event.special.swipe.scrollSupressionThreshold&&e.preventDefault())},s.stop=function(){i=!0,l.event.special.swipe.eventInProgress=!1,d.off(h,s.move),s.move=null},d.on(h,s.move).one(u,s.stop)}},t.on(n,s.start)},teardown:function(){var e,t;(e=l.data(this,"mobile-events"))&&(t=e.swipe,delete e.swipe,e.length--,0===e.length&&l.removeData(this,"mobile-events")),t&&(t.start&&l(this).off(n,t.start),t.move&&d.off(h,t.move),t.stop&&d.off(u,t.stop))}},l.each({scrollstop:"scrollstart",taphold:"tap",swipeleft:"swipe.left",swiperight:"swipe.right"},function(e,t){l.event.special[e]={setup:function(){l(this).bind(t,l.noop)},teardown:function(){l(this).unbind(t)}}})}(e,this)});