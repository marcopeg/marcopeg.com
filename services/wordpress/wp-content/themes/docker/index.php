<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Docker Theme</title>
        <link href="<?php bloginfo('template_directory');?>/style.css" rel="stylesheet">
        <?php wp_head() ?>
    </head>
    <body class="container">

        <div class="row">
            <div class="col-xs-12">
                <h1>
                    <?php echo get_bloginfo( 'name' ); ?><br>
                    <small><?php echo get_bloginfo( 'description' ); ?></small>
                </h1>
            </div>
        </div>
        <hr>

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <div class="row">
                <div class="col-xs-12">
                    <h4><?php the_title(); ?></h4>
				    <?php the_content(); ?>
                </div>
            </div>
            <hr>
		<?php endwhile; endif;?>

        <?php wp_footer() ?>
    </body>
</html>
