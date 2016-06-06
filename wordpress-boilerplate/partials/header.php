<header class="main-header elr-container-full" role="banner">
    <div class="elr-row">
        <div class="elr-col-third">
            <!-- add logo background image images/logo.png -->
            <p class="site-name"><a href="<?php bloginfo('url'); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
        </div>
        <div class="navigation-holder elr-col-two-thirds">
            <nav class="main-nav" role="navigation">
                <?php wp_nav_menu([
                    'theme_location' => 'main-nav',
                    'fallback_cb' => 'default_main_nav',
                    'container'  => 'main-nav-wrapper',
                    'menu_id' => 'main-menu',
                    'menu_class' => 'main-menu elr-inline-list'
                ]); ?>
            </nav>
        </div>
    </div>
</header>