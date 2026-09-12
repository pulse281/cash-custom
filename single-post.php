<?php
/** Individual company page. Other posts keep the standard article template. */
if (!cashkredit_is_offer_page()) {
    require get_template_directory() . '/single.php';
    return;
}
get_header();
while (have_posts()) :
    the_post();
    $company_id = get_the_ID();
    $company_name = get_the_title();
    $company_url = cashkredit_offer_value('offer_page') ?: cashkredit_offer_value('referral_link');
    $rating = cashkredit_offer_value('rate');
    $advantages = cashkredit_offer_advantages($company_id);
    $description = cashkredit_offer_description();
    $has_description = trim(wp_strip_all_tags($description)) !== '' || preg_match('/<(img|iframe|video|audio|embed)\b/i', $description);
    $gallery = function_exists('get_field') ? get_field('gallery') : [];
    $gallery_images = [];
    foreach (is_array($gallery) ? $gallery : [] as $gallery_item) {
        if (!empty($gallery_item['image'])) {
            $image = cashkredit_offer_image($gallery_item['image'], 'large', ['alt' => $company_name, 'loading' => 'lazy', 'decoding' => 'async']);
            if ($image !== '') { $gallery_images[] = $image; }
        }
    }
    $related = cashkredit_related_offers($company_id);
    $neighbors = cashkredit_offer_neighbors($company_id);
    $contacts = [];
    foreach (['phone' => 'Телефон', 'email' => 'Email', 'work_time' => 'Графік роботи', 'address' => 'Адреса', 'license' => 'Ліцензія'] as $key => $label) {
        $value = cashkredit_offer_value($key);
        if ($value !== '') { $contacts[$key] = ['label' => $label, 'value' => $value]; }
    }
    $socials = array_filter(['Facebook' => cashkredit_offer_value('facebook'), 'Instagram' => cashkredit_offer_value('instagram')]);
    $conditions = [
        ['loan_sum', 'Сума кредиту', 'до ', ' ₴'],
        ['term', 'Термін', 'до ', ' днів'],
        ['percent', 'Процентна ставка', 'від ', '%'],
    ];
    $conditions = array_filter($conditions, function ($condition) { return cashkredit_offer_value($condition[0]) !== ''; });
