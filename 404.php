<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
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

		<section class="error-404 not-found">
			<div class="container">
				<header class="page-header">
					<h1 class="page-title page-title_404"><?php esc_html_e( 'Упс! Такої сторінки не існує.', 'cash-custom' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p>
						Спробуйте знайти інформацію на <a href="<?php echo esc_url( home_url() ); ?>">головній сторінці</a>.  
					</p>

					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'cash-custom' ); ?></p>

					<?php
					get_search_form();

					the_widget( 'WP_Widget_Recent_Posts', array(
						'title'     => 'Нещодавно додані МФО', // здесь твой заголовок
						'number'    => 7) );
					?>

					<div class="widget widget_categories">
						<h2 class="widget-title"><?php esc_html_e( 'Більше категорій', 'cash-custom' ); ?></h2>
						<ul>
							<?php
							wp_list_categories(
								array(
									'orderby'    => 'count',
									'order'      => 'DESC',
									'show_count' => 1,
									'title_li'   => '',
									'number'     => 10,
								)
							);
							?>
						</ul>
					</div> <!-- .widget -->

					<!-- <?php
					$cash_custom_archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'cash-custom' ), convert_smilies( ':)' ) ) . '</p>';
					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$cash_custom_archive_content" );

					the_widget( 'WP_Widget_Tag_Cloud' );
					?> -->

				</div><!-- .page-content -->
			</div>
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
