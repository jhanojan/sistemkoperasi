﻿/*
Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.skins.add('kama',(function(){var a=[];if(CKEDITOR.env.ie&&CKEDITOR.env.version<7)a.push('icons.png','images/sprites_ie6.png','images/dialog_sides.gif');return{preload:a,editor:{css:['editor.css']},dialog:{css:['dialog.css']},templates:{css:['templates.css']},margins:[0,0,0,0],init:function(b){var c;function d(f){if(!c)return null;var g=c.append('style'),h='/* UI Color Support */.cke_skin_kama .cke_menuitem .cke_icon_wrapper{\tbackground-color: $color !important;\tborder-color: $color !important;}.cke_skin_kama .cke_menuitem a:hover .cke_icon_wrapper,.cke_skin_kama .cke_menuitem a:focus .cke_icon_wrapper,.cke_skin_kama .cke_menuitem a:active .cke_icon_wrapper{\tbackground-color: $color !important;\tborder-color: $color !important;}.cke_skin_kama .cke_menuitem a:hover .cke_label,.cke_skin_kama .cke_menuitem a:focus .cke_label,.cke_skin_kama .cke_menuitem a:active .cke_label{\tbackground-color: $color !important;}.cke_skin_kama .cke_menuitem a.cke_disabled:hover .cke_label,.cke_skin_kama .cke_menuitem a.cke_disabled:focus .cke_label,.cke_skin_kama .cke_menuitem a.cke_disabled:active .cke_label{\tbackground-color: transparent !important;}.cke_skin_kama .cke_menuitem a.cke_disabled:hover .cke_icon_wrapper,.cke_skin_kama .cke_menuitem a.cke_disabled:focus .cke_icon_wrapper,.cke_skin_kama .cke_menuitem a.cke_disabled:active .cke_icon_wrapper{\tbackground-color: $color !important;\tborder-color: $color !important;}.cke_skin_kama .cke_menuitem a.cke_disabled .cke_icon_wrapper{\tbackground-color: $color !important;\tborder-color: $color !important;}.cke_skin_kama .cke_menuseparator{\tbackground-color: $color !important;}.cke_skin_kama .cke_menuitem a:hover,.cke_skin_kama .cke_menuitem a:focus,.cke_skin_kama .cke_menuitem a:active{\tbackground-color: $color !important;}';g.setAttribute('type','text/css');var i=/\$color/g;if(CKEDITOR.env.webkit){h=h.split('}').slice(0,-1);for(var j in h)h[j]=h[j].split('{');}return(d=function(k){if(CKEDITOR.env.webkit)for(var l in h)g.$.sheet.addRule(h[l][0],h[l][1].replace(i,k));else{var m=h.replace(i,k);if(CKEDITOR.env.ie)g.$.styleSheet.cssText=m;else g.setHtml(m);}})(f);};CKEDITOR.tools.extend(b,{uiColor:null,getUiColor:function(){return this.uiColor;},setUiColor:function(f){var g=CKEDITOR.document.getHead().append('style'),h='#cke_'+b.name.replace('.','\\.'),i=[h+' .cke_wrapper',h+'_dialog .cke_dialog_contents',h+'_dialog a.cke_dialog_tab',h+'_dialog .cke_dialog_footer'].join(','),j='background-color: $color !important;';g.setAttribute('type','text/css');
return(this.setUiColor=function(k){var l=j.replace('$color',k);b.uiColor=k;if(CKEDITOR.env.ie)g.$.styleSheet.cssText=i+'{'+l+'}';else if(CKEDITOR.env.webkit)g.$.sheet.addRule(i,l);else g.setHtml(i+'{'+l+'}');d(k);})(f);}});if(CKEDITOR.menu){var e=CKEDITOR.menu.prototype.show;CKEDITOR.menu.prototype.show=function(){e.apply(this,arguments);if(!c&&b==this.editor){c=this._.element.getDocument().getHead();d(b.getUiColor());}};}if(b.config.uiColor)b.setUiColor(b.config.uiColor);}};})());if(CKEDITOR.dialog)CKEDITOR.dialog.on('resize',function(a){var b=a.data,c=b.width,d=b.height,e=b.dialog,f=!CKEDITOR.env.quirks;if(b.skin!='kama')return;e.parts.contents.setStyles({width:c+'px',height:d+'px'});if(!CKEDITOR.env.ie)return;setTimeout(function(){var g=e.parts.contents,h=g.getParent(),i=h.getParent(),j=i.getChild(2);j.setStyle('width',h.$.offsetWidth+'px');j=i.getChild(7);j.setStyle('width',h.$.offsetWidth-28+'px');j=i.getChild(4);j.setStyle('height',h.$.offsetHeight-31-14+'px');j=i.getChild(5);j.setStyle('height',h.$.offsetHeight-31-14+'px');},100);});
