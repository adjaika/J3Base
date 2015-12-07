/*  
 * WidgetKit                 2.0.4
 * @package                 JCE
 * @url                     http://www.joomlacontenteditor.net
 * @copyright               Copyright (C) 2006 - 2012 Ryan Demmer. All rights reserved
 * @license                 GNU/GPL Version 2 - http://www.gnu.org/licenses/gpl-2.0.html
 * @date                    13 February 2013
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * NOTE : Javascript files have been compressed for speed and can be uncompressed using http://jsbeautifier.org/
 */
(function(){WFPopups.addPopup('widgetkit',{params:{lightbox_padding:'',lightbox_overlayShow:'',lightbox_transitionIn:'',lightbox_transitionOut:'',lightbox_titlePosition:''},setup:function(){$('#widgetkit_lightbox_width').change(function(){var w=$(this).val(),$height=$('#widgetkit_lightbox_height');if(w&&$height.val()){if($('#widgetkit_lightbox_constrain').is(':checked')){var tw=$(this).data('tmp'),h=$height.val();if(tw){var temp=((h/tw)*w).toFixed(0);$height.val(temp).data('tmp',temp);}}}
$(this).data('tmp',w);});$('#widgetkit_lightbox_height').change(function(){var h=$(this).val(),$width=$('#widgetkit_lightbox_width');if(h&&$width.val()){if($('#widgetkit_lightbox_constrain').is(':checked')){var th=$(this).data('tmp'),w=$width.val();if(th){var temp=((w/th)*h).toFixed(0);$width.val(temp).data('tmp',temp);}}}
$(this).data('tmp',h);});$.each(this.params,function(k,v){$('#widgetkit_'+k).val(v);});},check:function(n){return n.getAttribute('data-lightbox');},remove:function(n){var ed=tinyMCEPopup.editor;ed.dom.setAttrib(n,'data-lightbox','');},convertData:function(s){var a=[];$.each(s.split(';'),function(i,n){if(n){n=n.replace(/([\w]+):(.*)/,'"$1":"$2"');a.push(n);}});return $.parseJSON('{'+a.join(',')+'}');},getAttributes:function(n){var ed=tinyMCEPopup.editor,args={};var data=ed.dom.getAttrib(n,'data-lightbox');if(data&&data!=="on"){data=this.convertData(data);$.each(data,function(k,v){$('#widgetkit_lightbox_'+k).val(v);});}
$('#widgetkit_lightbox_title').val(ed.dom.getAttrib(n,'title'));var map=WFPopups.config.map||{'href':'src'};$.each(map,function(from,to){var href=ed.dom.getAttrib(n,from);href=href.replace(/(\?|&)tmpl=component/i,'');$('#'+to).val(href);args.src=href;});return args;},setAttributes:function(n,args){var ed=tinyMCEPopup.editor;this.remove(n);var data=[];tinymce.each(['group','width','height','transitionIn','transitionOut','titlePosition','overlayShow','padding','type'],function(k){var v=$('#widgetkit_lightbox_'+k).val();if(v==''||v==null){if(args[k]){v=args[k];}else{return;}}
data.push(k+':'+v);});if(args.data){$.each(args.data,function(k,v){data.push(k+':'+v);});}
var src=ed.dom.getAttrib(n,'href');if(/index\.php/.test(src)&&/:\/\//.test(src)===false){if(/\?/.test(src)){src+='&tmpl=component';}else{src+='?tmpl=component';}
ed.dom.setAttrib(n,'href',src);}
data=data.length?data.join(';'):'on';ed.dom.setAttrib(n,'data-lightbox',data);ed.dom.setAttrib(n,'title',$('#widgetkit_lightbox_title').val());ed.dom.setAttrib(n,'target','_blank');},onSelect:function(){},onSelectFile:function(args){}});})();