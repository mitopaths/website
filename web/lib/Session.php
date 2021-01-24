<?php
/**
 * Session manager.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths
 */
namespace Mitopaths;

/**
 * Session manager.
 * 
 * Defines methods to handle common operations on sessions, acting as
 * a proxy.
 * 
 * This class follows the Proxy Design Pattern.
 * 
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths
 */
class Session {
    /**
     * Initializes a session.
     */
    private static function initialize() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }


    /**
     * Tells whether a user is authenticated.
     * 
     * @return bool True if user is authenticated, false otherwise
     * @api
     */
    public static function isAuthenticated() {
        self::initialize();
        return isset($_SESSION['user_id']);
    }


    /**
     * Returns authenticated user.
     * 
     * @return \Mitopaths\Model\User Authenticated user
     * @throw \Exception if user is not authenticated
     * @api
     */
    public static function getUser() {
        self::initialize();
        
        if (!isset($_SESSION['user_id'])) {
            throw new \Exception("User is not authenticated");
        }

        $user_mapper = new \Mitopaths\DataMapper\User();
        return $user_mapper->read($_SESSION['user_id']);
    }



    /**
     * Authenticates a user.
     *
     * @param \Mitopaths\Model\User $user User to authenticate
     * @api
     */
    public static function create(\Mitopaths\Model\User $user) {
        self::initialize();
        
        $_SESSION['user_id'] = $user->getId();
    }
    
    /**
     * Logs out a user.
     * 
     * @api
     */
    public static function logout() {
        self::initialize();
        
        unset($_SESSION['user_id']);
    }



    /**
     * Throws an exception if user is not authenticated.
     * 
     * @throws \Exception if user is not authenticated
     * @api
     */
    public static function requireAuthentication() {
        self::initialize();

        if (!self::isAuthenticated()) {
            throw new \Exception("Authentication required.");
        }
    }
}
