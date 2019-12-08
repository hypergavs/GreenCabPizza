<?php 
get_header(); ?>
<div class="container">
	<div class="row">
    	<div class="col-md-12">
			<?php if(have_posts()){ ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php the_content(); ?>
                    <?php //get_template_part( 'content', 'page' ); ?>
    
                    <?php
                        // If comments are open or we have at least one comment, load up the comment template
                        if ( comments_open() || '0' != get_comments_number() )
                            comments_template();					
                    
                    ?>
    
                <?php endwhile; ?>
            <?php }else{ echo "Content not found!"; }?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
