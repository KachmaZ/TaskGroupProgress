<?php

namespace Kanboard\Plugin\TaskGroupProgress;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;

class Plugin extends Base
{
    public function initialize()
    {
        $this->route->addRoute('analytics/progress', 'TGPController', 'init', 'TaskGroupProgress');

        $this->helper->register('filter', '\Kanboard\Plugin\TaskGroupProgress\Helper\TGPFilter');
        $this->helper->register('table', '\Kanboard\Plugin\TaskGroupProgress\Helper\TGPTable');

        $this->template->hook->attach('template:analytic:sidebar', 'taskGroupProgress:analytic/sidebar');
        
        $this->hook->on('template:layout:css', array('template' => 'plugins/TaskGroupProgress/Assets/css/style.css'));
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getPluginName()
    {
        return 'TaskGroupProgress';
    }

    public function getPluginDescription()
    {
        return t('My plugin is awesome');
    }

    public function getPluginAuthor()
    {
        return 'Arthur Kachmazov';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/kanboard/plugin-myplugin';
    }
}

