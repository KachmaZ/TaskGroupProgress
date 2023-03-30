<div class="dropdown">
    <a href="#" class="dropdown-menu dropdown-menu-link-icon" ?><strong><?= t('Categories') ?> <i class="fa fa-caret-down"></i></strong> </a>
    <ul>
        <?php foreach ($categories as $category) : ?>
            <li>
                <a href=<?= $this->url->href(
                            'TGPController',
                            'setCurrentCategory',
                            array(
                                'plugin' => 'TaskGroupProgress',
                                'value' => $category
                            )
                        ) ?>>
                    <?= $category ?>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
</div>