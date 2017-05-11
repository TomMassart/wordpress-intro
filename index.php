<?php get_header(); ?>

    <?php if(have_posts()) : while(have_posts()): the_post();?>
        <section class="content__page">
            <h1 class="content__title"><?php the_title();?></h1>
            <div class="content__wysiwyg wysiwyg"><?php the_content();?></div>
        </section>
    <?php endwhile; endif;?>

    <section class="content__posts">
        <h2 class="content__title">Mes derniers articles</h2>

        <?php
            $posts = new WP_Query(['showpost' => 2]);
        ?>

        <?php if($posts->have_posts()) : while($posts->have_posts()): $posts->the_post();?>
        <article class="post">
            <h3 class="post__title"><?php the_title(); ?></h3>
            <p class="post__date">Publié le <time class="post__time" datetime="<?php the_time('c');?>"><?php the_time('l j F Y');?></time>.</p>
            <figure class="post__thumb">
                <?php the_post_thumbnail('medium');?>
            </figure>
            <div class="post__excerpt">
                <?php dw_the_excerpt(200);?>
                <a href="<?php the_permalink();?>" class="post__link">Lire plus</a>
            </div>
        </article>
        <?php endwhile; else:?>
        <p class="content__empty">Il n'y a pas d'articles à afficher pour le moment.</p>
        <?php endif;?>

    </section>

    <section class="content__posts">
        <h2 class="content__title">Mes derniers voyages</h2>

        <?php
            $posts = new WP_Query(['showpost' => 2, 'post_type' => 'trip']);
        ?>

        <?php if($posts->have_posts()) : while($posts->have_posts()): $posts->the_post();?>
        <article class="post post--trip">
            <h3 class="post__title"><?php the_title(); ?></h3>
            <p class="post__date"><?= str_replace(':time', '<time class="post__time" datetime="' .get_the_time('c') . '">' . get_the_time('l j F Y') . '</time>', __('Publié le :time.','dw'));?></p>
            <p class="post__terms">Endroits visités&nbsp: <?php dw_the_places(', ', '<a href=":link" class="post__term post__term--:type">', '</a>', 'Nous ne sommes allés nulle part de connu lors de ce voyage.');?></p>
            <div class="post__excerpt">
                <?php dw_the_excerpt(200);?>
                <a href="<?php the_permalink();?>" class="post__link"><?= __('Lire plus','dw');?></a>
            </div>

            <?php $fields = get_fields();?>
            <dl class="post__info">
                <dt class="post__label"><?= __('Durée du voyage&nbsp;:','dw');?></dt>
                <dd class="post__data"><?= $fields['trip_info_duration'];?></dd>
                <dt class="post__label"><?= __('Nombre de participants&nbsp;:','dw');?></dt>
                <dd class="post__data"><?= dw_chose_singularity($fields['trip_info_participants'], __('un voyageur','dw'), __('il y avait :number voyageurs','dw'));?></dd>
            </dl>
        </article>
        <?php endwhile; else:?>
        <p class="content__empty">Il n'y a pas d'articles à afficher pour le moment.</p>
        <?php endif;?>

    </section>

<?php get_footer();?>
