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
 * @package Wpbackendchallenge/includes
 * 
 * @author  Gustavo Dias <gustavodiasdsc@gmail.com>
 * @license GPL v2 or later
 * @link    https://github.com/gustavodscruz/wordpress-back-end-challenge
 */

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
    
    /**
     * Construtor privado para implementar Singleton
     */
    private function __construct() 
    {
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

    }
    
    
}
