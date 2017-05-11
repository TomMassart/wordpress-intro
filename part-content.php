<?php if(have_posts()) : while(have_posts()): the_post();?>
    <section class="content__page">
        <h1 class="content__title"><?php the_title();?></h1>
        <div class="content__wysiwyg wysiwyg"><?php the_content();?></div>
    </section>
<?php endwhile; endif;?>
