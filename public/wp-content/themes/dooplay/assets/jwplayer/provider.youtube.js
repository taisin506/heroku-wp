webpackJsonpjwplayer([6],{79:function(t,e,i){var n,a;n=[i(2),i(28),i(1),i(4),i(6),i(19),i(17),i(3)],a=function(t,e,i,n,a,o,r,u){function l(d,f){function y(){window.YT&&window.YT.loaded?(_=window.YT,v()):setTimeout(y,100)}function h(){s&&(s.off(),s=null)}function E(){var t=Q&&Q.parentNode;return t?t:(k||(window.jwplayer(d).onReady(v),k=!0),!1)}function v(){_&&E()&&F&&F.apply(N)}function g(){if(Y&&Y.getPlayerState){var t=Y.getPlayerState();null!==t&&void 0!==t&&t!==J&&M({data:t});var e=_.PlayerState;t===e.PLAYING?L():t===e.BUFFERING&&A()}}function p(t){return Math.round(10*t)/10}function L(){A(),N.trigger(n.JWPLAYER_MEDIA_TIME,{position:p(Y.getCurrentTime()),duration:Y.getDuration()})}function A(){var t=0;Y&&Y.getVideoLoadedFraction&&(t=Math.round(100*Y.getVideoLoadedFraction())),O!==t&&(O=t,N.trigger(n.JWPLAYER_MEDIA_BUFFER,{bufferPercent:t}))}function P(){N.state!==a.IDLE&&N.state!==a.COMPLETE&&(U=!0,N.trigger(n.JWPLAYER_MEDIA_BEFORECOMPLETE),N.setState(a.COMPLETE),U=!1,N.trigger(n.JWPLAYER_MEDIA_COMPLETE))}function m(){N.trigger(n.JWPLAYER_MEDIA_META,{duration:Y.getDuration(),width:Q.clientWidth,height:Q.clientHeight})}function D(){var t=arguments,e=t.length-1;return function(){for(var i=e,n=t[e].apply(this,arguments);i--;)n=t[i].call(this,n);return n}}function I(t,e){if(!t)throw"invalid Youtube ID";var n=Q.parentNode;if(n){var a={height:"100%",width:"100%",videoId:t,playerVars:i.extend({html5:1,autoplay:0,controls:0,showinfo:0,rel:0,modestbranding:0,playsinline:1,origin:location.protocol+"//"+location.hostname},e),events:{onReady:b,onStateChange:M,onPlaybackQualityChange:S,onError:T}};N.setVisibility(!0),Y=new _.Player(Q,a),Q=Y.getIframe(),F=null}}function b(){W&&(W.apply(N),W=null)}function M(e){var o=_.PlayerState;switch(J=e.data){case o.UNSTARTED:return void(t.isAndroid()&&Y.playVideo());case o.ENDED:return void P();case o.PLAYING:return i.isFunction(Y.unloadModule)&&Y.unloadModule("captions"),x=!1,m(),N.trigger(n.JWPLAYER_MEDIA_LEVELS,{levels:N.getQualityLevels(),currentQuality:N.getCurrentQuality()}),void N.setState(a.PLAYING);case o.PAUSED:return void N.setState(a.PAUSED);case o.BUFFERING:return void(N.seeking?N.setState(a.LOADING):N.setState(a.STALLED));case o.CUED:return N.setState(a.IDLE),void(t.isAndroid()&&Y.playVideo())}}function S(){J!==_.PlayerState.ENDED&&N.play(),N.trigger(n.JWPLAYER_MEDIA_LEVEL_CHANGED,{currentQuality:N.getCurrentQuality(),levels:N.getQualityLevels()})}function T(){N.trigger(n.JWPLAYER_MEDIA_ERROR,{message:"Error loading YouTube: Video could not be played"})}function w(){c&&N.setVisibility(!0)}function C(){clearInterval(G),Y&&Y.stopVideo&&t.tryCatch(function(){Y.stopVideo(),Y.clearVideo()})}function V(e){W=null;var i=e.sources[0].file,n=t.youTubeID(i);if(N.volume(f.volume),N.mute(f.mute),N.setVisibility(!0),!_||!Y)return F=function(){I(n)},void y();if(!Y.getPlayerState){var a=function(){N.load(e)};return void(W=W?D(a,W):a)}var o=Y.getVideoData(),r=o&&o.video_id;if(r!==n){x?(C(),Y.cueVideoById(n)):Y.loadVideoById(n);var u=Y.getPlayerState(),l=_.PlayerState;u!==l.UNSTARTED&&u!==l.CUED||w()}else Y.getCurrentTime()>0&&Y.seekTo(0),m()}this.state=a.IDLE,i.extend(this,u);var R,N=this,_=window.YT,Y=null,Q=document.createElement("div"),O=-1,k=!1,F=null,W=null,G=-1,J=-1,U=!1,x=c;this.setState=function(t){clearInterval(G),t!==a.IDLE&&t!==a.COMPLETE&&(G=setInterval(g,250),t===a.PLAYING?this.seeking=!1:t!==a.LOADING&&t!==a.STALLED||A()),r.setState.apply(this,arguments)},!_&&s&&s.getStatus()===o.loaderstatus.NEW&&(s.on(n.COMPLETE,y),s.on(n.ERROR,h),s.load()),Q.id=d+"_youtube",this.init=function(t){V(t)},this.destroy=function(){this.remove(),this.off(),R=Q=_=N=null},this.load=function(t){this.setState(a.LOADING),V(t),N.play()},this.stop=function(){C(),this.setState(a.IDLE)},this.play=function(){x||(Y&&Y.playVideo?Y.playVideo():W=W?D(this.play,W):this.play)},this.pause=function(){x||Y.pauseVideo&&Y.pauseVideo()},this.seek=function(t){x||Y.seekTo&&(this.seeking=!0,Y.seekTo(t))},this.volume=function(t){if(i.isNumber(t)){var e=Math.min(Math.max(0,t),100);Y&&Y.getVolume&&Y.setVolume(e)}},this.mute=function(e){var i=t.exists(e)?!!e:!f.mute;Y&&Y.mute&&(i?Y.mute():Y.unMute())},this.detachMedia=function(){return null},this.attachMedia=function(){U&&(this.setState(a.COMPLETE),this.trigger(n.JWPLAYER_MEDIA_COMPLETE),U=!1)},this.setContainer=function(t){R=t,t.appendChild(Q),this.setVisibility(!0)},this.getContainer=function(){return R},this.remove=function(){C(),Q&&R&&R===Q.parentNode&&R.removeChild(Q),F=W=Y=null},this.setVisibility=function(t){t=!!t,t?(e.style(Q,{display:"block"}),e.style(R,{visibility:"visible",opacity:1})):c||e.style(R,{opacity:0})},this.resize=function(){return!1},this.checkComplete=function(){return U},this.getCurrentQuality=function(){if(!Y)return-1;if(Y.getAvailableQualityLevels){var t=Y.getPlaybackQuality(),e=Y.getAvailableQualityLevels();return e.indexOf(t)}return-1},this.getQualityLevels=function(){if(Y){if(!i.isFunction(Y.getAvailableQualityLevels))return[];var t=Y.getAvailableQualityLevels();if(2===t.length&&i.contains(t,"auto"))return{label:i.without(t,"auto")};var e=i.map(t,function(t){return{label:t}});return e.reverse()}},this.setCurrentQuality=function(t){if(Y&&Y.getAvailableQualityLevels){var e=Y.getAvailableQualityLevels();if(e.length){var i=e[e.length-t-1];Y.setPlaybackQuality(i)}}},this.getName=l.getName}var s=new o(window.location.protocol+"//www.youtube.com/iframe_api"),c=t.isMobile();return l.getName=function(){return{name:"youtube"}},l.register=function(t){t.api.registerProvider(l)},l}.apply(e,n),!(void 0!==a&&(t.exports=a))}});