<?php require 'header.php'; ?>

<p>
    <?php _e('This management terminal exposes limited functionality to manage transactions through your WordPress installation.', 'heartland-management-terminal') ?>
    <?php _e('Current functionality may not be a one-to-one match for Portico Virtual Terminal.', 'heartland-management-terminal') ?>
</p>

<section class="plugin">
    <h3>
        <a href="https://wordpress.org/plugins/woocommerce-securesubmit-gateway/"
           target="_blank">
            <?php _e('WooCommerce SecureSubmit Gateway', 'heartland-management-terminal') ?>
        </a>
    </h3>
    <div class="install">
        <a href="<?php echo get_admin_url(null, 'plugin-install.php?s=%22WooCommerce+SecureSubmit+Gateway%22&tab=search&type=term') ?>">
            <?php _e('Install', 'heartland-management-terminal') ?>
        </a>
    </div>
    <p class="description">
        <?php _e('Accept payments with Secure Submit and WooCommerce', 'heartland-management-terminal') ?>
    </p>
</section>
<section class="plugin">
    <h3>
        <a href="https://wordpress.org/plugins/securesubmit/"
           target="_blank">
            <?php _e('WP SecureSubmit', 'heartland-management-terminal') ?>
        </a>
    </h3>
    <div class="install">
        <a href="<?php echo get_admin_url(null, 'plugin-install.php?s=%WP+SecureSubmit%22&tab=search&type=term') ?>">
            <?php _e('Install', 'heartland-management-terminal') ?>
        </a>
    </div>
    <p class="description">
        <?php _e('Create simple forms with WP SecureSubmit to take payments', 'heartland-management-terminal') ?>
    </p>
</section>
<section class="plugin">
    <h3>
        <a href="https://wordpress.org/plugins-wp/heartland-secure-submit-addon-for-gravity-forms/"
           target="_blank">
            <?php _e('Heartland Secure Submit Addon for Gravity Forms', 'heartland-management-terminal') ?>
        </a>
    </h3>
    <div class="install">
        <a href="<?php echo get_admin_url(null, 'plugin-install.php?s=%22Heartland+Secure+Submit+Addon+for+Gravity+Forms%22&tab=search&type=term') ?>">
            <?php _e('Install', 'heartland-management-terminal') ?>
        </a>
    </div>
    <p class="description">
        <?php _e('Leverage Gravity Forms to create forms and accept payments', 'heartland-management-terminal') ?>
    </p>
</section>
<section class="plugin">
    <h3>
        <a href="https://wordpress.org/plugins-wp/events-manager-pro-securesubmit-gateway/"
           target="_blank">
            <?php _e('Events Manager Pro SecureSubmit Gateway', 'heartland-management-terminal') ?>
        </a>
    </h3>
    <div class="install">
        <a href="<?php echo get_admin_url(null, 'plugin-install.php?s=%22Events+Manager+Pro+SecureSubmit+Gateway%22&tab=search&type=term') ?>">
            <?php _e('Install', 'heartland-management-terminal') ?>
        </a>
    </div>
    <p class="description">
        <?php _e('Accept payments with Secure Submit and Events Manager Pro', 'heartland-management-terminal') ?>
    </p>
</section>
<p>
    <?php echo sprintf(
        __('Please <a href="%s">contact support</a> with any issues.', 'heartland-management-terminal'),
        'https://developer.heartlandpaymentsystems.com/support'
    ); ?>
</p>

<?php require 'footer.php'; ?>
