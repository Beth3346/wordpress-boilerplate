<?php if( function_exists( 'wft_pagenav' ) ) { ?>
    <?php wft_pagenav(); ?>
<?php } else { ?>
    <div class="post-nav">
        <p>pagination</p>
        <span class="prev"><?php next_posts_link( __( '&laquo; Older Entries', 'wft' ) ) ?></span>
        <span class="next"><?php previous_posts_link( __( 'Newer Entries &raquo;', 'wft' ) ) ?></span>
    </div>
<?php } ?>