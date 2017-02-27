<?php
/**
 * Creates the submenu item for the plugin.
 *
 * @package Custom_Admin_Settings
 */

/**
 * Creates the submenu item for the plugin.
 *
 * Registers a new menu item under 'Tools' and uses the dependency passed into
 * the constructor in order to display the page corresponding to this menu item.
 *
 * @package Custom_Admin_Settings
 */
class HeartlandTerminal_Submenu
{
    /**
     * Plugin code
     *
     * @var string
     * @access public
     */
    public $code = 'heartland_terminal';

    /**
     * A reference the class responsible for rendering the submenu page.
     *
     * @var    Submenu_Page
     * @access protected
     */
    protected $submenuPage;

    /**
     * Initializes all of the partial classes.
     *
     * @param Submenu_Page $submenuPage A reference to the class that renders the
     *                                  page for the plugin.
     */
    public function __construct($submenuPage)
    {
        $this->submenuPage = $submenuPage;
    }

    /**
     * Adds a submenu for this plugin to the 'Tools' menu.
     */
    public function init()
    {
        // includes
        include_once plugin_dir_path(__FILE__) . '../includes/Hps.php';

        // hooks
        add_action('admin_menu', array($this, 'addAdminMenuPage'));
        add_action('admin_init', array($this, 'settingsInit'));
    }

    /**
     * Initializes settings for the plugin
     */
    public function settingsInit()
    {
        // register a new setting for the settings page
        register_setting($this->code, $this->code . '_options');

        // register a new section in the settings page
        add_settings_section(
            $this->code . '_section_keys',
            __('API Keys', 'heartland-management-terminal'),
            array($this, 'settingsSectionDescription'),
            $this->code
        );

        // register a new field in the "API Keys" section, inside the settings page
        add_settings_field(
            $this->code . '_public_api_key', // as of WP 4.6 this value is used only internally
            // use $args' label_for to populate the id inside the callback
            __('Public API Key', 'heartland-management-terminal'),
            array($this, 'settingsTextInput'),
            $this->code,
            $this->code . '_section_keys',
            array(
               'label_for' => $this->code . '_public_api_key',
               'class' => $this->code . '_row',
               'description' => '',
               'default' => '',
            )
        );
        add_settings_field(
            $this->code . '_secret_api_key', // as of WP 4.6 this value is used only internally
            // use $args' label_for to populate the id inside the callback
            __('Secret API Key', 'heartland-management-terminal'),
            array($this, 'settingsTextInput'),
            $this->code,
            $this->code . '_section_keys',
            array(
               'label_for' => $this->code . '_secret_api_key',
               'class' => $this->code . '_row',
               'description' => '',
               'default' => '',
            )
        );

        // register a new section in the settings page
        add_settings_section(
            $this->code . '_section_report',
            __('List Transactions Settings', 'heartland-management-terminal'),
            array($this, 'settingsSectionDescription'),
            $this->code
        );

        // register a new field in the "List Transactions Settings" section, inside the settings page
        add_settings_field(
            $this->code . '_report_date_interval', // as of WP 4.6 this value is used only internally
            // use $args' label_for to populate the id inside the callback
            __('Number of Days', 'heartland-management-terminal'),
            array($this, 'settingsTextInput'),
            $this->code,
            $this->code . '_section_report',
            array(
                'label_for' => $this->code . '_report_date_interval',
                'class' => $this->code . '_row',
                'description' => __(
                    'The last "X" days to include for the "List Transactions" section. Default is "10" days.',
                    $this->code
                ),
                'default' => '',
            )
        );
        add_settings_field(
            $this->code . '_report_page_limit', // as of WP 4.6 this value is used only internally
            // use $args' label_for to populate the id inside the callback
            __('Number of Transactions per Page', 'heartland-management-terminal'),
            array($this, 'settingsTextInput'),
            $this->code,
            $this->code . '_section_report',
            array(
                'label_for' => $this->code . '_report_page_limit',
                'class' => $this->code . '_row',
                'description' => __(
                    'The number of transactions to display at once. Default is "10" transactions per page.',
                    $this->code
                ),
                'default' => '',
            )
        );
        add_settings_field(
            $this->code . '_report_transient_timeout', // as of WP 4.6 this value is used only internally
            // use $args' label_for to populate the id inside the callback
            __('Cache Timeout', 'heartland-management-terminal'),
            array($this, 'settingsTextInput'),
            $this->code,
            $this->code . '_section_report',
            array(
                'label_for' => $this->code . '_report_transient_timeout',
                'class' => $this->code . '_row',
                'description' => __(
                    'Value should be in seconds. Default is "1800" (30 minutes).',
                    $this->code
                ),
                'default' => '',
            )
        );
    }

