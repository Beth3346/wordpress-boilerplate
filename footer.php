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
            <small class="copyright elr-col-full elr-text-center">
                <?php bloginfo(); ?> &copy; <?php echo date( 'Y' ); ?> All Rights Reserved.
                <nav class="social-nav" role="navigation">
                    <?php wp_nav_menu(
                        array(
                            'theme_location' => 'social-nav',
                            'fallback_cb' => 'default_social_nav',
                            'container'  => 'social-nav-wrapper',
                            'menu_id' => 'social-menu',
                            'menu_class' => 'social-menu elr-inline-list elr-text-center'
                        )
                    ); ?>
                </nav>
            </small>
            <?php wp_footer(); ?>
        </div>
    </footer>
</body>
</html>