<?php

/**
 * Plugin Name: WordPress Back End Challenge
 * Plugin URI: https://github.com/gustavodscruz/wordpress-back-end-challenge
 * Description: Plugin desenvolvido para o desafio de back-end WordPress.
 * Version: 1.0.0
 * Author: Gustavo Dias
 * Author URI: https://github.com/gustavodscruz
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp-backend-challenge
 * Domain Path: /languages
 * 
 * PHP version 8.1
 * 
 * @category Wpbackendchallenge
 * 
 * @package Wpbackendchallenge
 * 
 * @author Gustavo Dias <gustavodiasdsc@gmail.com>
 * 
 * @license http://opensource.org/licenses/MIT MIT
 * 
 * @link https://github.com/gustavodscruz/wordpress-back-end-challenge
 */

// Evita acesso direto
if (!defined('ABSPATH')) {
    exit;
}

// Definir constantes do plugin
define('WP_BACKEND_CHALLENGE_VERSION', '1.0.0');
define('WP_BACKEND_CHALLENGE_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WP_BACKEND_CHALLENGE_PLUGIN_PATH', plugin_dir_path(__FILE__));

// Incluir arquivos apenas quando o WordPress estiver carregado
add_action(
    'plugins_loaded', function () {
        include_once WP_BACKEND_CHALLENGE_PLUGIN_PATH . 'includes/main.php';
        WP_Backend_Challenge::getInstance();
    }
);



/**
 * Chama a criação de tabela de usuários
 *
 * @return void
 */
function wpfActivate()
{
    include_once WP_BACKEND_CHALLENGE_PLUGIN_PATH . 'includes/main.php';
    WP_Backend_Challenge::createTable();
}

register_activation_hook(__FILE__, 'wpfActivate');

