<?php
/*
Template Name: Page contact
*/
get_header();
?>
    
<?php if(have_posts()): while(have_posts()): the_post();?>
    <section class="blabla__page">
        <?php get_template_part('part','content'); ?>
        <div class="content__form">
            <form action="#" class="contact">
                <fieldset>
                    <label for="name">Votre nom</label>
                    <input type="text" name="name" id="name">
                    <label for="email">Votre email</label>
                    <input type="email" name="email" id="email">
                    <label for="message">Votre message</label>
                    <textarea name="message" id="message" cols="30" rows="10"></textarea>
                </fieldset>
                <fieldset>
                    <button type="submit">Envoyer</button>
                </fieldset>
            </form>
        </div>
    </section>
<?php endwhile; endif;?>

<?php get_footer();?>
