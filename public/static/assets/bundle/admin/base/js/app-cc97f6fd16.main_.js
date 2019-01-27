if("undefined"==typeof jQuery)throw new Error("AdminLTE requires jQuery");function _init(){"use strict";$.AdminLTE.layout={activate:function(){var e=this;e.fix(),e.fixSidebar(),$(window,".wrapper").resize(function(){e.fix(),e.fixSidebar()})},fix:function(){var e=$(".main-header").outerHeight()+$(".main-footer").outerHeight(),i=$(window).height(),o=$(".sidebar").height();if($("body").hasClass("fixed"))$(".content-wrapper, .right-side").css("min-height",i-$(".main-footer").outerHeight());else{var n;n=o<=i?($(".content-wrapper, .right-side").css("min-height",i-e),i-e):($(".content-wrapper, .right-side").css("min-height",o),o);var t=$($.AdminLTE.options.controlSidebarOptions.selector);void 0!==t&&t.height()>n&&$(".content-wrapper, .right-side").css("min-height",t.height())}},fixSidebar:function(){$("body").hasClass("fixed")?(void 0===$.fn.slimScroll&&window.console&&window.console.error("Error: the fixed layout requires the slimscroll plugin!"),$.AdminLTE.options.sidebarSlimScroll&&void 0!==$.fn.slimScroll&&($(".sidebar").slimScroll({destroy:!0}).height("auto"),$(".sidebar").slimscroll({height:$(window).height()-$(".main-header").height()+"px",color:"rgba(0,0,0,0.2)",size:"3px"}))):void 0!==$.fn.slimScroll&&$(".sidebar").slimScroll({destroy:!0}).height("auto")}},$.AdminLTE.pushMenu={activate:function(e){var i=$.AdminLTE.options.screenSizes;$(e).on("click",function(e){e.preventDefault(),$(window).width()>i.sm-1?$("body").hasClass("sidebar-collapse")?$("body").removeClass("sidebar-collapse").trigger("expanded.pushMenu"):$("body").addClass("sidebar-collapse").trigger("collapsed.pushMenu"):$("body").hasClass("sidebar-open")?$("body").removeClass("sidebar-open").removeClass("sidebar-collapse").trigger("collapsed.pushMenu"):$("body").addClass("sidebar-open").trigger("expanded.pushMenu")}),$(".content-wrapper").click(function(){$(window).width()<=i.sm-1&&$("body").hasClass("sidebar-open")&&$("body").removeClass("sidebar-open")}),($.AdminLTE.options.sidebarExpandOnHover||$("body").hasClass("fixed")&&$("body").hasClass("sidebar-mini"))&&this.expandOnHover()},expandOnHover:function(){var e=this,i=$.AdminLTE.options.screenSizes.sm-1;$(".main-sidebar").hover(function(){$("body").hasClass("sidebar-mini")&&$("body").hasClass("sidebar-collapse")&&$(window).width()>i&&e.expand()},function(){$("body").hasClass("sidebar-mini")&&$("body").hasClass("sidebar-expanded-on-hover")&&$(window).width()>i&&e.collapse()})},expand:function(){$("body").removeClass("sidebar-collapse").addClass("sidebar-expanded-on-hover")},collapse:function(){$("body").hasClass("sidebar-expanded-on-hover")&&$("body").removeClass("sidebar-expanded-on-hover").addClass("sidebar-collapse")}},$.AdminLTE.tree=function(e){var s=this,a=$.AdminLTE.options.animationSpeed;$(document).on("click",e+" li a",function(e){var i=$(this),o=i.next();if(o.is(".treeview-menu")&&o.is(":visible"))o.slideUp(a,function(){o.removeClass("menu-open")}),o.parent("li").removeClass("active");else if(o.is(".treeview-menu")&&!o.is(":visible")){var n=i.parents("ul").first();n.find("ul:visible").slideUp(a).removeClass("menu-open");var t=i.parent("li");o.slideDown(a,function(){o.addClass("menu-open"),n.find("li.active").removeClass("active"),t.addClass("active"),s.layout.fix()})}o.is(".treeview-menu")&&e.preventDefault()})},$.AdminLTE.controlSidebar={activate:function(){var i=this,o=$.AdminLTE.options.controlSidebarOptions,n=$(o.selector);$(o.toggleBtnSelector).on("click",function(e){e.preventDefault(),n.hasClass("control-sidebar-open")||$("body").hasClass("control-sidebar-open")?i.close(n,o.slide):i.open(n,o.slide)});var e=$(".control-sidebar-bg");i._fix(e),$("body").hasClass("fixed")?i._fixForFixed(n):$(".content-wrapper, .right-side").height()<n.height()&&i._fixForContent(n)},open:function(e,i){i?e.addClass("control-sidebar-open"):$("body").addClass("control-sidebar-open")},close:function(e,i){i?e.removeClass("control-sidebar-open"):$("body").removeClass("control-sidebar-open")},_fix:function(e){var i=this;$("body").hasClass("layout-boxed")?(e.css("position","absolute"),e.height($(".wrapper").height()),$(window).resize(function(){i._fix(e)})):e.css({position:"fixed",height:"auto"})},_fixForFixed:function(e){e.css({position:"fixed","max-height":"100%",overflow:"auto","padding-bottom":"50px"})},_fixForContent:function(e){$(".content-wrapper, .right-side").css("min-height",e.height())}},$.AdminLTE.boxWidget={selectors:$.AdminLTE.options.boxWidgetOptions.boxWidgetSelectors,icons:$.AdminLTE.options.boxWidgetOptions.boxWidgetIcons,animationSpeed:$.AdminLTE.options.animationSpeed,activate:function(e){var i=this;e||(e=document),$(e).on("click",i.selectors.collapse,function(e){e.preventDefault(),i.collapse($(this))}),$(e).on("click",i.selectors.remove,function(e){e.preventDefault(),i.remove($(this))})},collapse:function(e){var i=this,o=e.parents(".box").first(),n=o.find("> .box-body, > .box-footer, > form  >.box-body, > form > .box-footer");o.hasClass("collapsed-box")?(e.children(":first").removeClass(i.icons.open).addClass(i.icons.collapse),n.slideDown(i.animationSpeed,function(){o.removeClass("collapsed-box")})):(e.children(":first").removeClass(i.icons.collapse).addClass(i.icons.open),n.slideUp(i.animationSpeed,function(){o.addClass("collapsed-box")}))},remove:function(e){e.parents(".box").first().slideUp(this.animationSpeed)}}}$.AdminLTE={},$.AdminLTE.options={navbarMenuSlimscroll:!0,navbarMenuSlimscrollWidth:"3px",navbarMenuHeight:"200px",animationSpeed:500,sidebarToggleSelector:"[data-toggle='offcanvas']",sidebarPushMenu:!0,sidebarSlimScroll:!0,sidebarExpandOnHover:!1,enableBoxRefresh:!0,enableBSToppltip:!0,BSTooltipSelector:"[data-toggle='tooltip']",enableFastclick:!0,enableControlSidebar:!0,controlSidebarOptions:{toggleBtnSelector:"[data-toggle='control-sidebar']",selector:".control-sidebar",slide:!0},enableBoxWidget:!0,boxWidgetOptions:{boxWidgetIcons:{collapse:"fa-minus",open:"fa-plus",remove:"fa-times"},boxWidgetSelectors:{remove:'[data-widget="remove"]',collapse:'[data-widget="collapse"]'}},directChat:{enable:!0,contactToggleSelector:'[data-widget="chat-pane-toggle"]'},colors:{lightBlue:"#3c8dbc",red:"#f56954",green:"#00a65a",aqua:"#00c0ef",yellow:"#f39c12",blue:"#0073b7",navy:"#001F3F",teal:"#39CCCC",olive:"#3D9970",lime:"#01FF70",orange:"#FF851B",fuchsia:"#F012BE",purple:"#8E24AA",maroon:"#D81B60",black:"#222222",gray:"#d2d6de"},screenSizes:{xs:480,sm:768,md:992,lg:1200}},$(function(){"use strict";$("body").removeClass("hold-transition"),"undefined"!=typeof AdminLTEOptions&&$.extend(!0,$.AdminLTE.options,AdminLTEOptions);var e=$.AdminLTE.options;_init(),$.AdminLTE.layout.activate(),$.AdminLTE.tree(".sidebar"),e.enableControlSidebar&&$.AdminLTE.controlSidebar.activate(),e.navbarMenuSlimscroll&&void 0!==$.fn.slimscroll&&$(".navbar .menu").slimscroll({height:e.navbarMenuHeight,alwaysVisible:!1,size:e.navbarMenuSlimscrollWidth}).css("width","100%"),e.sidebarPushMenu&&$.AdminLTE.pushMenu.activate(e.sidebarToggleSelector),e.enableBSToppltip&&$("body").tooltip({selector:e.BSTooltipSelector}),e.enableBoxWidget&&$.AdminLTE.boxWidget.activate(),e.enableFastclick&&"undefined"!=typeof FastClick&&FastClick.attach(document.body),e.directChat.enable&&$(document).on("click",e.directChat.contactToggleSelector,function(){$(this).parents(".direct-chat").first().toggleClass("direct-chat-contacts-open")}),$('.btn-group[data-toggle="btn-toggle"]').each(function(){var i=$(this);$(this).find(".btn").on("click",function(e){i.find(".btn.active").removeClass("active"),$(this).addClass("active"),e.preventDefault()})})}),function(i){"use strict";i.fn.boxRefresh=function(e){var n=i.extend({trigger:".refresh-btn",source:"",onLoadStart:function(e){return e},onLoadDone:function(e){return e}},e),t=i('<div class="overlay"><div class="fa fa-refresh fa-spin"></div></div>');return this.each(function(){if(""!==n.source){var o=i(this);o.find(n.trigger).first().on("click",function(e){var i;e.preventDefault(),(i=o).append(t),n.onLoadStart.call(i),o.find(".box-body").load(n.source,function(){var e;(e=o).find(t).remove(),n.onLoadDone.call(e)})})}else window.console&&window.console.log("Please specify a source first - boxRefresh()")})}}(jQuery),function(e){"use strict";e.fn.activateBox=function(){e.AdminLTE.boxWidget.activate(this)}}(jQuery),function(o){"use strict";o.fn.todolist=function(e){var i=o.extend({onCheck:function(e){return e},onUncheck:function(e){return e}},e);return this.each(function(){void 0!==o.fn.iCheck?(o("input",this).on("ifChecked",function(){var e=o(this).parents("li").first();e.toggleClass("done"),i.onCheck.call(e)}),o("input",this).on("ifUnchecked",function(){var e=o(this).parents("li").first();e.toggleClass("done"),i.onUncheck.call(e)})):o("input",this).on("change",function(){var e=o(this).parents("li").first();e.toggleClass("done"),o("input",e).is(":checked")?i.onCheck.call(e):i.onUncheck.call(e)})})}}(jQuery);