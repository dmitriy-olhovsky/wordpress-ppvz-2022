<?php
/**
 * The template for displaying front page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy
 *
 * @package cs2019puet
 */

 get_header();
?>

<h2>Current title: <?php the_title() ?></h2>

<?php the_content(); ?>

<h2>Custom fields</h2>

<?php

// get_field('test_field');

$link_meta = get_post_meta(get_the_ID(), 'test_field', true);

if( $link_meta ): 

    $link_url = $link_meta['url'];
    $link_title = $link_meta['title'];
    $link_target = $link_meta['target'] ?: '_self';
    ?>
    <hr>
    Custom link (meta), id: <?= get_the_ID() ?>: <a class="button" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
    <hr>
<?php 

endif;

// Check value exists.
if( have_rows('content') ):

    // Loop through rows.
    while ( have_rows('content') ) : the_row();        

        // Case: Paragraph layout.
        switch (get_row_layout()) {
            // Header Section
            case 'header':
                $text = get_sub_field('header_text');

                echo "<h2>{$text}</h2>";

            break;
            // Gallery
            case 'gallery':
                $images = get_sub_field('gallery');

                if( !empty($images) && is_array($images) && count($images) ): ?>
                    <ul>
                        <?php foreach( $images as $image ): ?>
                            <li>
                                <a href="<?php echo esc_url($image['url']); ?>">
                                     <img src="<?php echo esc_url($image['sizes']['homepage-thumb']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                                </a>
                                <p><?php echo esc_html($image['caption']); ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif;
            break;
            // Text with image Section
            case 'text_with_image':
                
            break;
            // Testimonials
            case 'testimonials':
                if ( have_rows('testimonials_list') ) :
                    while ( have_rows('testimonials_list') ) : the_row();

                        $author = get_sub_field( 'author' );
                        $photo = get_sub_field( 'photo' );
                        $text = get_sub_field( 'text' );

                        echo $author . '<hr>';

                    endwhile;
                endif;

                break;

            case 'contact_form':

                $form = get_sub_field('form');
                // print_r($form->ID);
                
                if (!empty($form)) {
                    echo do_shortcode("[contact-form-7 id='{$form->ID}']");
                }

                break;
        }

    // End loop.
    endwhile;

// No value.
else :
    // Do something...
endif;

get_footer();