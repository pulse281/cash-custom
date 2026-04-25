<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Cash-custom
 */

get_header();
?>

    <div class="container">
        <?php if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb('<nav class="breadcrumbs">','</nav>');
        } ?>
    </div>

	<main id="primary" class="site-main">

		<?php        
		while ( have_posts() ) :
			the_post();

/* 			get_template_part( 'template-parts/content', get_post_type() );

			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'cash-custom' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'cash-custom' ) . '</span> <span class="nav-title">%title</span>',
				)
			); */

			// If comments are open or we have at least one comment, load up the comment template.
	/* 		if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif; */

			?>
<div id="offers">

    <?php 
        
        $url = get_field('offer_page');
    ?>

    <section class="offer-hero">
        <div class="container" >
            <div class="offer-hero__wrapper">

                <div class="offer-hero__logo">
                    <?php
                        $logo_id = get_field('logo');

                        if ($logo_id) {
                            echo wp_get_attachment_image(
                                $logo_id,
                                'medium',
                                false,
                                [
                                    'class' => 'offer__logo',
                                    'alt' => get_the_title() . ' — кредит онлайн'
                                ]
                            );
                        }
                    ?>
                </div>

                <div class="offer-hero__info">
                    <h2><?php the_title(); ?></h2>

                    <div class="offer-rating">
                        ⭐ <?php the_field('rate'); ?> / 5
                    </div>

                    <div class="offer-meta">
                        <span>Ліцензія: <?php the_field('license'); ?></span>
                        <span>Працює: <?php the_field('work_time'); ?></span>
                    </div>

                    <a 
                    href="<?php echo esc_url($url); ?>"
                    data-base-url="<?php echo esc_url($url); ?>"
                    data-campaign="opt"
                    class="btn btn-primary btn_offer" 
                    rel="sponsored nofollow noopener"
                    target="_blank">                    
                    Подати заявку
                    </a>
                </div>

            </div>

            <div>
                <h2>Умови кредитування</h2>

                <div class="conditions-grid">

                    <div class="condition-item">
                        💰 До <?php the_field('loan_sum'); ?> грн
                    </div>

                    <div class="condition-item">
                        📅 До <?php the_field('term'); ?> днів
                    </div>

                    <div class="condition-item">
                        📈 Ставка від <?php the_field('percent'); ?>%
                    </div>

                    <div class="condition-item">
                        📊 APR <?php the_field('apr'); ?>%
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="offer-gallery">
        <div class="container">
            <?php if( have_rows('gallery') ): ?>
                <div class="offer-gallery__grid">
                    <?php while( have_rows('gallery') ): the_row(); ?>
                        <img src="<?php the_sub_field('image'); ?>" alt="">
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    
<!--     <section class="offer-conditions">
        <div class="container">
            <h2>Умови кредитування</h2>

            <div class="conditions-grid">

                <div class="condition-item">
                    💰 До <?php the_field('loan_sum'); ?> грн
                </div>

                <div class="condition-item">
                    📅 До <?php the_field('term'); ?> днів
                </div>

                <div class="condition-item">
                    📈 Ставка від <?php the_field('percent'); ?>%
                </div>

                <div class="condition-item">
                    📊 APR <?php the_field('apr'); ?>%
                </div>

            </div>
        </div>
    </section> -->

    <section class="offer-about">
        <div class="container">
            <?php the_content(); ?>
        </div>
    </section>

    <section class="offer-contacts">
        <div class="container">
            <h2>Контактна інформація</h2>

            <div class="contacts-grid">

                <div>
                    📍 Адреса: <?php the_field('address'); ?>
                </div>

                <div>
                    📞 Телефон: <?php the_field('phone'); ?>
                </div>

                <div>
                    ✉ Email: <?php the_field('email'); ?>
                </div>

                <div class="offer-socials">
                    <?php if(get_field('facebook')): ?>
                        <a href="<?php the_field('facebook'); ?>" target="_blank">Facebook</a>
                    <?php endif; ?>

                    <?php if(get_field('instagram')): ?>
                        <a href="<?php the_field('instagram'); ?>" target="_blank">Instagram</a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>



    <section class="offer-cta">
        <div class="container">
            <a 
            href="<?php echo esc_url($url); ?>"
            data-base-url="<?php echo esc_url($url); ?>"
            data-campaign="opb"
            class="btn btn-large btn_offer"
            rel="sponsored nofollow noopener"
            target="_blank">
            Подати заявку в <?php the_title(); ?>
            </a>
        </div>
    </section>

</div>

<?php
the_post_navigation( array(
    'prev_text' => '<div class="post-nav-item post-nav-prev">
                        <span class="nav-arrow">←</span>
                        <span class="nav-title">Попередня компанія %title</span>
                    </div>',
    'next_text' => '<div class="post-nav-item post-nav-next">
                        <span class="nav-title">Наступна компанія %title</span>
                        <span class="nav-arrow">→</span>
                    </div>',
    'screen_reader_text' => esc_html__( 'Навігація між МФО', 'cash-custom' ),
) );
?>

		<?php endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
/* get_sidebar(); */
get_footer();
