<li <?= $this->app->checkMenuSelection('TGPController', 'getProgress', 'TaskGroupProgress') ?>>
    <?= $this->modal->replaceLink(
        t('Progress'),
        'TGPController',
        'getProgress',
        array(
            'project_id' => $project['id'],
            'plugin' => 'TaskGroupProgress',
            'category' => '0',
            'tags' => ''
        )
    ) ?>
</li>