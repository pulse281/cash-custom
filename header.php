<!DOCTYPE html>
<html lang="uk">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <!-- Google tag (gtag.js) -->
<!--     <script async src="https://www.googletagmanager.com/gtag/js?id=G-NG2S1JHWF2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-NG2S1JHWF2');
      gtag('config', 'AW-838357114');
    </script> -->

    <?php
        wp_head();
    ?>
  </head>

  <body>

    <div class="page__wrapper">
      <header class="header">
        <div class="header-wrapper animate__animated">
          <div class="container">
			  <a class="header__logo" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
				  <?php
					  if (has_custom_logo()) {
						  the_custom_logo();
					  } else { ?>
					  <div class="header__title">                       
						  <?php bloginfo('name'); ?>
					  </div>
				  <?php } ?>

				  <?php 
						$description = get_bloginfo('description', 'display');
						if ($description || is_customize_preview()) : ?>
						  <div class="header__subtitle"><?php echo $description; ?></div>
				  <?php endif; ?>
            </a>
            <nav id="site-navigation" class="main-navigation">

           

              <div class="nav__wrapper">
                <div class="">

                  <?php
                    wp_nav_menu(
                      array(
                        'theme_location' => 'menu-1',
                        'menu_id'        => 'primary-menu',
                        'menu_class'          => 'menu menu-mobile',
                        'add_a_class'    => 'menu__link', 
                      )
                    );
                  ?>
                </div>

              </div>
            </nav>

          </div>
          <div class="progress">
            <div class="progress__line"></div>
          </div>
          <div class="hamburger">
            <div class="hamburger__item"></div>
            <div class="hamburger__item"></div>
            <div class="hamburger__item"></div>
          </div>
        </div>
      </header>