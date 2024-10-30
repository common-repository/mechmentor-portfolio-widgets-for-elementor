<?php

use Elementor\Group_Control_Image_Size;

/**
 * Mech Portfolio Grid Template
 *
 * @package Mechlin Portfolio
 */
$columns_class = 'columns-' . $mpt_data->columns;

/* Get data */
$portfolio_items = $mpt_data->items;
$items_per_page = $mpt_data->items_per_page;
$enable_infinite_scroll = $mpt_data->enable_infinite_scroll;

/* Pagination */
$count = count($portfolio_items);
$current_page = isset($_GET['mpt_page']) ? $_GET['mpt_page'] : 1;
$per_page = $items_per_page;
$total_pages = ceil($count / $per_page);
$items = array_slice($portfolio_items, ( $current_page - 1 ) * $per_page, $per_page);
?>
<div class="mpt-portfolio <?php echo $columns_class; ?>" id="mpt-portfolio-<?php echo $mpt_data->id; ?>" data-infinite="<?php echo $enable_infinite_scroll; ?>">

    <?php
    $i = 1;
    foreach ($items as $item):

        $images = array();
        foreach ($item['images'] as $image) {
            $images[] = $image['url'];
        }
        $data_images = implode('|', $images);
        $item_data = 'data-title="' . esc_html($item['title']) . '"';
        $item_data .= ' data-services="' . esc_html($item['services']) . '"';
        $item_data .= ' data-client="' . esc_html($item['client']) . '"';
        $item_data .= ' data-date="' . esc_html($item['date']) . '"';
        $item_data .= ' data-content="' . esc_html($item['content']) . '"';
        $item_data .= ' data-type="' . esc_html($item['type']) . '"';

        if ($item['type'] == 'audio') {
            $item_data .= ' data-audio="' . $item['audio']['url'] . '"';
        } elseif ($item['type'] == 'video') {
            $item_data .= ' data-video="' . $item['video']['url'] . '"';
        } elseif ($item['type'] == 'image') {
            $item_data .= ' data-images="' . $data_images . '"';
        }

        $last = $i % $mpt_data->columns == 0 ? 'last' : '';
        $featured_image = wp_get_attachment_image_src($item['featured_image']['id'], 'large');
        ?>
        <div class="grid-item <?php echo $last; ?>" <?php echo $item_data; ?>>
            <div class="grid-thumbnail" <?php echo 'style="background-image:url(' . $featured_image[0] . ');"'; ?>>
                <?php if ($mpt_data->title_position == 'inside'): ?>
                    <div class="grid-content">
                        <h4 class="grid-title"><?php echo esc_html($item['title']); ?></h4>
                        <?php if ($item['show_excerpt']) : ?>
                            <p class="excerpt"><?php echo wp_trim_words(esc_html($item['content']), 50); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="grid-overlay"></div>
                <?php endif; ?>
            </div>
            <?php if ($mpt_data->title_position == 'outside'): ?>
                <h4 class="grid-title"><?php echo esc_html($item['title']); ?></h4>
                <?php if ($item['show_excerpt']) : ?>
                    <p class="excerpt"><?php echo wp_trim_words(esc_html($item['content']), 50); ?></p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php
        $i++;
    endforeach;
    ?>

    <?php
    // Pagination
    if ($enable_infinite_scroll == '1') {
        $pagination = '<div class="mpt-page-links">';

        if (!isset($_GET['mpt_page']) || $_GET['mpt_page'] <= 1) {
            $pagination .= '';
        } else {
            $pagination .= '<a href="?mpt_page=' . ( $current_page - 1 ) . '" class="mpt-previous-link">Previous</a>';
        }

        if (isset($_GET['mpt_page']) && $_GET['mpt_page'] >= $total_pages) {
            $pagination .= '';
        } else {
            $pagination .= '<a href="?mpt_page=' . ( $current_page + 1 ) . '" class="mpt-next-link" id="mpt-next-link-' . $mpt_data->id . '">Next</a>';
        }

        $pagination .= '</div>';

        echo $pagination;
    }
    ?>

    <div class="mpt-load-status">
        <div class="infinite-scroll-request">
            <div class="mpt-loader"><div></div><div></div><div></div></div>
        </div>
    </div>

    <?php
    if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
        echo '<script>window.MPT.singlePortfolio();</script>';
    }
    ?>

</div>