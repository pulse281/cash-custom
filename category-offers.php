<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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

	<main class="offers-page">

		<div class="offers-nav">
			<button class="letter-prev">←</button>
			<div class="letters-scroll">
				<?php
				$letters = range('A', 'Z');
				foreach ($letters as $letter) {
					echo '<a href="#letter-' . $letter . '">' . $letter . '</a>';
				}
				?>
			</div>
			<button class="letter-next">→</button>
		</div>

		<div class="offers-list">
			<?php
			$args = array(
				'post_type' => 'post',
				'category_name' => 'offers',
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC'
			);

			$query = new WP_Query($args);

			$current_letter = '';

			if ($query->have_posts()) :
				while ($query->have_posts()) : $query->the_post();

					$first_letter = strtoupper(mb_substr(get_the_title(), 0, 1));

					if ($first_letter !== $current_letter) {
						if ($current_letter !== '') {
							echo '</div>';
						}

						$current_letter = $first_letter;
						echo '<div class="letter-group" id="letter-' . $current_letter . '">';
						echo '<h2 class="letter-title">' . $current_letter . '</h2>';
					}
					?>

					<div class="offer-item">
						<a href="<?php the_permalink(); ?>">
							<?php the_title(); ?>
						</a>
					</div>

				<?php
				endwhile;
				echo '</div>';
				wp_reset_postdata();
			endif;
			?>
		</div>

	</main>

<?php
/* get_sidebar(); */
get_footer();