    public function settingsSectionDescription($args)
    {
        switch ($args['id']) {
            case $this->code . '_section_keys':
                break;
            default:
                echo '';
        }
    }

    public function settingsTextInput($args)
    {
        $options = get_option($this->code . '_options');
        ?>
        <input id="<?php echo esc_attr($args['label_for']) ?>"
               type="text" class="regular-text"
               name="<?php echo $this->code ?>_options[<?php echo esc_attr($args['label_for']) ?>]"
               value="<?php echo (isset($options[$args['label_for']]) ? $options[$args['label_for']] : $args['default']) ?>">
        <p class="description">
            <?php esc_html_e($args['description'], 'heartland-management-terminal') ?>
        </p>
        <?php
    }

    /**
     * Gets a setting value with a default fallback
     *
     * @param string $setting Setting key
     * @param mixed  $default Default value
     *
     * @return mixed
     */
    public function getSetting($setting, $default = false)
    {
        $options = get_option($this->code . '_options');

        if ($options === false) {
            return $default;
        }

        $key = sprintf('%s_%s', $this->code, $setting);
        return isset($options[$key]) && !empty($options[$key])
            ? $options[$key]
            : $default;
    }

    /**
     * Creates the submenu item and calls on the Submenu Page object to render
     * the actual contents of the page.
     */
    public function addAdminMenuPage()
    {
        add_menu_page(
            __('Heartland Payment Systems', 'heartland-management-terminal'),
            __('Heartland', 'heartland-management-terminal'),
            'administrator',
            __FILE__,
            array($this, 'adminHeartlandRoot'),
            plugins_url('/assets/images/heartland-icon.jpg', dirname(dirname(__FILE__)))
        );

        add_submenu_page(
            __FILE__,
            __('Heartland Payment Systems - Transactions', 'heartland-management-terminal'),
            __('List Transactions', 'heartland-management-terminal'),
            'administrator',
            'heartland-transactions',
            array($this, 'adminHeartlandTransactions')
        );

        add_submenu_page(
            __FILE__,
            __('Heartland Payment Systems - Options', 'heartland-management-terminal'),
            __('Options', 'heartland-management-terminal'),
            'administrator',
            'heartland-options',
            array($this, 'adminHeartlandOptions')
        );
    }

    /**
     * Entrypoint for the root page
     */
    public function adminHeartlandRoot()
    {
        include_once plugin_dir_path(__FILE__)
            . '../../templates/admin/root.php';
    }

    /**
     * Entrypoint for the options page
     */
    public function adminHeartlandOptions()
    {
        /**
         * Limits accessing the options page based on a user capability
         *
         * Default value is 'manage_options'.
         *
         * @param string $capability
         */
        $capability = apply_filters($this->code . '_options_user_capability', 'manage_options');

        // check user capabilities
        if (!current_user_can($capability)) {
            return;
        }

        include_once plugin_dir_path(__FILE__)
            . '../../templates/admin/options.php';
    }

    /**
     * Entrypoint for the list and manage pages
     */
    public function adminHeartlandTransactions()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $id = isset($_GET['transaction']) ? $_GET['transaction'] : '';
        $command = isset($_POST['command']) ? $_POST['command'] : '';

        if (!empty($action) && !empty($id) && !empty($command)) {
            try {
                $this->processActionCommand($id, $action, $command);
                $this->addNotice(__('Transaction update succeeded.', 'heartland-management-terminal'), 'notice-success');
            } catch (HpsException $e) {
                $this->addNotice(
                    sprintf(__('Transaction update failed. %s', 'heartland-management-terminal'), $e->getMessage()),
                    'notice-error'
                );
            }
        }

