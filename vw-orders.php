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
    $tablePayments = $wpdb->prefix . 'vworders_payment';
    $tableItems = $wpdb->prefix . 'vworders_item';
    $charset_collate = $wpdb->get_charset_collate();

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    $sql = "CREATE TABLE IF NOT EXISTS $tableOrders (
         id INT UNSIGNED NOT NULL AUTO_INCREMENT,
         order_number VARCHAR(45) NULL,
         order_date DATE NULL DEFAULT NULL,
         order_client VARCHAR(255) NULL,
         order_cpf_cnpj VARCHAR(45) NULL,
         order_zip VARCHAR(45) NULL,
         order_address VARCHAR(255) NULL,
         order_email VARCHAR(255) NULL,
         order_phone VARCHAR(45) NULL,
         order_mobile VARCHAR(45) NULL,
         order_total VARCHAR(45) NULL,
         order_print_color VARCHAR(45) NULL,
         order_date_delivery DATE NULL DEFAULT NULL,
         order_delivery_name VARCHAR(45) NULL,
         order_delivery_type VARCHAR(45) NULL,
         order_payment_notes VARCHAR(45) NULL,
         PRIMARY KEY (id))
       $charset_collate;";
    dbDelta($sql);

    $sql = "CREATE TABLE IF NOT EXISTS $tablePayments (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        vworders_id INT UNSIGNED NOT NULL,
        days VARCHAR(45) NULL,
        date VARCHAR(45) NULL,
        method VARCHAR(45) NULL,
        value VARCHAR(45) NULL,
        notes VARCHAR(45) NULL,
        PRIMARY KEY (id, vworders_id))
      $charset_collate;";
    dbDelta($sql);

    $sql = "CREATE TABLE IF NOT EXISTS $tableItems (
      id INT UNSIGNED NOT NULL AUTO_INCREMENT,
      vworders_id INT UNSIGNED NOT NULL,
      item VARCHAR(45) NULL,
      color VARCHAR(45) NULL,
      amount VARCHAR(45) NULL,
      value VARCHAR(45) NULL,
      total VARCHAR(45) NULL,
      PRIMARY KEY (id, vworders_id))
      $charset_collate;";
    dbDelta($sql);

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
    wp_enqueue_script('jquery-serialize', plugin_dir_url(__FILE__) . 'js/jquery.serializejson.min.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('vw_orders', plugin_dir_url( __FILE__ ) . 'js/default.js', array('jquery', 'bootstrap', 'jquery-mask', 'jquery-serialize'), '1.0.0', true);
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

    $table_data = $wpdb->prefix . 'vworders';
    $table_type = $wpdb->prefix . 'vworders_item';
    $table_payments = $wpdb->prefix . 'vworders_payment';

    $data = $_POST['data'];
    $orderDate = explode('/', $data['order-date']);
    $orderDelivery = explode('/', $data['order-date-delivery']);
    $dataArr = array(
      'id'                  => null,
      'order_number'        => $data['order-number'],
      'order_date'          => $orderDate[2] . '-' . $orderDate[1] . '-' . $orderDate[0],
      'order_client'        => $data['order-client'],
      'order_cpf_cnpj'      => $data['order-cpf-cnpj'],
      'order_zip'           => $data['order-zip'],
      'order_address'       => $data['order-address'],
      'order_email'         => $data['order-email'],
      'order_phone'         => $data['order-phone'],
      'order_mobile'        => $data['order-mobile'],
      'order_total'         => $data['order-total'],
      'order_print_color'   => $data['order-print-color'],
      'order_date_delivery' => $orderDelivery[2] . '-' . $orderDelivery[1] . '-' . $orderDelivery[0],
      'order_delivery_name' => $data['order-delivery-name'],
      'order_delivery_type' => $data['order-delivery-type'],
      'order_payment_notes' => $data['order-payment-notes']
    );
    $wpdb->insert($table_data, $dataArr);
    if($wpdb->last_error !== ''){
        // $wpdb->print_error();
        status_header(400);
        $str = htmlspecialchars( $wpdb->last_result, ENT_QUOTES ) . ' // // // ' . htmlspecialchars( $wpdb->last_query, ENT_QUOTES );
        print_r(json_encode(array('response' => $str)));
        wp_die();
    }
    $id = $wpdb->insert_id;

    foreach($data['order-type'] as $type){
      $typeArr = $type;
      $typeArr['vworders_id'] = $id;
      $wpdb->insert($table_type, $typeArr);
      if($wpdb->last_error !== ''){
          // $wpdb->print_error();
          status_header(400);
          $str = htmlspecialchars( $wpdb->last_result, ENT_QUOTES ) . ' // // // ' . htmlspecialchars( $wpdb->last_query, ENT_QUOTES );
          print_r(json_encode(array('response' => $str)));
          wp_die();
      }
    }
    foreach($data['order-payment'] as $payment){
      $paymentArr = $payment;
      $paymentArr['vworders_id'] = $id;
      $wpdb->insert($table_payments, $paymentArr);
      if($wpdb->last_error !== ''){
          // $wpdb->print_error();
          status_header(400);
          $str = htmlspecialchars( $wpdb->last_result, ENT_QUOTES ) . ' // // // ' . htmlspecialchars( $wpdb->last_query, ENT_QUOTES );
          print_r(json_encode(array('response' => $str)));
          wp_die();
      }
    }

    echo json_encode(array('response' => 'Pedido cadastrado com sucesso!'));
    $wpdb->flush();
    wp_die();
  }

  public function vworders_report(){

  }
}

new VW_Orders();
