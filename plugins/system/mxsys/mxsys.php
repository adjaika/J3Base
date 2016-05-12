<?php
// Проверка существования и добавление поля (mx_access) в таблицу
// $db = & JFactory::getDBO();
// $db->setQuery("show columns FROM #__content where `Field` = 'mx_access'");
// if (is_null($db->loadObject())) {
//     $db->setQuery("ALTER TABLE #__content ADD mx_access tinyint NULL");
//     $db->execute();
// }

// No direct access.
defined('_JEXEC') or die;

class plgSystemmxsys extends JPlugin
{
    public function onUserLogin($user, $options = array()) {

    }

    public function onAfterRender() {
        /*$body=JFactory::getApplication()->getBody();
        JFactory::getApplication()->setBody($body);*/
    }

    public function onAfterRoute() {
        /*$router = $this->app->getRouter();*/
    }

    public function onAfterInitialise() {
        $this->app = JFactory::getApplication();
        if ($this->app->isSite()) {
            $router = $this->app->getRouter();
            $router->attachBuildRule(array($this, 'buildRule'), JRouter::PROCESS_DURING);
            $router->attachParseRule(array($this, 'parseRule'), JRouter::PROCESS_DURING);
        }
    }

    public function buildRule(&$router, &$uri) { //sef - формирование ссылок
        /*$uri->getVar('option');*/
    }
    public function parseRule(&$router, &$uri) { //sef - обработка url произвольного вида (замена одних url на другие)
        $replaceLinksA=array(
            /*'shop'=>'katalog',
            'shop/keramogranit'=>'katalog/keramogranit',
            'shop/kerlit'=>'katalog/kerlit',*/
        );
        $path=$uri->getPath();
        if (isset($replaceLinksA[$path])) {
            $uri->setPath($replaceLinksA[$path]);
        }
        return array();
    }
}
