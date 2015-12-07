<?php

// No direct access.
defined('_JEXEC') or die;

class plgSystemmxsys extends JPlugin
{

    public function onAfterInitialise() {
        $app  = JFactory::getApplication();
        if ($app->isAdmin()) {return;}
        //$app->getBody();
        //$app->setBody('');
    }

    public function onUserLogin($user, $options = array()) {

    }
}