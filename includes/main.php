<?php

/**
 * Classe principal do plugin WordPress Back End Challenge
 *
 * @category Wpbackendchallenge
 * @package  Wpbackendchallenge/includes
 * @author   Gustavo Dias <gustavodiasdsc@gmail.com>
 * @license  GPL v2 or later
 * @link     https://github.com/gustavodscruz/wordpress-back-end-challenge
 */

// Evita acesso direto
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class WP_Backend_Challenge
 *
 * Handles the backend challenge functionality for WordPress.
 * 
 * @category Wpbackendchallenge
 * 
 * @package WordPress_Back_End_Challenge
 * 
 * @author Gustavo Dias <gustavodiasdsc@gmail.com>
 * 
 * @license http://opensource.org/licenses/MIT MIT
 * 
 * @link https://github.com/gustavodiasdsc/wordpress-back-end-challenge
 */
class WP_Backend_Challenge
{

    /**
     * Instância única da classe
     */
    private static $_instance = null;
    private $_table_name;

    /**
     * Construtor privado para implementar Singleton
     */
    private function __construct()
    {
        global $wpdb;
        $this->_table_name = $wpdb->prefix . 'wp_backend_challenge';
        $this->_initHooks();
    }

    /**
     * Retorna a instância única da classe
     * 
     * @return WP_Backend_Challenge
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Inicializa os hooks do WordPress
     * 
     * @return void
     */
    private function _initHooks()
    {
        add_action('admin_notices', array($this, 'displayAdminNotice'));
    }

    /**
     * Exibe uma notificação na área de administração
     *
     * @return void
     */
    public function displayAdminNotice()
    {
        $message = esc_html__(
            'Plugin WordPress Back End Challenge ativado com sucesso! 2.0!!!!! Eba!',
            'wp-backend-challenge'
        );

        echo '<div class="notice notice-success is-dismissible">
            <p>' . $message . '</p>
        </div>';
    }

    /**
     * Cria tabela no mysql
     *
     * @return void
     */
    public static function createTable()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'wp_backend_challenge';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id int NOT NULL AUTO_INCREMENT,
            user_id bigint(20) UNSIGNED NOT NULL,
            post_id bigint(20) UNSIGNED NOT NULL,
            date_favorited datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY (user_id, post_id)
        ) $charset_collate;";

        include_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    
}
