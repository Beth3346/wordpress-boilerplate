        <footer class="main-footer elr-container-full">
            <div class="elr-row">
                <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Footer' ) ) : ?>
                <?php endif; ?>
            </div>
        </footer>
        <div class="copyright elr-container-full elr-text-center">
            <small>
                <?php bloginfo(); ?> &copy; <?php echo date( 'Y' ); ?> All Rights Reserved. - WordPress Theme by: <a href="http://www.elizabeth-rogers.com">Elizabeth Rogers</a>
            </small>
            <!-- wp_footer -->
            <?php wp_footer(); ?>
        </div>
    <!--end wrapper-->
    </div>
</body>
</html>