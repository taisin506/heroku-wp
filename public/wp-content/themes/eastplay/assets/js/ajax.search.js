!function(f){var e=(function(){var a=0;return function(b,c){clearTimeout(a);a=setTimeout(b,c)}})();var d=false;enterActive=true;f('input[name="s"]').on("input",function(){var a=f(this).val();e(function(){if(a.length<=2){f(ajaxSearch.area).hide();f(ajaxSearch.button).find("span").removeClass("fa-spinner").removeClass("loading");return}if(!d){d=true;if(ajaxSearch.livesearchactive==true){f(ajaxSearch.button).find("span").addClass("fa-spinner").addClass("loading");f(ajaxSearch.area).find("ul").addClass("process").addClass("noselect");f.ajax({type:"GET",url:ajaxSearch.api,data:"keyword="+a+"&nonce="+ajaxSearch.nonce,dataType:"json",success:function(c){if(c.error){f(ajaxSearch.area).show();var j="<b>"+f(a).text()+"</b>",b=ajaxSearch.more.replace("%s",j),k='<li class="ctsx"><a href="'+ajaxSearch.url+"/?s="+a+' " class="more live_search_click" data-search="searchform">'+b+" "+j+"</a></li>";f(ajaxSearch.area).html("<ul><li><center><b>"+c.title+"</b></center></li>"+k+"</ul>")}else{f(ajaxSearch.area).show();var j="<b>"+f(a).text()+"</b>",b=ajaxSearch.more.replace("%s",j),k='<li class="ctsx"><a href="'+ajaxSearch.url+"/?s="+a+' " class="more live_search_click" data-search="searchform">'+b+" "+j+"</a></li>";var l=[];f.each(c,function(h,g){name="";genre="";score="";type="";season="";if(g.data.genre!==false){genre='<div class="genre">'+g.data.genre+"</div>"}if(g.data.type!==false){type='<i></i><span class="type">'+g.data.type+"</span>"}if(g.data.season!==undefined){season='<i></i><span class="type">'+g.data.season+"</span>"}if(g.data.score!==false){score='<div class="score"><span class="fa fa-star"></span> '+g.data.score+"</div>"}l.push('<li id="'+h+'"><a href="'+g.url+'" class="clearfix"><div class="poster"><img src="'+g.img+'" /></div><div class="info"><div class="title">'+g.title+"</div>"+score+type+season+"</div></a></li>")});f(ajaxSearch.area).html("<ul>"+l.join("")+k+"</ul>")}},complete:function(){d=false;enterActive=false;f(ajaxSearch.button).find("span").removeClass("fa-spinner").removeClass("loading");f(ajaxSearch.area).find("ul").removeClass("process").removeClass("noselect")}})}}},500)});f(document).on("keypress","#search-form",function(a){if(enterActive){return a.keyCode!=13}});f(document).click(function(){var a=f(event.target);if(f(event.target).closest('input[name="s"]').length==0){f(ajaxSearch.area).hide()}else{f(ajaxSearch.area).show()}})}(jQuery);
