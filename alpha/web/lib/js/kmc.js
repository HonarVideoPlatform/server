
(function($){$.fn.wresize=function(f){version='1.1';wresize={fired:false,width:0};function resizeOnce(){if($.browser.msie){if(!wresize.fired){wresize.fired=true}else{var version=parseInt($.browser.version,10);wresize.fired=false;if(version<7){return false}else if(version==7){var width=$(window).width();if(width!=wresize.width){wresize.width=width;return false}}}}return true}function handleWResize(e){if(resizeOnce()){return f.apply(this,[e])}}this.each(function(){if(this==window){$(this).resize(handleWResize)}else{$(this).resize(f)}});return this}})(jQuery);$(function(){kmc.mediator.setState(kmc.mediator.readUrlHash());kmc.utils.activateHeader(true);$(window).wresize(kmc.utils.resize);kmc.modules.isLoadedInterval=setInterval("kmc.utils.isModuleLoaded()",200);});kmc.vars.default_kdp={uiconf_id:48507,width:400,height:333,swf_version:"v3.1.6"},kmc.functions={expired:function(){window.location=kmc.vars.service_url+"/index.php/kmc/kmc"+location.hash;},doNothing:function(){return false;},closeEditor:function(saved){if(saved==0){var myConfirm=confirm("Exit without saving?\n\n - Click [OK] to close editor\n\n - Click [Cancel] to remain in editor\n\n");if(myConfirm){kalturaCloseModalBox();}
else{return false;}}},saveEditor:function(){kalturaCloseModalBox();},openKcw:function(hs,conversion_profile){conversion_profile=conversion_profile||"";modal=kalturaInitModalBox(null,{width:700,height:360});modal.innerHTML='<div id="kcw"></div>';var flashvars={host:kmc.vars.host,cdnhost:kmc.vars.cdn_host,userId:kmc.vars.user_id,partnerid:kmc.vars.partner_id,subPartnerId:kmc.vars.subp_id,sessionId:kmc.vars.hs,devFlag:"true",entryId:"-1",hshow_id:"-1",terms_of_use:kmc.vars.terms_of_use,close:kmc.functions.onCloseKcw,quick_edit:0,kvar_conversionQuality:conversion_profile};var params={allowscriptaccess:"always",allownetworking:"all",bgcolor:"#DBE3E9",quality:"high",wmode:"opaque",movie:kmc.vars.service_url+"/kcw/ui_conf_id/48613"};swfobject.embedSWF(params.movie,"kcw","680","400","9.0.0",false,flashvars,params);setObjectToRemove("kaltura_cw");},onCloseKcw:function(){kalturaCloseModalBox();modal=null;kmc.vars.kcw_open=false;},closeHSE:function(){}}
kmc.utils={activateHeader:function(on){if(on){$("a").click(function(e){var go_to,tab=(e.target.tagName=="A")?e.target.id:e.target.innerHTML;switch(tab){case"Dashboard":go_to={module:"dashboard",subtab:""};break;case"Content":go_to={module:"content",subtab:"Manage"};break;case"Studio":case"Appstudio":go_to={module:"appstudio",subtab:"players_list"};break;case"Settings":go_to={module:"Settings",subtab:"Account_Settings"};break;case"Analytics":go_to={module:"reports",subtab:"Bandwidth Usage Reports"};break;case"Quickstart Guide":return true;case"Logout":kmc.utils.logout();return false;case"Support":kmc.utils.openSupport(this);default:return false;}
kmc.mediator.setState(go_to);return false;});}},openSupport:function(href){kalturaCloseModalBox();var modal_width=$.browser.msie?543:519;var iframe_height=$.browser.msie?751:($.browser.safari?697:732);modal=kalturaInitModalBox(null,{width:modal_width,height:450});modal.innerHTML='<div id="modal"><div id="titlebar"><a id="close" href="#close" onclick="kalturaCloseModalBox(); return false;"></a>'+'<b>Support Request</b></div> <div id="modal_content"><iframe id="support" src="'+href+'" scrolling="no" frameborder="0"'+'marginheight="0" marginwidth="0" height="'+iframe_height+'" width="519"></iframe></div></div>';$("#mbContent").addClass("new");return false;},mergeJson:function(){var i,args=arguments.length,primaryObject=arguments[0];for(var j=1;j<args;j++){var jsonObj=arguments[j];for(i in jsonObj){primaryObject[i]=jsonObj[i];}}
return primaryObject;},jsonToQuerystring:function(jsonObj,joiner){var i,myString="";if(typeof joiner=="undefined")
var joiner="&";for(i in jsonObj){myString+=i+"="+jsonObj[i]+joiner;}
return myString;},logout:function(){var expiry=new Date("January 1, 1970");expiry=expiry.toGMTString();document.cookie="pid=; expires="+expiry+"; path=/";document.cookie="subpid=; expires="+expiry+"; path=/";document.cookie="uid=; expires="+expiry+"; path=/";document.cookie="kmchs=; expires="+expiry+"; path=/";document.cookie="screen_name=; expires="+expiry+"; path=/";document.cookie="email=; expires="+expiry+"; path=/";var state=kmc.mediator.readUrlHash();$.ajax({	url: location.protocol + "//" + location.hostname + "/index.php/kmc/logout",	type: "POST",	data: { "hs": kmc.vars.hs },	dataType: "json",	complete: function(data) {		window.location = kmc.vars.service_url + "/index.php/kmc/kmc#" + state.module + "|" + state.subtab;	}});},copyCode:function(){$("#copy_msg").show();setTimeout(function(){$("#copy_msg").hide(500);},1500)
$(" textarea#embed_code").select();},resize:function(){var doc_height=$(document).height(),offset=37;$("#flash_wrap").height(doc_height-offset);$("#server_wrap iframe").height(doc_height-offset);},escapeQuotes:function(string){string=string.replace(/"/g,"&Prime;");string=string.replace(/'/g,"&prime;");return string;},isModuleLoaded:function(){if($("#flash_wrap object").length||$("#flash_wrap embed").length){kmc.utils.resize();clearInterval(kmc.modules.isLoadedInterval);kmc.modules.isLoadedInterval=null;}},debug:function(){try{console.info(" hs: ",kmc.vars.hs);console.info(" partner_id: ",kmc.vars.partner_id);}
catch(err){}}()}
kmc.mediator={setState:function(go_to){if(!go_to){go_to=kmc.vars.next_state;kmc.vars.next_state=null;}
if(go_to.subtab=="uploadKMC"){kmc.functions.openKcw();kmc.vars.kcw_open=true;go_to.subtab="Upload";}
if(go_to.subtab.toLowerCase()=="publish")
go_to.subtab="Playlists";if(!kmc.vars.kcw_open){kalturaCloseModalBox();}
kmc.mediator.setTab(go_to.module);kmc.mediator.writeUrlHash(go_to.module,go_to.subtab);kmc.mediator.loadModule(go_to.module,go_to.subtab);},loadModule:function(module,subtab){window.kmc_module=null;module=module.toLowerCase();if(module=="account")
module="settings";subtab=subtab.replace(/ /g,"%20");var module_url={data:eval("kmc.modules."+module+".swf_url")};var attributes=kmc.utils.mergeJson(kmc.modules.shared.attributes,module_url);var flashvars=kmc.utils.mergeJson(kmc.modules.shared.flashvars,eval("kmc.modules."+module+".flashvars"),{subNavTab:subtab});flashvars={flashvars:kmc.utils.jsonToQuerystring(flashvars)};var params=kmc.utils.mergeJson(kmc.modules.shared.params,flashvars);params.wmode=(module=="reports")?"window":"opaque";window.kmc_module=swfobject.createSWF(attributes,params,"kcms");$("#kcms").css("visibility","visible");},writeUrlHash:function(module,subtab){if(module=="account")
module="Settings";location.hash=module+"|"+subtab;document.title="KMC > "+module.charAt(0).toUpperCase()+module.slice(1)+((subtab&&subtab!="")?" > "+subtab+" |":"");},setTab:function(module){if(module=="reports"){module="Analytics";}
else if(module=="account"){module="Settings";}
else{module=module.substring(0,1).toUpperCase()+module.substring(1);}
$("#kmcHeader ul li a").removeClass("active");$("a#"+module).addClass("active");},readUrlHash:function(){var module="dashboard",subtab="";try{var hash=location.hash.split("#")[1].split("|");}
catch(err){var nohash=true;}
if(!nohash&&hash[0]!=""){module=hash[0];subtab=hash[1];}
return{"module":module,"subtab":subtab};},selectContent:function(uiconf_id,is_playlist){var subtab=is_playlist?"Playlists":"Manage";kmc.vars.current_uiconf={"uiconf_id":uiconf_id,"is_playlist":is_playlist};kmc.mediator.setState({module:"content",subtab:subtab});}}
kmc.modules={shared:{attributes:{height:"100%",width:"100%"},params:{allowScriptAccess:"always",allowNetworking:"all",allowFullScreen:"false",bgcolor:"#F7F7F7",autoPlay:"true"},flashvars:{host:kmc.vars.host,cdnhost:kmc.vars.cdn_host,srvurl:"api_v3/index.php",partnerid:kmc.vars.partner_id,subpid:kmc.vars.subp_id,uid:kmc.vars.user_id,hs:kmc.vars.hs,entryId:"-1",hshowId:"-1",widget_id:"_"+kmc.vars.partner_id,urchinNumber:"UA-12055206-1"}},dashboard:{swf_url:kmc.vars.flash_dir+"/kmc/dashboard/"+kmc.vars.versions.dashboard+"/dashboard.swf",flashvars:{userName:kmc.vars.screen_name,firstLogin:kmc.vars.first_login}},content:{swf_url:kmc.vars.flash_dir+"/kmc/content/"+kmc.vars.versions.content+"/content.swf",flashvars:{moderationKDPVersion:"v3.1.6",drillDownKDPVersion:"v3.1.6",moderationUiconf:"48506",drilldownUiconf:"48503",refreshPlayerList:"refreshPlayerList",refreshPlaylistList:"refreshPlaylistList",openPlayer:"kmc.preview_embed.doPreviewEmbed",openPlaylist:"kmc.preview_embed.doPreviewEmbed",email:kmc.vars.email,visibleCT:kmc.vars.paying_partner,openCw:"kmc.functions.openKcw"}},appstudio:{swf_url:kmc.vars.flash_dir+"/kmc/appstudio/"+kmc.vars.versions.appstudio+"/applicationstudio.swf",playlist_url:'http%3A%2F%2F'+kmc.vars.host+'%2Findex.php%2Fpartnerservices2%2Fexecuteplaylist%3Fuid%3D%26partner_id%3D'+
kmc.vars.partner_id+'%26subp_id%3D'+kmc.vars.partner_id+'00%26format%3D8%26hs%3D%7Bhs%7D%26playlist_id%3D',flashvars:{entryId:"_KMCLOGO1","playlistAPI.kpl0Name":"playlist1","playlistAPI.kpl0Url":'',"playlistAPI.kpl1Name":"playlist2","playlistAPI.kpl1Url":'',inapplicationstudio:"true",kdpUrl:kmc.vars.flash_dir+"/kdp3/v3.1.6/kdp3.swf",servicesPath:"index.php/partnerservices2/",serverPath:"http://"+kmc.vars.host,partner_id:kmc.vars.partner_id,subp_id:kmc.vars.subp_id}},settings:{swf_url:kmc.vars.flash_dir+"/kmc/account/"+kmc.vars.versions.account+"/account.swf",flashvars:{email:kmc.vars.email,showUsage:kmc.vars.show_usage}},reports:{swf_url:kmc.vars.flash_dir+"/kmc/analytics/"+kmc.vars.versions.reports+"/ReportsAndAnalytics.swf",flashvars:{drillDownKdpVersion:"v3.1.6",drillDownKdpUiconf:48506,serverPath:kmc.vars.service_url}}}
kmc.utils.mergeJson(kmc.modules.appstudio.flashvars,{"playlistAPI.kpl0Url":kmc.modules.appstudio.playlist_url+"_KMCSPL1","playlistAPI.kpl1Url":kmc.modules.appstudio.playlist_url+"_KMCSPL2"});kmc.preview_embed={doPreviewEmbed:function(id,name,description,is_playlist,uiconf_id){if(id!="multitab_playlist"){name=kmc.utils.escapeQuotes(name);description=kmc.utils.escapeQuotes(description);if(kmc.vars.current_uiconf){if((is_playlist&&kmc.vars.current_uiconf.is_playlist)||(!is_playlist&&!kmc.vars.current_uiconf.is_playlist)){var uiconf_id=kmc.vars.current_uiconf.uiconf_id;}
kmc.vars.current_uiconf=null;}
if(!uiconf_id){var uiconf_id=is_playlist?kmc.vars.playlists_list[0].id:kmc.vars.players_list[0].id;}
if(uiconf_id>799&&uiconf_id<1000){kmc.vars.jw=true,jw_license_html='<strong>COMMERCIAL</strong>',jw_options_html='',jw_nomix_box_html=kmc.preview_embed.jw.showNoMix(false,"check");if(kmc.vars.jw_swf=="non-commercial.swf"){jw_license_html='<a href="http://creativecommons.org/licenses/by-nc-sa/3.0/" target="_blank" class="license tooltip"'+'title="With this license your player will show a JW Player watermark.  You may NOT use the non-commercial'+'JW Player on commercial sites such as: sites owned or operated by corporations, sites with advertisements,'+'sites designed to promote a product, service or brand, etc.  If you are not sure whether you need to '+'purchase a license, contact us.  You also may not use the AdSolution monetization plugin '+'(which lets you make money off your player).">NON-COMMERCIAL <img src="http://corp.kaltura.com/images/graphics/info.png" alt="show tooltip" />'+'</a>&nbsp;&bull;&nbsp;<a href="http://corp.kaltura.com/about/contact?subject=JW%20Player%20to%20commercial%20license&amp;'+'&amp;pid='+kmc.vars.partner_id+'&amp;name='+kmc.vars.screen_name+'&amp;email='+kmc.vars.email+'" target="_blank" class="license tooltip" '+'title="Go to the Contact Us page and call us or fill in our Contact form and we\'ll call you (opens in new window/ tab).">Upgrade '+'<img src="http://corp.kaltura.com/images/graphics/info.png" alt="show tooltip" /></a>';var jw_license_ads_html='<li>Requires <a href="http://corp.kaltura.com/about/contact?subject=JW%20Player%20to%20commercial%20license&amp;" '+'class="tooltip" title="With a Commercial license your player will not show the JW Player watermark and you will be '+'allowed to use the player on any site you want as well as use AdSolution (which lets you make money off your player)."'+'target="_blank">Commercial license <img src="http://corp.kaltura.com/images/graphics/info.png" alt="show tooltip" /></a></li>';}
jw_options_html='<div class="label">License Type:</div>\n<div class="description">'+jw_license_html+'</div>\n'+'<div class="label">AdSolution:</div><div class="description"> <input type="checkbox" id="AdSolution" '+'onclick="kmc.preview_embed.jw.adSolution()" onmousedown="kmc.vars.jw_chkbox_flag=true" /> Enable ads '+'in your videos.&nbsp; <a href="http://www.longtailvideo.com/referral.aspx?page=kaltura&ref=azbkefsfkqchorl" '+'target="_blank" class="tooltip" title="Go to the JW website to sign up for FREE or to learn more about '+'running in-stream ads in your player from Google AdSense for Video, ScanScout, YuMe and others. (opens '+'in new window/ tab)"> Free sign up... <img src="http://corp.kaltura.com/images/graphics/info.png" alt="'+'show tooltip" /></a><br />\n <ul id="ads_notes">\n  <li>Channel Code: <input onblur="'+'kmc.preview_embed.jw.adsChannel(this, \''+id+'\', \''+name+'\', \''+description+'\', '+(is_playlist||false)+', \''+uiconf_id+'\');" '+'type="text" id="adSolution_channel" value="" /> <button>Apply</button></li>\n'+(jw_license_ads_html||'')+'\n </ul>\n </div>\n';}}
var embed_code,preview_player,id_type=is_playlist?"Playlist "+(id=="multitab_playlist"?"Name":"ID"):"Entry ID",uiconf_details=kmc.preview_embed.getUiconfDetails(uiconf_id,is_playlist);if(kmc.vars.jw){embed_code=kmc.preview_embed.jw.buildJWEmbed(id,name,description,is_playlist,uiconf_id);preview_player=embed_code.replace('flvclipper','flvclipper/hs/'+kmc.vars.hs);}
else{embed_code=kmc.preview_embed.buildKalturaEmbed(id,name,is_playlist,uiconf_id);preview_player=embed_code.replace('{FLAVOR}','hs='+kmc.vars.hs+'&');embed_code=embed_code.replace('{FLAVOR}','');}
var modal_html='<div id="modal"><div id="titlebar"><a id="close" href="#close" onclick="kalturaCloseModalBox(); return false;"></a>'+'<a id="help" target="_blank" href="'+kmc.vars.service_url+'/index.php/kmc/help#contentSection118"></a>'+id_type+': '+id+'</div> <div id="modal_content">'+
(id=="multitab_playlist"?'':kmc.preview_embed.buildSelect(id,name,description,is_playlist,uiconf_id))+
(kmc.vars.jw?jw_nomix_box_html:'')+'<div id="player_wrap">'+preview_player+'</div>'+
(kmc.vars.jw?jw_options_html:kmc.preview_embed.buildRtmpOptions())+'<div class="label">Embed Code:</div> <textarea id="embed_code" rows="5" cols="" onclick="kmc.utils.copyCode();"'+'readonly="true" style="width:'+(parseInt(uiconf_details.width)-10)+'px;">'+embed_code+'</textarea>'+'<div id="copy_msg">Press Ctrl+C to copy embed code (Command+C on Mac)</div><button id="select_code" onclick="kmc.utils.copyCode();">'+'<span>Select Code</span></button></div></div>';kmc.vars.jw=false;kalturaCloseModalBox();modal=kalturaInitModalBox(null,{width:parseInt(uiconf_details.width)+20,height:parseInt(uiconf_details.height)+200});modal.innerHTML=modal_html;$("#mbContent").addClass("new");$("#delivery_type").change(function(){kmc.vars.embed_code_delivery_type=this.value;kmc.preview_embed.doPreviewEmbed(id,name,description,is_playlist,uiconf_id);});},buildRtmpOptions:function(){var selected=' selected="selected"';var delivery_type=kmc.vars.embed_code_delivery_type||"http";var html='<div id="rtmp" class="label">Delivery Type:</div> <select id="delivery_type">';var options='<option value="http"'+((delivery_type=="http")?selected:"")+'>Progressive Download (HTTP)&nbsp;</option>'+'<option value="rtmp"'+((delivery_type=="rtmp")?selected:"")+'>Adaptive Streaming (RTMP)&nbsp;</option>';html+=options+'</select>';return html;},doFlavorPreview:function(entry_id,entry_name,flavor_details){entry_name=kmc.utils.escapeQuotes(entry_name);kalturaCloseModalBox();modal=kalturaInitModalBox(null,{width:parseInt(kmc.vars.default_kdp.width)+20,height:parseInt(kmc.vars.default_kdp.height)+10});$("#mbContent").addClass("new");var player_code=kmc.preview_embed.buildKalturaEmbed(entry_id,entry_name,false,kmc.vars.default_kdp);player_code=player_code.replace('&{FLAVOR}','&flavorId='+flavor_details.asset_id+'&hs='+kmc.vars.hs);var modal_html='<div id="modal"><div id="titlebar"><a id="close" href="#close" onclick="kalturaCloseModalBox(); return false;"></a>'+'Flavor Preview</div>'+'<div id="modal_content">'+player_code+'<dl>'+'<dt>Entry Name:</dt><dd>&nbsp;'+entry_name+'</dd>'+'<dt>Entry Id:</dt><dd>&nbsp;'+entry_id+'</dd>'+'<dt>Flavor Name:</dt><dd>&nbsp;'+flavor_details.flavor_name+'</dd>'+'<dt>Flavor Asset Id:</dt><dd>&nbsp;'+flavor_details.asset_id+'</dd>'+'<dt>Bitrate:</dt><dd>&nbsp;'+flavor_details.bitrate+'</dd>'+'<dt>Codec:</dt><dd>&nbsp;'+flavor_details.codec+'</dd>'+'<dt>Dimensions:</dt><dd>&nbsp;'+flavor_details.dimensions.width+' x '+flavor_details.dimensions.height+'</dd>'+'<dt>Format:</dt><dd>&nbsp;'+flavor_details.format+'</dd>'+'<dt>Size (KB):</dt><dd>&nbsp;'+flavor_details.sizeKB+'</dd>'+'<dt>Status:</dt><dd>&nbsp;'+flavor_details.status+'</dd>'+'</dl></div></div>';modal.innerHTML=modal_html;},embed_code_template:{object_tag:'<object id="kaltura_player" name="kaltura_player" type="application/x-shockwave-flash" allowFullScreen="true" allowNetworking="all" '+'allowScriptAccess="always" height="{HEIGHT}" width="{WIDTH}" data="http://{HOST}/index.php/kwidget/cache_st/'+'{CACHE_ST}/wid/_{PARTNER_ID}/uiconf_id/{UICONF_ID}{ENTRY_ID}"><param name="allowFullScreen" value="true" />'+'<param name="allowNetworking" value="all" /><param name="allowScriptAccess" value="always" /><param name="bgcolor" '+'value="#000000" /><param name="flashVars" value="{FLASHVARS}&{FLAVOR}" /><param name="movie" value="http://{HOST}/index.php/kwidget/cache_st/'+'{CACHE_ST}/wid/_{PARTNER_ID}/uiconf_id/{UICONF_ID}{ENTRY_ID}" /><a href="http://corp.kaltura.com">'+'video platform</a> <a href="http://corp.kaltura.com/video_platform/video_management">video management</a> <a href="http://corp.kaltura.com/solutions/video_solution">video solutions</a> <a href="http://corp.kaltura.com/video_platform/video_publishing">video player</a></object>',playlist_flashvars:'playlistAPI.autoContinue=true&playlistAPI.autoInsert=true&playlistAPI.kpl0Name={PL_NAME}'+'&playlistAPI.kpl0Url=http%3A%2F%2F{HOST}%2Findex.php%2Fpartnerservices2%2Fexecuteplaylist%3Fuid%3D%26'+'partner_id%3D{PARTNER_ID}%26subp_id%3D{PARTNER_ID}00%26format%3D8%26hs%3D%7Bhs%7D%26playlist_id%3D{PLAYLIST_ID}'},buildKalturaEmbed:function(id,name,is_playlist,uiconf){var uiconf_id=uiconf.uiconf_id||uiconf,uiconf_details=(typeof uiconf=="object")?uiconf:kmc.preview_embed.getUiconfDetails(uiconf_id,is_playlist),cache_st=kmc.preview_embed.setCacheStartTime(),embed_code;embed_code=kmc.preview_embed.embed_code_template.object_tag;if(!kmc.vars.jw){kmc.vars.embed_code_delivery_type=kmc.vars.embed_code_delivery_type||"http";if(kmc.vars.embed_code_delivery_type=="rtmp"){embed_code=embed_code.replace("{FLASHVARS}","streamerType=rtmp&amp;streamerUrl=rtmp://rtmpakmi.kaltura.com/ondemand&amp;rtmpFlavors=1&{FLASHVARS}");}}
if(is_playlist&&id!="multitab_playlist"){embed_code=embed_code.replace(/{ENTRY_ID}/g,"");embed_code=embed_code.replace("{FLASHVARS}",kmc.preview_embed.embed_code_template.playlist_flashvars);if(uiconf_details.swf_version.indexOf("v3")==-1){embed_code=embed_code.replace("playlistAPI.autoContinue","k_pl_autoContinue");embed_code=embed_code.replace("playlistAPI.autoInsert","k_pl_autoInsertMedia");embed_code=embed_code.replace("playlistAPI.kpl0Name","k_pl_0_name");embed_code=embed_code.replace("playlistAPI.kpl0Url","k_pl_0_url");}}
else{embed_code=embed_code.replace(/{ENTRY_ID}/g,(is_playlist?'':'/entry_id/'+id));embed_code=embed_code.replace("{FLASHVARS}","");}
embed_code=embed_code.replace("{ENTRY_ID}",(is_playlist?'-1':id));embed_code=embed_code.replace("{HEIGHT}",uiconf_details.height);embed_code=embed_code.replace("{WIDTH}",uiconf_details.width);embed_code=embed_code.replace(/{HOST}/gi,kmc.vars.host);embed_code=embed_code.replace(/{CACHE_ST}/gi,cache_st);embed_code=embed_code.replace(/{UICONF_ID}/gi,uiconf_id);embed_code=embed_code.replace(/{PARTNER_ID}/gi,kmc.vars.partner_id);embed_code=embed_code.replace("{PLAYLIST_ID}",id);embed_code=embed_code.replace("{PL_NAME}",name);embed_code=embed_code.replace(/{SERVICE_URL}/gi,kmc.vars.service_url);return embed_code;},buildSelect:function(id,name,description,is_playlist,uiconf_id){uiconf_id=kmc.vars.current_uiconf||uiconf_id;var list_type=is_playlist?"playlist":"player",list_length=eval("kmc.vars."+list_type+"s_list.length"),html_select='<select onchange="kmc.preview_embed.doPreviewEmbed(\''+id+'\',\''+name+'\',\''+description+'\','+is_playlist+', this.value)">',this_uiconf,selected;for(var i=0;i<list_length;i++){this_uiconf=eval("kmc.vars."+list_type+"s_list["+i+"]"),selected=(this_uiconf.id==uiconf_id)?' selected="selected"':'';html_select+='<option '+selected+' value="'+this_uiconf.id+'">'+this_uiconf.name+'</option>';}
html_select+='</select>';kmc.vars.current_uiconf=null;return html_select;},getUiconfDetails:function(uiconf_id,is_playlist){var i,uiconfs_array=is_playlist?kmc.vars.playlists_list:kmc.vars.players_list;for(i in uiconfs_array){if(uiconfs_array[i].id==uiconf_id){return uiconfs_array[i];break;}}
alert("getUiconfDetails error: uiconf_id "+uiconf_id+" not found in "+((is_playlist)?"kmc.vars.playlists_list":"kmc.vars.players_list"));return false;},setCacheStartTime:function(){var d=new Date;var y=d.getFullYear();var m=d.getMonth();var day=d.getDate();var h=d.getHours();var min=d.getMinutes();var s=d.getSeconds();var utc_offset=-5*60*60;var cache_st=Date.UTC(y,m,day,h,min,s)/1000;cache_st=cache_st-utc_offset+(15*60);return cache_st;},updateList:function(is_playlist){var type=is_playlist?"playlist":"player";$.ajax({url:kmc.vars.getuiconfs_url,type:"POST",data:{"type":type,"partner_id":kmc.vars.partner_id,"hs":kmc.vars.hs},dataType:"json",success:function(data){if(data&&data.length){if(is_playlist){kmc.vars.playlists_list=data;}
else{kmc.vars.players_list=data;}}}});},jw:{adSolution:function(){if($("#AdSolution").attr("checked")){$("#ads_notes").show();$("#adSolution_channel").focus();}
else{$("div.description ul").hide();$("#adSolution_channel").val("");}
kmc.vars.jw_chkbox_flag=false;},adsChannel:function(this_input,id,name,description,is_playlist,uiconf_id){if(this_input.value==""||this_input.value=="_"){if(!kmc.vars.jw_chkbox_flag){$("#AdSolution").attr("checked",false);}
$("div.description ul").hide();}
var embed_code=kmc.preview_embed.jw.buildJWEmbed(id,name,description,is_playlist,uiconf_id);$("#player_wrap").html(embed_code);$("#embed_code textarea").val(embed_code);},adsolutionSetup:function(start){var $adSolution_channel=$("#adSolution_channel");if(start)
if($adSolution_channel.val()=="")
$adSolution_channel.val("_");else
if($adSolution_channel.val()=="_")
$adSolution_channel.val("");},showNoMix:function(checkbox,action){if(checkbox){if($(checkbox).is(':checked'))
action="set";else
action="delete"}
switch(action){case"set":document.cookie="kmc_preview_show_nomix_box=true; ; path=/";$("#nomix_box").hide(250);break;case"delete":document.cookie="kmc_preview_show_nomix_box=true; expires=Sun, 01 Jan 2000 00:00:01 GMT; path=/";break;case"check":if(document.cookie.indexOf("kmc_preview_show_nomix_box")==-1)
var html='<div id="nomix_box"><p><strong>NOTE</strong>: '+'The JW Player does not work with Kaltura <dfn title="A Video Mix is a video made up of two or more '+'Entries, normally created through the Kaltura Editor.">Video Mixes</dfn>.</p>\n<div><input type="'+'checkbox" onclick="kmc.preview_embed.jw.showNoMix(this)"> Don\'t show this message again.</div></div>\n';else
var html='';break;default:alert("error: no action");return;}
return html;},buildJWEmbed:function(entry_id,name,description,is_playlist,uiconf_id){var uiconf_details=kmc.preview_embed.getUiconfDetails(uiconf_id,is_playlist);var width=uiconf_details.width;var height=uiconf_details.height;var playlist_type=uiconf_details.playlistType;var share=uiconf_details.share;var skin=uiconf_details.skin;var jw_flashvars='';var unique_id=new Date();unique_id=unique_id.getTime();var jw_plugins=new Array();if(!is_playlist||is_playlist=="undefined"){jw_flashvars+='file=http://'+kmc.vars.cdn_host+'/p/'+kmc.vars.partner_id+'/sp/'+kmc.vars.partner_id+'00/flvclipper/entry_id/'+entry_id+'/version/100000/ext/flv';jw_plugins.push("kalturastats");}
else{jw_flashvars+='file=http://'+kmc.vars.cdn_host+'/index.php/partnerservices2/executeplaylist%3Fuid%3D%26format%3D8%26playlist_id%3D'+
entry_id+'%26partner_id%3D'+kmc.vars.partner_id+'%26subp_id%3D'+kmc.vars.partner_id+'00%26hs%3D%7Bhs%7D'+'&playlist='+playlist_type;if(playlist_type!="bottom"){jw_flashvars+='&playlistsize=300';}}
if(share=="true"||share==true){jw_flashvars+='&viral.functions=embed,link&viral.onpause=false';jw_plugins.push("viral-2");}
var jw_ads={channel:$("#adSolution_channel").val()};if($("#AdSolution").is(":checked")&&jw_ads.channel!=""){jw_ads.flashvars='&ltas.cc='+jw_ads.channel+'&mediaid='+entry_id;jw_plugins.push("ltas");jw_ads.flashvars+="&title="+name+"&description="+description;jw_flashvars+=jw_ads.flashvars;}
var jw_skin=(skin=="undefined"||skin=="")?'':'&skin=http://'+kmc.vars.cdn_host+'/flash/jw/skins/'+skin;jw_flashvars=jw_flashvars+'&amp;image=http://'+kmc.vars.cdn_host+'/p/'+kmc.vars.partner_id+'/sp/'+kmc.vars.partner_id+'00/thumbnail/entry_id/'+entry_id+'/width/640/height/480'+jw_skin+'&widgetId=jw00000001&entryId='+
entry_id+'&partnerId='+kmc.vars.partner_id+'&uiconfId='+uiconf_id+'&plugins='+jw_plugins;var jw_embed_code='<div id="jw_wrap_'+unique_id+'"> <object width="'+width+'" height="'+height+'" id="jw_player_'+
unique_id+'" name="jw_player_'+unique_id+'">'+' <param name="movie" value="http://'+kmc.vars.cdn_host+'/flash/jw/player/'+kmc.vars.jw_swf+'" />'+' <param name="wmode" value="transparent" />'+' <param name="allowScriptAccess" value="always" />'+' <param name="flashvars" value="'+jw_flashvars+'" />'+' <embed id="jw_player__'+unique_id+'" name="jw_player__'+unique_id+'" src="http://'+
kmc.vars.cdn_host+'/flash/jw/player/'+kmc.vars.jw_swf+'" width="'+width+'" height="'+height+'" allowfullscreen="true" wmode="transparent" allowscriptaccess="always" '+'flashvars="'+jw_flashvars+'" /> <noembed><a href="http://www.kaltura.org/">Open Source Video</a></noembed> </object> </div>';return jw_embed_code;}}}
kmc.editors={start:function(entry_id,entry_name,editor_type,new_mix){if(new_mix){jQuery.ajax({url:kmc.vars.createmix_url,type:"POST",data:{"entry_id":entry_id,"entry_name":entry_name,"partner_id":kmc.vars.partner_id,"hs":kmc.vars.hs,"editor_type":editor_type,"user_id":kmc.vars.user_id},success:function(data){if(data&&data.length){kmc.editors.start(data,entry_name,editor_type,false);}}});return;}
switch(editor_type){case"1":case 1:var width="888";var height="544";var editor_uiconf=kmc.vars.hse_uiconf;kmc.editors.flashvars.entry_id=entry_id;break;case"2":case 2:var width="825";var height="672";var editor_uiconf=kmc.vars.kae_uiconf;kmc.editors.params.movie=kmc.vars.service_url+"/hse/ui_conf_id/"+kmc.vars.kae_uiconf;kmc.editors.flashvars.entry_id=entry_id;break;default:alert("error: switch=default");break;}
kmc.editors.flashvars.entry_id=entry_id;width=$.browser.msie?parseInt(width)+32:parseInt(width)+22;modal=kalturaInitModalBox(null,{width:width,height:height});modal.innerHTML='<div id="keditor"></div>';swfobject.embedSWF(kmc.vars.service_url+"/hse/ui_conf_id/"+editor_uiconf,"keditor",width,height,"9.0.0",false,kmc.editors.flashvars,kmc.editors.params);setObjectToRemove("keditor");},flashvars:{"uid":kmc.vars.user_id,"partner_id":kmc.vars.partner_id,"subp_id":kmc.vars.subp_id,"hs":kmc.vars.hs,"hshow_id":"-1","backF":"kmc.functions.closeEditor","saveF":"kmc.functions.saveEditor","terms_of_use":kmc.vars.terms_of_use,"jsDelegate":"kmc.editors.kae_functions"},params:{allowscriptaccess:"always",allownetworking:"all",bgcolor:"#ffffff",quality:"high",wmode:"opaque",movie:kmc.vars.service_url+"/hse/ui_conf_id/"+kmc.vars.hse_uiconf},kae_functions:{closeHandler:function(obj){kalturaCloseModalBox();},publishHandler:kmc.functions.doNothing,publishFailHandler:kmc.functions.doNothing,connectVoiceRecorderFailHandler:kmc.functions.doNothing,getMicrophoneVoiceRecorderFailHandler:kmc.functions.doNothing,initializationFailHandler:kmc.functions.doNothing,initKalturaApplicationFailHandler:kmc.functions.doNothing,localeFailHandler:kmc.functions.doNothing,skinFailHandler:kmc.functions.doNothing,getUiConfFailHandler:kmc.functions.doNothing,getPluginsProviderFailHandler:kmc.functions.doNothing,openVoiceRecorderHandler:kmc.functions.doNothing,connectVoiceRecorderHandler:kmc.functions.doNothing,startRecordingHandler:kmc.functions.doNothing,recorderCancelHandler:kmc.functions.doNothing,contributeVoiceRecordingHandler:kmc.functions.doNothing,openContributionWizardHandler:kmc.functions.doNothing,contributeEntriesHandler:kmc.functions.doNothing,addTransitionHandler:kmc.functions.doNothing,trimTransitionHandler:kmc.functions.doNothing,addPluginHandler:kmc.functions.doNothing,pluginFlagClickHandler:kmc.functions.doNothing,pluginEditHandler:kmc.functions.doNothing,pluginTrimHandler:kmc.functions.doNothing,addAssetHandler:kmc.functions.doNothing,changeSolidColorHandler:kmc.functions.doNothing,trimAssetHandler:kmc.functions.doNothing,duplicateHandler:kmc.functions.doNothing,splitHandler:kmc.functions.doNothing,reorderStoryboardHandler:kmc.functions.doNothing,reorderTimelineHandler:kmc.functions.doNothing,removeHandler:kmc.functions.doNothing,zoomChangeHandler:kmc.functions.doNothing,kalturaLogoClickHandler:kmc.functions.doNothing,editVolumeLevelsButtonHandler:kmc.functions.doNothing,editVolumeLevelsChangeHandler:kmc.functions.doNothing,volumeOverallChangeHandler:kmc.functions.doNothing,emptyTimelinesHandler:kmc.functions.doNothing,showHelpHandler:kmc.functions.doNothing,showVersionsWindowHandler:kmc.functions.doNothing,sortMediaClipsHandler:kmc.functions.doNothing,filterMediaClipsHandler:kmc.functions.doNothing}},function expiredF(){kmc.utils.expired();}
function selectPlaylistContent(params){kmc.mediator.selectContent(params.playerId,params.isPlaylist);}
function logout(){kmc.utils.logout();}
function openEditor(entry_id,entry_name,editor_type,newmix){kmc.editors.start(entry_id,entry_name,editor_type,newmix);}
function refreshSWF(){var state=kmc.mediator.readUrlHash();kmc.mediator.loadModule(state.module,state.subtab);}
function openPlayer(emptystring,width,height,uiconf_id){kmc.preview_embed.doPreviewEmbed("multitab_playlist",null,null,true,uiconf_id);}
function playlistAdded(){kmc.preview_embed.updateList(true);}
function playerAdded(){kmc.preview_embed.updateList(false);}
function openPlaylist(){alert("openPlaylist");}
