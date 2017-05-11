<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php wp_title('');?></title>
    <link rel="stylesheet" href="<?php theme_asset('style.css');?>">
</head>
<body>
    <header class="top">
        <h1 class="top__logo"><?php bloginfo('name'); ?> - [page]</h1>
        <p class="top__intro"><?php bloginfo('description'); ?></p>
        <nav class="navigation">
            <h2 class="navigation__title">Navigation principale</h2>

            <ul class="navigation__container">
                <?php foreach(dw_get_nav_items('header') as $item): ?>
                <li class="navigation__item">
                    <a href="<?= $item->url;?>" class="navigation__link"><?= $item->label;?></a>
                    <?php if($item->children):?>
                    <ul class="navigation__sub">
                        <?php foreach($item->children as $sub): ?>
                        <li class="navigation__item">
                            <a href="<?= $sub->url;?>" class="navigation__link"><?= $sub->label;?></a>
                        </li>
                        <?php endforeach;?>
                    </ul>
                    <?php endif;?>
                </li>
                <?php endforeach; ?>
            </ul>

        </nav>
    </header>
    <main class="content">
