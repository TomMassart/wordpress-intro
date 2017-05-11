<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php wp_title('');?></title>
    <link rel="stylesheet" href="<?php dw_asset('/css/style.css');?>">
</head>
<body>
    <header class="top">
        <h1 class="top__title"><?php wp_title();?></h1>
        <p class="top__intro"><?php bloginfo('description');?></p>
        <nav class="menu">
            <h2 class="menu__title">Navigation principale</h2>
            <ul class="menu__container">
                <?php foreach(dw_get_nav_items('header') as $item):?>
                <li class="menu__item">
                    <a href="<?php echo $item->link;?>" class="menu__link"><?php echo $item->label;?></a>
                    <?php if($item->children):?>
                    <ul class="menu__sub">
                        <?php foreach($item->children as $sub):?>
                        <li class="menu__item">
                            <a href="<?php echo $sub->link;?>" class="menu__link"><?php echo $sub->label;?></a>
                        </li>
                        <?php endforeach;?>
                    </ul>
                    <?php endif;?>
                </li>
                <?php endforeach;?>
            </ul>
        </nav>
    </header>
    <main class="content">
