<div class="dropdown">
    <a href="#" class="dropdown-menu dropdown-menu-link-icon"?><strong><?= t('Tags') ?> <i class="fa fa-caret-down"></i></strong> </a>
    <ul>
        <?php foreach ($links as $link): ?>
            <li><a href="#"><?= $link['name'] ?></a></li>
        <?php endforeach ?>
    </ul>
</div>