<?
function SQLQueryOne($q) { //запрос sql, в результате которого возвращается одно поле одной строки запроса
    $db = & JFactory::getDBO();
    $db->setQuery($q);
    $data = $db->loadRowList();
    return $data[0][0];
}

function SQLQuery($q) { //запрос sql, в результате которого возвращается одно поле одной строки запроса
    $db = & JFactory::getDBO();
    $db->setQuery($q);
    $data = $db->loadObjectList();
    return $data;
}

function SQLExec($q) { //выполнение запроса без возвращаемого значения (INSERT, UPDATE, DELETE)
    $db = & JFactory::getDBO();
    $db->setQuery($q);
    $db->query();
}
?>