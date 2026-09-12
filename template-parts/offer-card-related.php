<?php
/**
 * Compact recommendations card, independent of the catalog card.
 *
 * @param array $args Requires a company post_id; does not change global post data.
 */
if (!defined('ABSPATH')) { exit; }
$related_id = isset($args['post_id']) ? absint($args['post_id']) : 0;
if (!$related_id || !get_post($related_id)) { return; }
$related_name = get_the_title($related_id);
$related_url = cashkredit_offer_value('referral_link', $related_id) ?: cashkredit_offer_value('offer_page', $related_id);
$related_logo = function_exists('get_field') ? get_field('logo', $related_id) : false;
$related_rating = cashkredit_offer_value('rate', $related_id);
$related_sum = cashkredit_offer_value('loan_sum', $related_id);
$related_percent = cashkredit_offer_value('percent', $related_id);
$related_term = cashkredit_offer_value('term', $related_id);
$related_title_id = 'related-offer-title-' . $related_id;
?>
<article class="related-offer-card" aria-labelledby="<?php echo esc_attr($related_title_id); ?>">
    <div class="related-offer-card__brand">
        <?php if ($related_logo) : ?>
            <?php if ($related_url) : ?>
            <a class="related-offer-card__logo btn_offer" href="<?php echo esc_url($related_url); ?>" data-base-url="<?php echo esc_url($related_url); ?>" data-campaign="opr" target="_blank" rel="sponsored nofollow noopener">
            <?php else : ?><div class="related-offer-card__logo"><?php endif; ?>
                <?php echo cashkredit_offer_image($related_logo, 'medium', ['alt' => $related_name, 'loading' => 'lazy', 'decoding' => 'async']); ?>
            <?php echo $related_url ? '</a>' : '</div>'; ?>
        <?php endif; ?>
        <h3 class="related-offer-card__title" id="<?php echo esc_attr($related_title_id); ?>"><a href="<?php echo esc_url(get_permalink($related_id)); ?>"><?php echo esc_html($related_name); ?></a></h3>
    </div>
    <?php if ($related_rating !== '') : ?>
    <div class="related-offer-card__rating" aria-label="Рейтинг <?php echo esc_attr($related_rating); ?> з 5"><span class="related-offer-card__star" aria-hidden="true">★</span><strong><?php echo esc_html($related_rating); ?></strong><span class="related-offer-card__scale">/ 5</span></div>
    <?php endif; ?>
    <?php if ($related_sum !== '') : ?>
    <div class="related-offer-card__amount">
        <span class="related-offer-card__label">Сума позики</span>
        <span class="related-offer-card__amount-value"><small>до</small> <?php echo esc_html($related_sum); ?> <small>₴</small></span>
    </div>
    <?php endif; ?>
    <?php if ($related_percent !== '' || $related_term !== '') : ?>
    <div class="related-offer-card__conditions">
        <?php if ($related_percent !== '') : ?>
        <div class="related-offer-card__condition"><strong>від <?php echo esc_html($related_percent); ?>%</strong><span class="related-offer-card__label">Ставка</span></div>
        <?php endif; ?>
        <?php if ($related_term !== '') : ?>
        <div class="related-offer-card__condition"><strong><?php echo esc_html($related_term); ?> <small>днів</small></strong><span class="related-offer-card__label">Термін</span></div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <?php if ($related_url) : ?>
    <a class="related-offer-card__apply btn_offer" href="<?php echo esc_url($related_url); ?>" data-base-url="<?php echo esc_url($related_url); ?>" data-campaign="opr" target="_blank" rel="sponsored nofollow noopener">Подати заявку</a>
    <?php endif; ?>
</article>
