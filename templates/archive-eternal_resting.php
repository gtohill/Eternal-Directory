<?php
/* 
Template Name: Archives-eternal_resting
*/
get_header(); ?>
<style>
    .eternal-archive-bkgnd-image {
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        background-color: rgba(34, 44, 44, 0.3);
    }

    .archive-flex-row-container {
        display: flex;
        margin-bottom: 1em;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        background-color: rgba(34, 44, 44, 0.3);

    }

    .archive-flex-content {
        color: white;
        margin: auto;
        font-size: 1.25;

    }

    .archive-flex-row-container>div {
        margin: 1em;
    }

    .archive-flex-image {
        width: 150px;
    }
   
    .eternity-entry-title {
        color: white;
    }

    .archive-flex-row-container a {
        text-decoration: none;
    }

    .eternity-entry-title:hover {
        color: beige;

    }

    .eternal-search-bar {
        margin: auto;
        width: 70%;
        padding: 3em 0;
    }


    /* Responsive layout - when the screen is less than 700px wide, make the two columns stack on top of each other instead of next to each other */
    @media screen and (max-width: 700px) {

        .archive-flex-row-container {
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
    }
</style>

<div class="eternal-search-bar">
    <h4>Find Resting Place</h4>
    <?php get_search_form(); ?>
</div>
<?php while (have_posts()) : the_post(); ?>
    <div class="eternal-archive-bkgnd-image" style="background-image: url(<?php echo get_post_meta($post->ID, '_eternity_background_image_meta_key', true) ?>);">


        <div class="archive-flex-row-container">
            <div class="archive-flex-image">
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
	            <img src="<?php the_post_thumbnail_url(); ?>"/>                
            </div>
            <div class="archive-flex-content">
                <a href=<?php echo get_permalink($post->ID); ?>>
                    <h6 class="eternity-entry-title"><?php the_title(); ?></h6>
                </a>
                <span><?php echo get_post_meta($post->ID, '_eternity_dob_year_meta_key', true); ?> - <?php echo get_post_meta($post->ID, '_eternity_dod_year_meta_key', true); ?></span>
                <br><br>
                Burial Location:
                <b>
                    <?php echo get_post_meta($post->ID, '_eternity_location_meta_key', true); ?>
                </b>
            </div>
            
        </div>
    </div>



<?php endwhile; // end of the loop. 
?>



<?php get_footer(); ?>