        if ($action === 'manage') {
            if (empty($id)) {
                wp_redirect(get_admin_url(null, 'admin.php?page=heartland-transactions'));
                wp_die();
                return;
            }

            $this->performManageAction($id);
            return;
        }

        $this->writeTransactionTable($this->getReport());
    }

    /**
     * Helper function for displaying notices in the plugin
     *
     * @param string $message Message to display
     * @param string $classes Notice CSS classes
     */
    protected function addNotice($message, $classes)
    {
        add_action('admin_notices', function () use ($message, $classes) {
            include_once plugin_dir_path(__FILE__)
                . '../../templates/admin/notice.php';
        });
    }

    /**
     * Processes commands
     *
     * Currently limited to the following commands for the manage page:
     *
     * - void transaction
     * - refund transaction
     *
     * @param string $id      Transaction ID
     * @param string $action  Current page
     * @param string $command Desired command
     *
     * @return HpsTransaction
     * @throws HpsException
     */
    protected function processActionCommand($id, $action, $command)
    {
        $service = new HpsFluentCreditService($this->getHeartlandConfiguration());

        if ($action === 'manage' && $command === 'void-transaction') {
            return $service->void()
                ->withTransactionId($id)
                ->execute();
        }

        if ($action === 'manage' && $command === 'refund-transaction') {
            $transaction = $service->get($id)->execute();
            $amount = !empty($transaction->settlementAmount)
                ? $transaction->settlementAmount
                : $transaction->authorizedAmount;
            $authAmount = isset($_POST['refund_amount']) && !empty($_POST['refund_amount'])
                ? $_POST['refund_amount']
                : false;

            $builder = $service->refund();

            if ($transaction->transactionStatus === 'A') {
                $builder = $service->reverse();
            }

            $builder = $builder
                ->withTransactionId($id)
                ->withCurrency('usd');

            if ($builder instanceof HpsCreditServiceRefundBuilder) {
                $builder = $builder->withAmount(
                    $authAmount !== false ? $authAmount : $amount
                );
            } elseif ($builder instanceof HpsCreditServiceReverseBuilder) {
                $builder = $builder
                    ->withAmount($transaction->authorizedAmount)
                    ->withAuthAmount(
                        $authAmount !== false ? ($amount - $authAmount) : null
                    );
            }

            return $builder->execute();
        }
    }

    /**
     * Helper function for displaying data
     *
     * @param string $data  Data to display, if present
     * @param string $empty Value to qualify `$data` as empty
     *
     * @return string
     */
    protected function dataOrDash($data, $empty = null)
    {
        return empty($data) || $data === $empty
            ? '&mdash;' : $data;
    }

    /**
     * Gets transaction report data
     *
     * Stores data within the `$this->code . '_data'` transient to enable caching.
     *
     * Date interval for the report (start date - end date) is configurable through the
     * "" option. Transient timeout is configurable through the "" option.
     *
     * @return HpsReportTransactionSummary[]
     */
    protected function getReport()
    {
        $items = get_transient($this->code . '_data');

        if (false !== $items) {
            return json_decode($items);
        }

        $defaultTZ = date_default_timezone_get();
        date_default_timezone_set('UTC');
        $service = new HpsCreditService($this->getHeartlandConfiguration());
        $dateFormat = 'Y-m-d\TH:i:s.00\Z';
        $dateMinus10 = new DateTime();
        $dateMinus10->sub(new DateInterval(sprintf('P%sD', $this->getSetting('report_date_interval', '10'))));
        $current = new DateTime();

        $items = $service->listTransactions($dateMinus10->format($dateFormat), $current->format($dateFormat));
        $filteredItems = $this->filterTransactions($items);

        if (!defined('HOUR_IN_SECONDS')) {
            define('HOUR_IN_SECONDS', 60 * 60);
        }

        set_transient(
            $this->code . '_data',
            /**
             * Filters the list transactions report
             *
             * @param HpsReportTransactionSummary[] $items
             */
            json_encode(apply_filters($this->code . '_report_items', $filteredItems)),
            $this->getSetting('report_transient_timeout', HOUR_IN_SECONDS / 2)
        );

        date_default_timezone_set($defaultTZ);
        return $filteredItems;
    }

    /**
     * Filters transaction report data with additional methods:
     *
     * - listTransactionsConvertExceptions
     * - listTransactionsStripUndesiredTypes
     *
     * @return HpsReportTransactionSummary[]
     */
    protected function filterTransactions($items)
    {
        return array_reverse(
            array_map(
                array($this, 'listTransactionsConvertExceptions'),
                array_filter($items, array($this, 'listTransactionsStripUndesiredTypes'))
            )
        );
    }

    /**
     * Removes unimportant transaction types from the transaction report
     *
     * @return HpsReportTransactionSummary[]
     */
    protected function listTransactionsStripUndesiredTypes($item)
    {
        return
            substr($item->serviceName, 0, strlen('Report')) !== 'Report'
            && !in_array($item->serviceName, array('GetAttachments'));
    }

    /**
     * Converts `Exception` objects in the transaction objects contained in the report
     * to `stdClass` objects to remove the stack trace within the exceptions
     *
     * @return HpsReportTransactionSummary[]
     */
    protected function listTransactionsConvertExceptions($item)
    {
        if (empty($item->exceptions)) {
            return $item;
        }

        if (!empty($item->exceptions->hpsException)) {
            $item->exceptions->hpsException = (object)array(
                'code' => $item->exceptions->hpsException->getCode(),
                'message' => $item->exceptions->hpsException->getMessage(),
                'details' => $item->exceptions->hpsException->details,
            );
        }

        if (!empty($item->exceptions->cardException)) {
            $item->exceptions->cardException = (object)array(
                'code' => $item->exceptions->cardException->getCode(),
                'message' => $item->exceptions->cardException->getMessage(),
                'details' => $item->exceptions->cardException->details,
            );
        }

        return $item;
    }

    /**
     * Attempts to display the desired transaction
     *
     * @param string $transactionId Desired transaction ID
     */
    protected function performManageAction($transactionId)
    {
        $service = new HpsFluentCreditService($this->getHeartlandConfiguration());
        $title = __('Heartland Payment Systems - Manage Transaction', 'heartland-management-terminal');
        $transaction = null;

        try {
            $transaction = $service->get($transactionId)->execute();
        } catch (HpsException $e) {
            $transaction = false;
        }

        include_once plugin_dir_path(__FILE__)
            . '../../templates/admin/manage-transaction.php';
    }

    /**
     * Stylizes the transaction status for merchant consumption
     *
     * @param HpsReportTransactionDetails $transaction Transaction details
     *
     * @return string
     */
    protected function transactionStatusPretty($transaction)
    {
        $status = $transaction->transactionStatus;

        switch ($status) {
            case 'A':
                $status = __('Active', 'heartland-management-terminal');
                break;
            case 'I':
                $status = __('Inactive', 'heartland-management-terminal');
                break;
            case 'C':
                $status = __('Cleared', 'heartland-management-terminal');
                break;
            case 'V':
                $status = __('Voided', 'heartland-management-terminal');
                break;
            case 'X':
                $status = __('Autovoided', 'heartland-management-terminal');
                break;
            case 'R':
                $status = __('Reversed', 'heartland-management-terminal');
                break;
            case 'T':
                $status = __('Timed-Out', 'heartland-management-terminal');
                break;
            default:
                break;
        }
        return $this->dataOrDash($status);
    }

    /**
     * Gets the configuration based on the merchant's secret API key
     *
     * @return HpsServicesConfig
     */
    protected function getHeartlandConfiguration()
    {
        $config = new HpsServicesConfig();
        $config->secretApiKey = $this->getSetting('secret_api_key');
        $config->versionNumber = '1510';
        $config->developerId = '002914';
        return $config;
    }

    /**
     * Builds the transaction list table
     */
    protected function writeTransactionTable($items)
    {
        $page = esc_url(get_admin_url(null, 'admin.php?page=heartland-transactions'));
        $pagenum = isset($_GET['pagenum']) ? absint($_GET['pagenum']) : 1;
        $limit = intval($this->getSetting('report_page_limit', '10'));
        $offset = ($pagenum - 1) * $limit;
        $total = count($items);
        $numOfPages = ceil($total/$limit);
        $items = array_slice($items, $offset, $limit);
        include_once plugin_dir_path(__FILE__)
            . '../../templates/admin/list-transactions.php';
    }
}
