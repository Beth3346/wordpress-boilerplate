        <footer class="main-footer elr-container-full">
            <div class="elr-row">
                <div class="elr-col-full">
                    <nav class="footer-nav" role="navigation">
                        <?php wp_nav_menu(
                            array(
                                'theme_location' => 'footer-nav',
                                'fallback_cb' => 'default_footer_nav',
                                'container'  => 'footer-nav-wrapper',
                                'menu_id' => 'footer-menu',
                                'menu_class' => 'footer-menu elr-inline-list elr-text-center'
                            )
                        ); ?>
                    </nav>
                </div>
            </div>
        </footer>
        <div class="copyright elr-container-full elr-text-center">
            <small>
                <?php bloginfo(); ?> &copy; <?php echo date( 'Y' ); ?> All Rights Reserved.
            </small>
            <!-- wp_footer -->
            <?php wp_footer(); ?>
        </div>
    <!--end wrapper-->
    </div>
</body>
</html>