<?php
require_once(JPATH_SITE.'/functions-db.php');
require_once(JPATH_SITE.'/functions-content.php');
function getReferer($referer = '') { //ф-я определения реферального хвоста, возвращает объект со свойствами: url - ссылка, с которой перешли; text - запрос, по которому пришли
	if ($referer=='') {$referer=$_SERVER['HTTP_REFERER'];}
    if (stristr($referer, 'yandex.ru')) { $search = 'text='; $crawler = 'Yandex'; }
    if (stristr($referer, 'rambler.ru')) { $search = 'words='; $crawler = 'Rambler'; }
    if (stristr($referer, 'google.ru')) { $search = 'q='; $crawler = 'Google'; }
    if (stristr($referer, 'google.com')) { $search = 'q='; $crawler = 'Google'; }
    if (stristr($referer, 'mail.ru')) { $search = 'q='; $crawler = 'Mail.Ru'; }
    if (stristr($referer, 'bing.com')) { $search = 'q='; $crawler = 'Bing'; }
    if (stristr($referer, 'qip.ru')) { $search = 'query='; $crawler = 'QIP'; }
    if (isset($crawler)) {
        $phrase = urldecode($referer);
        eregi($search.'([^&]*)', $phrase.'&', $phrase2);
        $phrase = $phrase2[1];
    } else {$phrase='';}
    $result=null;
    $result->url=$referer;
    $result->text=$phrase;
    return $result;
}

function getPageSfx() { // получаем суффикс Joomla-страницы
    $menuitemid = JRequest::getInt( 'Itemid' );
    if ($menuitemid) {
        $menu = JSite::getMenu();
        return $menu->getParams( $menuitemid )->get('pageclass_sfx');
    }

}

function VKApiQuery($metode, $data) { //запрос к API вконтакте
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Opera/9.80 (J2ME/MIDP; Opera Mini/5.0.3521/886; U; en) Presto/2.4.15');
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = http_build_query($data);
    curl_setopt($ch, CURLOPT_URL, "https://api.vk.com/method/" . $metode . "?" . $data);
    $data = json_decode(curl_exec($ch), true);
    if (isset($data['error']))
        return array("status" => false, "error" => $data['error']['error_msg'], "error_code" => $data['error']['error_code']);
    return $data;
}

function CheckRoute($path) {
    //return $vars=array("Itemid"=> NULL, "valueid" => $data[0]->product_id, "option" => "com_jshopping", "controller" => "product", "task" => "view", "category_id" => "1", "product_id" => "5");
    return array();
}

function addLibrary($name,$options=null) {
    $app = JFactory::getApplication();
    $doc = JFactory::getDocument();
    $templatePath='templates/'.$app->getTemplate();
    switch($name) {
        case 'alert': // Красивые alert, prompt сообщения - http://t4t5.github.io/sweetalert/
            $doc->addStyleSheet($templatePath . '/lib/sweetalert/dist/sweetalert.css');
            if ($options!==null) {
                $doc->addStyleSheet($templatePath . '/lib/sweetalert/themes/'.$options.'/'.$options.'.css');
            }
            $doc->addScript($templatePath . '/lib/sweetalert/dist/sweetalert.min.js');
            break;
        case 'bootsrap': // Библиотека Bootstrap
            $doc->addStyleSheet('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css');
            $doc->addScript('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js');
            break;
        case 'uri': // Библиотека для удобной работы с URL (извлечение параметро, изменение URL и пр.)
            $doc->addScript($templatePath . '/lib/URI.min.js');
            break;
        case 'mxSlider': // Слайдер фото
            $doc->addScript($templatePath . '/lib/jquery.mxSlider.js');
            break;
        case 'mxAnalytics': // Яндекс Метрика и Google Analytics
            $doc->addScript($templatePath . '/lib/jquery.mxAnalytics.js');
            break;
        case 'wow': // Wow - библиотека CSS-анимаций http://mynameismatthieu.com/WOW/docs.html
            $doc->addStyleSheet($templatePath . '/lib/wow/css/libs/animate.css');
            $doc->addScript($templatePath . '/lib/wow/dist/wow.min.js');
            break;
        case 'hover': // Hover.css - css-анимация при наведении http://ianlunn.co.uk/articles/hover-css-tutorial-introduction/
            $doc->addStyleSheet($templatePath . '/lib/hover/css/hover-min.css');
            break;
        case 'sequence': // CSS animation framework (for creating sliders, presentations, banners, and other step-based applications) http://www.sequencejs.com/
            $doc->addScript($templatePath . '/lib/sequence/scripts/imagesloaded.pkgd.min.js');
            $doc->addScript($templatePath . '/lib/sequence/scripts/hammer.min.js');
            $doc->addScript($templatePath . '/lib/sequence/scripts/sequence.min.js');
            $doc->addScript($templatePath . '/lib/sequence/scripts/sequence-theme.basic.js');
            break;
        case 'lightbox2': // Lightbox 2 - http://lokeshdhakar.com/projects/lightbox2/
            $doc->addStyleSheet($templatePath . '/lib/lightbox2/dist/css/lightbox.min.css');
            $doc->addScript($templatePath . '/lib/lightbox2/dist/js/lightbox.min.js');
            break;
    }
}

?>