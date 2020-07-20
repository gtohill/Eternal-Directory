<?php



get_header();
?>


<?php $url = get_post_meta($post->ID, '_eternity_background_image_meta_key', true); ?>
<?php $map = get_post_meta($post->ID, '_eternity_map_meta_key', true); ?>

<!-- Header -->

<?php

if (have_posts()) {

    while (have_posts()) {
        the_post();
?>


        <div class="hero-box" style="background-image: url(<?php echo $url; ?>);">
            <div class="hero-portrait-image">
                <?php echo the_post_thumbnail(); ?>
            </div>
            <div class="hero-text">
                <div style="padding-top:1em;">
                    <span style="font-size:2em; font-family:'Courgette', cursive">In Memory Of</span><br>
                    <span style="font-size:3em"><?php the_title() ?></span><br>
                    <span><?php echo get_post_meta($post->ID, '_eternity_dob_year_meta_key', true); ?> - <?php echo get_post_meta($post->ID, '_eternity_dod_year_meta_key', true); ?></span>
                </div>
            </div>
        </div>

        <!-- Navigation Bar -->
        <div class="navbar">
            <a id="obituary" href="<?php get_permalink($post->ID); ?>">Obituary</a>
            <a id="tribute" href="">Tribute</a>
            <a id="service" href="">Service Information</a>
        </div>

        <!-- The flexible grid (content) -->
        <div class="row">
            <div class="side">
                <h4>Resting Place: </h4>
                <h4>
                    <b>
                        <?php echo get_post_meta($post->ID, '_eternity_location_meta_key', true); ?>
                    </b>
                </h4>
                <h5>Map To Resting Place:</h5>
                <div class="img-magnifier-container">
                    <img id="myimage" src="<?php echo $map; ?>" />
                </div>
            </div>
            <div class="main">
                <h3 style="text-align:center">Obituary for <?php the_title() ?></h3>
                <?php echo the_content(); ?>
                <br>
            </div>
            <div class="right-side">
                <h4 style="text-align:center">Celebration of Life</h4>
                <div class="eternal-flex-container">
                    <?php
                    $dte = get_post_meta($post->ID, '_eternity_interment_date_meta_key', true);
                    $date = date_create($dte);
                    $new_date = date_format($date, "F l j");
                    $splt_date = explode(" ", $new_date);
                    ?>
                    <div class="eternal-date-box-side">
                        <div id="eternal-day">
                            <?php echo $splt_date[1] ?>
                        </div>
                        <div id="eternal-number">
                            <?php echo $splt_date[2] ?>
                        </div>
                        <div id="eternal-month">
                            <?php echo $splt_date[0] ?>
                        </div>
                    </div>
                    <div class="eternal-infomation-box-side">
                        <div>
                            <?php echo get_post_meta($post->ID, '_eternity_interment_time_meta_key', true); ?>
                        </div>
                        <div>
                            <?php echo get_post_meta($post->ID, '_eternity_interment_location_meta_key', true); ?>

                        </div>
                        <div>
                            <?php echo get_post_meta($post->ID, '_eternity_interment_address_meta_key', true); ?>

                        </div>
                        <div>
                            <?php echo get_post_meta($post->ID, '_eternity_interment_phone_meta_key', true); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div id="eternal-add-testimonial">
            <a name="add-testimonial"></a>            
            <div id="show-tribute-form">
                <?php comment_form() ?>
            </div>
        </div>
<?php
    }
} ?>



</main><!-- #site-content -->
<script type="text/javascript">
    /* jquery */  
    jQuery("#eternal-add-testimonial").hide();

    jQuery("#tribute").click(function(event) {
        event.preventDefault();

        var id_post = "<?php echo $post->ID; ?>";
        jQuery.ajax({
            type: 'GET',
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            data: {
                post_id: id_post,
                action: 'get_eternal_cpt_comments'
            },
            success: function(result) {
                
                let comments = '<h2 style="text-align:center">Tributes</h2>'+
                               '<div class="archive-tribute-main-container">'+
                               '<a href="#add-testimonial">Add Testimonial</a>';
                for (var i = 0; i < result.data.length; i++) {
                    commentData = result.data[i];
                    comments +=
                        `<div class="eternal-tribute-comment-container">
                            <div>
                            ${commentData.comment_content}
                            </div>
                            <div class="eternal-tribute-info-container">
                            <div class="eternal-comment-author">
                                <small>Tribute by: ${commentData.comment_author}</small>
                            </div>
                            <div class="eternal-comment-date">
                                <small>Date: ${commentData.comment_date.slice(0, 10)}</small>
                            </div>
                            </div>
                        </div>`
                }
                comments += '</div>'                 
                jQuery(".main").html(comments);
                jQuery("#eternal-add-testimonial").show();
               
            },
            error: function() {
                console.log('Error occured');
            }
        })
    });


    jQuery("#service").click(function(event) {
        event.preventDefault();
        jQuery("#eternal-add-testimonial").hide();
        var id_post = <?php echo $post->ID; ?>;
        jQuery.ajax({
            type: 'GET',
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            data: {
                post_id: id_post,
                action: 'get_eternal_cpt_interment'
            },
            success: function(result) {
                console.log(result.data);
                intermentData = result.data;
                const month = convertDate(intermentData[0].toString());

                let interment = '<h2 style="text-align:center">Interment</h2><div class="eternal-flex-container">';
                interment +=
                    '<div class="eternal-date-box">' +
                    '<div id="eternal-day">' +
                    month[0]+
                    '</div>' +
                    '<div id="eternal-number">' +
                    month[4] +
                    '</div>' +
                    '<div id="eternal-month">' +
                    month[2] +
                    '</div>' +
                    '</div>' +
                    '<div class="eternal-infomation-box">' +
                    '<div>' +
                    intermentData[1] +
                    '</div>' +
                    '<div>' +
                    intermentData[2] +
                    '</div>' +
                    '<div>' +
                    intermentData[3] +
                    '</div>' +
                    '<div>' +
                    intermentData[4] +
                    '</div>' +
                    '</div>'

                interment += '</div>';
                jQuery(".main").html(interment);
            },
            error: function() {
                console.log('Error occured');
            }
        })
    });


    function convertDate(date) {
        var newDate = new Date(date)
        var options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        options.timeZone = 'UTC';
        options.timeZoneName = 'short';
        var newDate = new Intl.DateTimeFormat('en-US', options).format(newDate);
        // convert to javascript date         
        let splDate = newDate.split(/([ ,]+)/);
        console.log(splDate);
        return splDate;
    }

    /* instantiate magnifying glass */
    magnify("myimage", 2);
</script>

<?php get_footer(); ?>