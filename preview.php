<?
// src - url-путь к фото (обяз. параметр)
// w - ширина, h - высота
// mode: in - вписать, out - описать)
// strict: для in расширить до заданных размеров, для out - обрезать до заданных размеров
// color: для mode=in и strict - цвет заполнителя свободного места
// view: через запятую область видимой части при установленном strict, например - center,center
define('TMP_DIR',dirname(__FILE__).'/tmp');

$compression=array('jpg'=>100,'png'=>9);

function hexToRGB($c) {
    $l = strlen($c);
    $out=array();
    if($l == 3)
    {
        $out[0] = hexdec(substr($c, 0,1).substr($c, 0,1));
        $out[1] = hexdec(substr($c, 1,1).substr($c, 1,1));
        $out[2] = hexdec(substr($c, 2,1).substr($c, 2,1));
    }
    elseif($l == 6)
    {
        unset($out);
        $out[0] = hexdec(substr($c, 0,2));
        $out[1] = hexdec(substr($c, 2,2));
        $out[2] = hexdec(substr($c, 4,2));
    }
    return $out;
}

if (! isset($_REQUEST['src'])) {exit;}
$width=$_REQUEST['w'];
$height=$_REQUEST['h'];
$strict=(isset($_REQUEST['strict'])?true:false);
$view=explode(',',(isset($_REQUEST['view'])?$_REQUEST['view']:'center,center'));
$color=isset($_REQUEST['color'])?$_REQUEST['color']:'ffffff';
$src=$_REQUEST['src'];
if (isset($_REQUEST['mode'])) {$mode=$_REQUEST['mode'].'side';} else {$mode='inside';}
if ((strlen($src)>0) && (substr($src,0,1)!='/')) {$src='/'.$src;}

$preview_name=str_replace('/','_',substr($src,1));
$src=dirname(__FILE__).$src;
if (! file_exists($src)) {exit;}

$fn=md5(substr($preview_name,0,strrpos($preview_name, '.')).'_'.$width.'_'.$height.'_'.($strict?'1':'0').'_'.$view[0].$view[1].'_'.$color);
$ext=substr($preview_name,strrpos($preview_name, '.')+1);
if (file_exists(TMP_DIR.'/'.$fn.'.'.$ext)) {
    $path=TMP_DIR.'/'.$fn.'.'.$ext;
    $path=str_replace('\\','/',$path);
    header('location: ' . str_replace($_SERVER['DOCUMENT_ROOT'],'',$path));
    exit;
}
require_once('wideimage/WideImage.php');
    $res=WideImage::load($src)->resize($width,$height,$mode);
if (($strict) && ($width) & ($height)) {
    if ($mode=='inside') {
        $color=hexToRGB($color);
        $img_color = $res->allocateColor($color[0],$color[1],$color[2]);
        $res=$res->resizeCanvas($width,$height,$view[0], $view[1],$img_color);
    } else {
        $res=$res->crop($view[0], $view[1], $width, $height);
    }
}
$res->saveToFile(TMP_DIR.'/'.$fn.'.'.$ext,$compression[strtolower($ext)]);
$res->output(strtolower($ext),$compression[strtolower($ext)]);


?>