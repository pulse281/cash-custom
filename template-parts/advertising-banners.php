<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!get_field('advertising_banners_enabled')) {
    return;
}

$banners = [];

for ($i = 1; $i <= 4; $i++) {
    $enabled = get_field("banner_{$i}_enabled");
    $imageId = get_field("banner_{$i}_image");
    $url     = get_field("banner_{$i}_url");

    if (!$enabled || !$imageId) {
        continue;
    }

    $banners[] = [
        'image_id' => $imageId,
        'url'      => $url,
    ];
}

if (!$banners) {
    return;
}
?>

<section class="advertising-banners">
    <div class="container">

        <div class="advertising-banners__title">
            Вас може зацікавити
        </div>

        <div
            class="advertising-banners__list"
            data-banners-count="<?php echo esc_attr(count($banners)); ?>">

            <?php foreach ($banners as $banner) : ?>

                <div class="advertising-banners__item">

                    <?php if ($banner['url']) : ?>
                        <a
                            href="<?php echo esc_url($banner['url']); ?>"
                            class="advertising-banners__link"
                            target="_blank"
                            rel="sponsored nofollow noopener">
                        <?php endif; ?>

                        <?php
                        echo wp_get_attachment_image(
                            $banner['image_id'],
                            'full',
                            false,
                            [
                                'class'   => 'advertising-banners__image',
                                'loading' => 'lazy',
                            ]
                        );
                        ?>

                        <?php if ($banner['url']) : ?>
                        </a>
                    <?php endif; ?>

                </div>

            <?php endforeach; ?>

        </div>

    </div>
</section>