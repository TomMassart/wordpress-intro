<?php get_header();?>
    
    <?php if(have_posts()): while(have_posts()): the_post();?>
        <section class="content__page">
            <?php get_template_part('part','content'); ?>
        </section>
    <?php endwhile; endif;?>

    <section class="content__articles">
        <h2>Les articles de mon site</h2>

        <?php
            $trips = new WP_Query();
            $trips->query([
                    'post_type' => 'trip',
                    'showpost' => 5 
                ]);
        ?>

        <?php if($trips->have_posts()): while($trips->have_posts()): $trips->the_post(); ?>

        <?php $fields = get_fields();?>

        <article class="post">
            <h3 class="post__title"><?php the_title();?></h3>
            <p class="post__date">Publié le <time class="post__time" datetime="<?php the_time('c');?>"><?php the_time('l j F Y');?></time>.</p>
            <p>Endroits&nbsp;: <?php dw_the_places(', ', '<strong class="post__place post__place--:type">', '</strong>');?></p>
            <figure class="post__thumb">
                <?php the_post_thumbnail('medium');?>
            </figure>
            <div class="post__excerpt">
                <?php dw_the_excerpt(200);?>
                <a href="<?php the_permalink();?>" class="post__more"><?= __('Lire plus','dw');?></a>
            </div>
            <dl class="post__info">
                <dt class="post__term"><?= __('Durée du voyage','dw');?></dt>
                <dd class="post__data"><?= $fields['length'];?></dd>
                <dt class="post__term"><?= __('Nombre de participants','dw');?></dt>
                <dd class="post__data"><?= dw_chose_singularity($fields['participants'], 'il n\'y avait qu\'un participant', 'il y avait :number participants');?></dd>
            </dl>
        </article>
        <?php endwhile; else: ?>
        <p class="content__empty">Il n'y a pas d'articles à afficher.</p>
        <?php endif;?>

    </section>

<?php get_footer();?>
