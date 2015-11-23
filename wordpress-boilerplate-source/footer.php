        <footer class="footer">
            <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Footer' ) ) : ?>
                <section class="footer-widget widget">
                    <h1 class="widget-title"><?php _e( 'Pages','elr' ); ?></h1>
                    <ul>
                    <?php wp_list_pages('title_li=' ); ?>
                    </ul>
                </section>
                <section class="footer-widget widget">
                    <h1 class="widget-title"><?php _e( 'Category','elr' ); ?></h1>
                    <ul>
                    <?php wp_list_categories( 'title_li=' ); ?>
                    </ul>
                </section>
            <?php endif; ?>
        </footer>
        <small class="copyright">
            <?php bloginfo(); ?> &copy; <?php echo date( 'Y' ); ?>
            All Rights Reserved. - WordPress Theme by: <a href="http://www.elizabeth-rogers.com">Elizabeth Rogers</a>
            <!-- wp_footer -->
            <?php wp_footer(); ?>
        </small>
    <!--end wrapper-->
    </div>
</body>
</html>