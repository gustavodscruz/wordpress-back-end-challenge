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

    /**
     * Adiciona botão de favorito
     *
     * @param string $content Conteúdo em html
     * 
     * @return string $content Conteúdo em html com o botão
     */
    public function addFavoriteButton(string $content)
    {
        if (!(is_singular('post') && is_user_logged_in())) {
            return $content;
        }

        $user_id = get_current_user_id();
        $post_id = get_the_ID();

        $is_favorited = $this->_isPostFavorited($user_id, $post_id);
        $button_text = $is_favorited
            ? __('Desfavoritar', 'wp_backend_challenge')
            : __('Favoritar', 'wp_backend_challenge');
        $button_class = $is_favorited ? 'favorited' :  '';
        $button_html = '<p><a href="#" class="wpb-favorite-button '
            . $button_class
            . '" data-post-id="'
            . $post_id
            . '">'
            . $button_text
            . '</a></p>';
        return $content . $button_html;
    }

    /**
     * Função que verifica pelos ids se o post está favoritado ou não
     *
     * @param string|integer $user_id Id do usuário
     * @param string|integer $post_id Id do post
     * 
     * @return bool retorna verdadeiro se o post estiver favoritado
     */
    private function _isPostFavorited(string|int $user_id, string|int $post_id)
    {
        /**
         * Banco de dados do wordpress
         * 
         * @var wpdb $wpdb
         */
        global $wpdb;
        $count = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT (*) FROM {$this->_table_name} WHERE user_id = %d AND post_id = %d",
                $user_id,
                $post_id
            )
        );
        return $count > 0;
    }
}