?>
<main id="primary" class="site-main company-page">
    <div class="container company-page__container">
        <?php if (function_exists('yoast_breadcrumb')) { yoast_breadcrumb('<nav class="breadcrumbs" aria-label="Навігація сторінкою">', '</nav>'); } ?>
        <section class="company-hero company-panel" aria-labelledby="company-title">
            <div class="company-hero__brand">
                <div class="company-hero__logo">
                    <?php $logo = function_exists('get_field') ? get_field('logo') : false;
                    if ($logo) {
                        echo cashkredit_offer_image($logo, 'medium', ['alt' => $company_name, 'loading' => 'eager', 'fetchpriority' => 'high', 'decoding' => 'async']);
                    } else { ?>
                        <span class="company-hero__initial" aria-hidden="true"><?php echo esc_html(mb_substr($company_name, 0, 1)); ?></span>
                    <?php } ?>
                </div>
                <div class="company-hero__identity">
                    <span class="company-eyebrow">Онлайн-кредитування</span>
                    <h1 id="company-title"><?php echo esc_html($company_name); ?></h1>
                    <?php if ($rating !== '') : ?>
                    <div class="company-rating" aria-label="Рейтинг <?php echo esc_attr($rating); ?> з 5"><span aria-hidden="true">★</span> <strong><?php echo esc_html($rating); ?></strong><span class="company-rating__scale">/ 5</span></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ($conditions) : ?>
            <div class="company-hero__conditions">
                <h2>Умови кредитування</h2>
                <dl class="company-conditions">
                    <?php foreach ($conditions as [$key, $label, $prefix, $suffix]) :
                        $value = cashkredit_offer_value($key);
                        if ($value === '') { continue; } ?>
                    <div class="company-condition<?php echo $key === 'loan_sum' ? ' company-condition--amount' : ''; ?>">
                        <dt><?php echo esc_html($label); ?></dt>
                        <dd><?php echo esc_html($prefix . preg_replace('/(?<=\d)[ \x{202F}](?=\d{3}(?:\D|$))/u', "\u{00A0}", $value) . $suffix); ?></dd>
                    </div>
                    <?php endforeach; ?>
                </dl>
            </div>
            <?php endif; ?>
            <?php if ($company_url) : ?>
            <a class="company-apply company-hero__apply btn_offer" href="<?php echo esc_url($company_url); ?>" data-base-url="<?php echo esc_url($company_url); ?>" data-campaign="opt" target="_blank" rel="sponsored nofollow noopener">Подати заявку <span aria-hidden="true">↗</span></a>
            <?php endif; ?>
        </section>

        <?php if ($advantages) : ?>
        <section class="company-benefits company-panel" aria-labelledby="company-benefits-title">
            <h2 id="company-benefits-title">Переваги <?php echo esc_html($company_name); ?></h2>
            <ul class="company-benefits__list">
                <?php foreach ($advantages as $advantage) : ?><li><span class="company-benefits__check" aria-hidden="true">✓</span><?php echo esc_html($advantage); ?></li><?php endforeach; ?>
            </ul>
        </section>
        <?php endif; ?>

        <?php if ($related) : ?>
        <section class="company-related" aria-labelledby="company-related-title">
            <div class="company-related__heading">
                <div><span class="company-eyebrow">Порівняйте пропозиції</span><h2 id="company-related-title">Схожі компанії</h2></div>
                <a class="company-related__all" href="<?php echo esc_url(get_category_link(cashkredit_offer_category_id())); ?>">Всі МФО <span aria-hidden="true">↗</span></a>
            </div>
            <div class="company-related__track" id="company-related-track" tabindex="0" role="region" aria-label="Пропозиції інших компаній">
                <?php foreach ($related as $related_post) : ?>
                <div class="company-related__slide">
                    <?php get_template_part('template-parts/offer-card-related', null, ['post_id' => $related_post->ID]); ?>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="company-related__controls" hidden>
                <span class="company-related__position" aria-live="polite" aria-atomic="true"></span>
                <div><button type="button" class="company-related__prev" aria-label="Попередні компанії" aria-controls="company-related-track">←</button><button type="button" class="company-related__next" aria-label="Наступні компанії" aria-controls="company-related-track">→</button></div>
            </div>
        </section>
        <?php endif; ?>

        <?php if ($has_description || $gallery_images || $contacts || $socials) : ?>
        <div class="company-editorial<?php echo (!$contacts && !$socials) || (!$has_description && !$gallery_images) ? ' company-editorial--full' : ''; ?>">
            <?php if ($has_description || $gallery_images) : ?>
            <section class="company-about company-panel" aria-labelledby="company-about-title">
                <h2 id="company-about-title">Про компанію</h2>
                <div class="company-prose"><?php echo $description; ?></div>
                <?php if ($gallery_images) : ?>
                <div class="company-gallery">
                    <?php echo implode('', $gallery_images); ?>
                </div>
                <?php endif; ?>
            </section>
            <?php endif; ?>
            <?php if ($contacts || $socials) : ?>
            <section class="company-contacts company-panel" aria-labelledby="company-contacts-title">
                <h2 id="company-contacts-title">Контактна інформація</h2>
                <dl class="company-contacts__list">
                    <?php foreach ($contacts as $key => $contact) : ?>
                    <div><dt><?php echo esc_html($contact['label']); ?></dt><dd>
                        <?php if ($key === 'phone') : ?>
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^+0-9]/', '', $contact['value'])); ?>"><?php echo esc_html($contact['value']); ?></a>
                        <?php elseif ($key === 'email') : ?>
                        <a href="mailto:<?php echo esc_attr(sanitize_email($contact['value'])); ?>"><?php echo esc_html($contact['value']); ?></a>
                        <?php else : echo esc_html($contact['value']); endif; ?>
                    </dd></div>
                    <?php endforeach; ?>
                </dl>
                <?php if ($socials) : ?><div class="company-socials">
                    <?php foreach ($socials as $label => $social_url) : ?><a href="<?php echo esc_url($social_url); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($label); ?> <span aria-hidden="true">↗</span></a><?php endforeach; ?>
                </div><?php endif; ?>
            </section>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if ($company_url) : ?>
        <div class="company-closing company-panel">
            <div><span class="company-eyebrow">Онлайн-заявка</span><p>Оформити кредит у <?php echo esc_html($company_name); ?></p></div>
            <a class="company-apply company-closing__apply btn_offer" href="<?php echo esc_url($company_url); ?>" data-base-url="<?php echo esc_url($company_url); ?>" data-campaign="opb" target="_blank" rel="sponsored nofollow noopener">Подати заявку <span aria-hidden="true">↗</span></a>
        </div>
        <?php endif; ?>


        <?php if ($neighbors['previous'] || $neighbors['next']) : ?>
        <nav class="company-post-nav" aria-label="Навігація між компаніями">
            <?php foreach (['previous' => 'Попередня компанія', 'next' => 'Наступна компанія'] as $direction => $label) :
                $neighbor = $neighbors[$direction];
                if (!$neighbor) { continue; } ?>
            <a class="company-post-nav__link company-post-nav__link--<?php echo esc_attr($direction); ?>" href="<?php echo esc_url(get_permalink($neighbor->ID)); ?>" rel="<?php echo $direction === 'previous' ? 'prev' : 'next'; ?>">
                <span class="company-post-nav__label"><?php echo esc_html($label); ?></span>
                <span class="company-post-nav__name"><?php echo esc_html(get_the_title($neighbor->ID)); ?></span>
                <span class="company-post-nav__arrow" aria-hidden="true"><?php echo $direction === 'previous' ? '←' : '→'; ?></span>
            </a>
            <?php endforeach; ?>
        </nav>
        <?php endif; ?>
    </div>
    <?php if ($company_url) : ?>
    <div class="company-sticky" hidden>
        <a class="company-apply btn_offer" href="<?php echo esc_url($company_url); ?>" data-base-url="<?php echo esc_url($company_url); ?>" data-campaign="ops" target="_blank" rel="sponsored nofollow noopener">Подати заявку в <?php echo esc_html($company_name); ?> <span aria-hidden="true">↗</span></a>
    </div>
    <?php endif; ?>
</main>
<?php endwhile; get_footer(); ?>
