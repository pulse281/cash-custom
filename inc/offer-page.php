<?php
/** Company page data and assets. */
if (!defined('ABSPATH')) { exit; }

function cashkredit_offer_category_id() {
    $category = get_category_by_slug('offers');
    if (!$category) { return 0; }
    return function_exists('pll_get_term') ? (pll_get_term($category->term_id) ?: $category->term_id) : $category->term_id;
}

function cashkredit_is_offer_page() {
    $category_id = cashkredit_offer_category_id();
    return is_singular('post') && $category_id && has_category($category_id, get_queried_object_id());
}

add_action('wp_enqueue_scripts', function () {
    if (!cashkredit_is_offer_page()) { return; }
    foreach (['css' => 'assets/css/blocks/offer-page.css', 'js' => 'assets/js/offer-page.js'] as $type => $file) {
        $url = get_template_directory_uri() . '/' . $file;
        $version = filemtime(get_template_directory() . '/' . $file);
        if ($type === 'css') {
            wp_enqueue_style('cash-offer-page', $url, ['cash-custom-style'], $version);
        } else {
            wp_enqueue_script('cash-offer-page', $url, ['theme-custom-js'], $version, ['in_footer' => true, 'strategy' => 'defer']);
        }
    }
});

function cashkredit_offer_value($name, $post_id = false) {
    $value = function_exists('get_field') ? get_field($name, $post_id) : get_post_meta($post_id ?: get_the_ID(), $name, true);
    return is_scalar($value) ? trim((string) $value) : '';
}

/** Stable catalog order, with matching thematic categories first. */
function cashkredit_related_offers($post_id, $limit = 6) {
    $category_id = cashkredit_offer_category_id();
    if (!$category_id) { return []; }
    $args = [
        'post_type' => 'post', 'post_status' => 'publish',
        'posts_per_page' => -1, 'category__in' => [$category_id],
        'post__not_in' => [$post_id], 'ignore_sticky_posts' => true,
        'no_found_rows' => true, 'suppress_filters' => false,
        'meta_query' => ['relation' => 'OR',
            ['key' => 'hidden_offer', 'compare' => 'NOT EXISTS'],
            ['key' => 'hidden_offer', 'value' => '0'],
        ],
    ];
    if (function_exists('pll_get_post_language')) { $args['lang'] = pll_get_post_language($post_id); }
    $posts = get_posts($args);
    $shared_categories = array_diff(wp_get_post_categories($post_id), [$category_id]);
    $ranked = [];
    foreach ($posts as $item) {
        $order = cashkredit_offer_value('offer_order', $item->ID);
        $ranked[$item->ID] = [
            'post' => $item,
            'shared' => (bool) array_intersect($shared_categories, wp_get_post_categories($item->ID)),
            'order' => $order !== '' && is_numeric($order) ? (float) $order : PHP_INT_MAX,
        ];
    }
    usort($ranked, function ($a, $b) {
        return ($b['shared'] <=> $a['shared']) ?: ($a['order'] <=> $b['order'])
            ?: strnatcasecmp($a['post']->post_title, $b['post']->post_title)
            ?: ($a['post']->ID <=> $b['post']->ID);
    });
    return array_column(array_slice($ranked, 0, $limit), 'post');
}

/** Demote editorial H1 headings only within the company description. */
function cashkredit_offer_description() {
    return preg_replace('/<(\/?)h1(?=[\s>])/i', '<$1h2', apply_filters('the_content', get_the_content()));
}

function cashkredit_offer_image($value, $size = 'large', $attributes = []) {
    $id = is_array($value) ? ($value['ID'] ?? $value['id'] ?? 0) : (is_numeric($value) ? (int) $value : 0);
    if ($id) { return wp_get_attachment_image($id, $size, false, $attributes); }
    $url = is_array($value) ? ($value['url'] ?? '') : $value;
    return is_string($url) && $url !== '' ? '<img src="' . esc_url($url) . '" alt="' . esc_attr($attributes['alt'] ?? '') . '" loading="lazy" decoding="async">' : '';
}

/** Read the editor-owned field as plain text, one advantage per line. */
function cashkredit_offer_advantages($post_id) {
    $value = function_exists('get_field') ? get_field('advantages_acf', $post_id, false) : get_post_meta($post_id, 'advantages_acf', true);
    if (!is_scalar($value)) { return []; }
    return array_values(array_filter(array_map('trim', preg_split('/\\R/u', (string) $value)), 'strlen'));
}

/** Chronological navigation, restricted to published companies in this language. */
function cashkredit_offer_neighbors($post_id) {
    $company = get_post($post_id);
    $category_id = cashkredit_offer_category_id();
    $neighbors = ['previous' => null, 'next' => null];
    if (!$company || !$category_id) { return $neighbors; }
    $base_args = [
        'post_type' => 'post', 'post_status' => 'publish',
        'category__in' => [$category_id], 'post__not_in' => [$post_id],
        'posts_per_page' => 1, 'ignore_sticky_posts' => true,
        'no_found_rows' => true, 'suppress_filters' => false,
    ];
    if (function_exists('pll_get_post_language')) {
        $base_args['lang'] = pll_get_post_language($post_id);
    }
    foreach (['previous' => 'before', 'next' => 'after'] as $direction => $comparison) {
        $order = $direction === 'previous' ? 'DESC' : 'ASC';
        $posts = get_posts(array_merge($base_args, [
            'date_query' => [[$comparison => $company->post_date, 'inclusive' => false, 'column' => 'post_date']],
            'orderby' => ['date' => $order, 'ID' => $order],
        ]));
        $neighbors[$direction] = $posts[0] ?? null;
    }
    return $neighbors;
}
