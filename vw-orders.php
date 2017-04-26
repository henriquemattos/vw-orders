<?php
/*
Plugin Name: VW Orders
Plugin URI:  https://www.visualworks.com.br/wordpress/plugins/vw-orders
Description: Create orders, print PDF versions for customers and filter totals.
Version:     0.0.4
Author:      Visual Works
Author URI:  https://www.visualworks.com.br
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: vworders
Domain Path: /languages
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class VW_Orders {
  private $vworders_db_version = '1.0';

  public function __construct(){
    register_activation_hook( __FILE__, array($this,'vworders_install'));
    // register_deactivation_hook(__FILE__, array($this, 'vworders_uninstall'));
    // add_action('plugins_loaded', 'vworders_update_db_check');
    if(is_admin()){
      add_action('admin_menu', array($this, 'vworders_admin_menu'));
      add_action('admin_init',array($this, 'vworders_init'));
      add_action('wp_ajax_save', array($this, 'save'));
      add_action('wp_ajax_nopriv_save', array($this, 'save'));
    }
  }

  public function vworders_install(){
    global $wpdb;
    $tableOrders = $wpdb->prefix . 'vworders';
    $charset_collate = $wpdb->get_charset_collate();

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    $sql = "CREATE TABLE IF NOT EXISTS $tableOrders (
      vworders_id INT NOT NULL AUTO_INCREMENT,
      vworders_order VARCHAR(45) NULL,
      vworders_date DATE NULL,
      vworders_client VARCHAR(255) NULL,
      vworders_cpf_cnpj VARCHAR(45) NULL,
      vworders_zip VARCHAR(45) NULL,
      vworders_address VARCHAR(255) NULL,
      vworders_email VARCHAR(255) NULL,
      vworders_phone VARCHAR(45) NULL,
      vworders_mobile VARCHAR(45) NULL,
      vworders_print_color VARCHAR(45) NULL,
      vworders_delivery_date VARCHAR(45) NULL,
      vworders_extras_costs VARCHAR(45) NULL,
      vworders_delivery_price VARCHAR(45) NULL,
      vworders_total VARCHAR(45) NULL,
      vworders_payment_days VARCHAR(45) NULL,
      vworders_payment_method VARCHAR(45) NULL,
      vworders_payment_value VARCHAR(45) NULL,
      vworders_obs VARCHAR(45) NULL,
      PRIMARY KEY (vworders_id),
      UNIQUE INDEX id_UNIQUE (vworders_id ASC))
     $charset_collate;";
	    dbDelta($sql);

      // create order products
      $tableProducts = $wpdb->prefix . 'vworders_products';
      $sqlProducts = "CREATE TABLE IF NOT EXISTS $tableProducts (
        vworders_product_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        vworders_product_color VARCHAR(45) NULL,
        vworders_product_amount VARCHAR(45) NULL,
        vworders_product_unit VARCHAR(45) NULL,
        vworders_product_total VARCHAR(45) NULL,
        vworders_products_type VARCHAR(45) NULL,
        vworders_vworders_id INT NOT NULL,
        PRIMARY KEY (vworders_product_id, vworders_vworders_id),
        UNIQUE INDEX vworders_product_id_UNIQUE (vworders_product_id ASC))
         $charset_collate;";
    	    dbDelta($sqlProducts);
      add_option('vworders_db_version', $this->vworders_db_version);
  }

  public function vworders_uninstall(){
    /*
    global $wpdb;
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    $tableOrders = $wpdb->prefix . 'vworders';
    $sqlOrders = "DROP TABLE IF EXISTS $tableOrders";
    dbDelta($sqlOrders);
    $tableProducts = $wpdb->prefix . 'vworders_products';
    $sqlProducts = "DROP TABLE IF EXISTS $tableProducts";
    dbDelta($sqlProducts);
    delete_option('vworders_db_version');
    */
  }

  public function vworders_update_db_check() {
    /*
    global $vworders_db_version;
    if(get_site_option('vworders_db_version') != $vworders_db_version){
        $this->vworders_install();
    }
    */
  }

  public function vworders_admin_menu(){
    add_menu_page( 'Todos os Pedidos','Pedidos','publish_posts','vw-orders.php', array($this, 'vworders_create'), 'dashicons-analytics' );
    add_submenu_page( 'vw-orders.php', 'Adicionar Pedido', 'Adicionar Pedido', 'publish_posts', 'vw-orders-report.php', array($this, 'vworders_create') );
    add_submenu_page( 'vw-orders.php', 'Gerar Relatórios', 'Gerar Relatórios', 'publish_posts', 'vw-orders-report.php', array($this, 'vworders_report') );
  }

  public function vworders_init(){
    wp_register_style('bootstrap',  plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css');
    wp_enqueue_style('bootstrap');
    wp_register_style('bootstrap-theme',  plugin_dir_url( __FILE__ ) . 'css/bootstrap-theme.min.css', array('bootstrap'));
    wp_enqueue_style('bootstrap-theme');
    wp_register_style('vworders-default',  plugin_dir_url( __FILE__ ) . 'css/default.css', array('bootstrap', 'bootstrap-theme'));
    wp_enqueue_style('vworders-default');
    wp_enqueue_script('bootstrap', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('jquery-mask', plugin_dir_url( __FILE__ ) . 'js/jquery.mask.min.js', array('jquery', 'bootstrap'), '1.0.0', true);
    wp_enqueue_script('vw_orders', plugin_dir_url( __FILE__ ) . 'js/default.js', array('jquery', 'bootstrap', 'jquery-mask'), '1.0.0', true);
    wp_localize_script('vw_orders', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php'),'nonce' => wp_create_nonce('vworders_save_nonce')));
  }

  public function vworders_create(){
    include_once 'template-vworders.php';
  }

  public function save(){
    global $wpdb;
    ob_clean();

    if(!isset($_POST['data'])){
      echo 'You must POST some data to this action';
      wp_die();
    }

    $data = explode('&', urldecode($_POST['data']));
    $finalArr = array();
    foreach($data as $chunk){
      $param = explode('=', $chunk);
      $finalArr[$param[0]] = $param[1];
    }
    $table_name = $wpdb->prefix . 'vworders';
    $orderDate = explode('/', $finalArr['order-date']);
    $dataArr = array(
      'vworders_order'          => $finalArr['order-number'],
      'vworders_date'           => $orderDate[2] . '-' . $orderDate[1] . '-' . $orderDate[0],
      'vworders_client'         => $finalArr['order-client'],
      'vworders_cpf_cnpj'       => $finalArr['order-cpf-cnpj'],
      'vworders_zip'            => $finalArr['order-zip'],
      'vworders_address'        => $finalArr['order-address'],
      'vworders_email'          => $finalArr['order-email'],
      'vworders_phone'          => $finalArr['order-phone'],
      'vworders_mobile'         => $finalArr['order-mobile'],
      'vworders_print_color'    => $finalArr['order-print-color'],
      'vworders_delivery_date'  => $finalArr['order-date-delivery'],
      'vworders_extras_costs'   => $finalArr[''],
      'vworders_delivery_price' => $finalArr['order-frete-value'],
      'vworders_total'          => $finalArr['order-total'],
      'vworders_payment_days'   => $finalArr['order-days-payment'],
      ## order-date-payment
      'vworders_payment_method' => $finalArr['order-payment-method'],
      'vworders_payment_value'  => $finalArr['order-payment-value'],
      'vworders_obs'            => $finalArr['order-payment-notes']
    );
    $wpdb->insert($table_name, $dataArr);

    $productArr = array();
    $finalProductArr = array();
    foreach($finalArr as $key => $value){
      if(strpos($key, 'order-type') !== false){
        $productArr[$key] = $value;
      }
    }
    $i = 0;
    foreach($productArr as $key => $value){
      for($j=0;$j<5;$j++){
         array_push($finalProductArr[$i], array($key => $value));
      }
      $i++;
    }
    print_r($finalProductArr);
    wp_die();
  }

  public function vworders_report(){

  }
}

new VW_Orders();
