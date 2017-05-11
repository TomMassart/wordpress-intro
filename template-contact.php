<?php
/*

    Template Name: Page de contact

*/
get_header();
?>

        <?php get_template_part('part', 'content');?>

        <section class="contact">
            <h1 class="contact__title">Formulaire de contact</h1>
            <form action="#" method="POST" class="contact__form">
                <fieldset class="contact__fields">
                    <label for="name">Votre nom</label>
                    <input type="text" name="name" id="name">
                    <label for="email">Votre adresse e-mail</label>
                    <input type="email" name="email" id="email">
                    <label for="message">Votre message</label>
                    <textarea name="message" id="message" cols="30" rows="10"></textarea>
                </fieldset>
                <fieldset class="contact__submit">
                    <button type="submit">Envoyer le message</button>
                </fieldset>
            </form>
        </section>

<?php get_footer();?>
