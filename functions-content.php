<?

function mx_ending($num,$word,$ok_1,$ok_234,$ok_5){
    if ((strlen($num)==2) and (substr($num,0,1)=='1')){
        $num_last=$num;
    } else {
        $num_last=substr($num,strlen($num)-1);
    }
    if ($num_last=='1') {return $word.$ok_1;}
    if (in_array($num_last, array('2','3','4'))) {return $word.$ok_234;}
    if (($num_last==0) or (($num_last>=5) and ($num_last<=19))) {return $word.$ok_5;}
}

function removeTagP($s) { //удалить тэг P абзаца
    return str_replace('</p>', '', str_replace('<p>', '', $s));
}

function getP($s, $n) {
    $k=strpos($s,"<p");
    $i=0;
    while($k!==false) {
        $i++;
        if ($i==$n) {
            $k1=strpos($s,"<p", $k+1);
            $k2=strpos($s,"</p", $k+1);
            if ($k1>$k2) {$k3=$k2+4;} else {$k3=$k1;}
            if ($k1==false) {$k3=$k2+4;}
            if ($k2==false) {$k3=$k1;}
            if (($k1===false) && ($k2===false)) {$k3=strlen($s);}
            return substr($s,$k,$k3-$k);
        } else {$k=strpos($s,"<p", $k+1);}
    }
}

function getArticleText($id, $field='introtext') { // Текст статьи Joomla по коду
    $db = & JFactory::getDBO();
    $db->setQuery("SELECT `$field` FROM #__content WHERE id='$id' and state=1");
    $data = $db->loadObjectList();
    return $data[0]->$field;
}

function getArticleTitle($id) { //Заголовок статьи Joomla по коду
    $db = & JFactory::getDBO();
    $db->setQuery("SELECT title FROM #__content WHERE id='$id' and state=1");
    $data = $db->loadObjectList();
    return $data[0]->title;
}

function getArticlesByCat($id) { //Все статьи Joomla в определенной категории (по коду категории)
    $db = & JFactory::getDBO();
    $db->setQuery("SELECT * FROM #__content WHERE catid='$id' and state=1 ORDER BY ordering");
    $data = $db->loadObjectList();
    return $data;
}

function addArticle($catid, $title, $introtext, $fulltext='', $state=1, $extra=array()) { // catid - id категории, title-заголовок, introtext-вводный текст, fulltext-текст подробнее, state - состояние, extra-ассоциативный массив с доп. аттрибутами
    require_once("administrator/components/com_content/models/article.php");
    $article = new ContentModelArticle();
    $data = array(
        'catid' => $catid,
        'title' => $title,
        'introtext' => $introtext,
        'fulltext' => $fulltext,
        'state' => $state
    );
    foreach($extra as $key=>$item) {
        $data[$key]=$item;
    }
    $article->save($data);
}