<?php if (!$is_ajax) : ?>
    <div class="page-header">
        <h2><?= t('Task group progress') ?></h2>
    </div>
<?php endif ?>

<div class="TGP">
    <?php if ((bool) $chosenCategory & (bool) $chosenTags) : ?>
        <div class="TGP_table">
            <?= $this->table->create($data, $chosenCategory, $columns, $chosenTags, $project['id']) ?>
        </div>
    <?php else : ?>
        <h2 class="TGP_title">Choose category and tags</h2>
    <?php endif ?>

    <form method="post" class="form-inline" action="<?= $this->url->href(
                                                        'TGPController',
                                                        'getProgress',
                                                        array('project_id' => $project['id'], 'plugin' => 'TaskGroupProgress')
                                                    ) ?>" autocomplete="off">
        <?= $this->form->csrf() ?>
        <div class="form-category">
            <b><?= t('Category') . ': ' ?></b><?= $this->form->select('category', $categories, $categories) ?>
        </div>
        <br>
        <div class="form-tags">
            <b><?= t('Tags') . ': ' ?></b><br>
            <div class="form-tags_wrapper">
                <?php foreach ($tags as $i => $tag) {
                    echo $this->form->checkbox('tags[' . $i . ']', $tag['name'], $tag['id'], class: "form-tags_checkbox");
                }
                ?>
            </div>
            <!-- <div class="form-time">
                $this->form->date(t('Start date'), 'from', $values)
                $this->form->date(t('End date'), 'to', $values)
            </div> -->
        </div>
        <?= $this->modal->submitButtons(array('submitLabel' => t('Execute'))) ?>
    </form>
</div>