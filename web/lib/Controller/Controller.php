<?php
/**
 * Abstract controller.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths\Controller
 */
namespace Mitopaths\Controller;

/**
 * Abstract class of a controller.
 * 
 * Gives a basic implementation of a ControllerInterface.
 *
 * This abstract class follows the Model View Controller Design Pattern.
 * 
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths\Controller
 */
abstract class Controller implements ControllerInterface {
    /**
     * Method to call on POST requests.
     * 
     * @param array Associative array of additional parameters
     * @return $this This controller itself
     * @throws \Exception Method not available
     * @api
     */
    public function post($binders = []) {
        throw new \Exception(__CLASS__ . " does not accept POST requests.\n");
    }
    
    /**
     * Method to call on GET requests.
     * 
     * @param array Associative array of additional parameters
     * @return $this This controller itself
     * @throws \Exception Method not available
     * @api
     */
    public function get($binders = []) {
        throw new \Exception(__CLASS__ . " does not accept GET requests.\n");
    }
    
    /**
     * Method to call on PUT requests.
     * 
     * @param array Associative array of additional parameters
     * @return $this This controller itself
     * @throws \Exception Method not available
     * @api
     */
    public function put($binders = []) {
        throw new \Exception(__CLASS__ . " does not accept PUT requests.\n");
    }
    
    /**
     * Method to call on DELETE requests.
     * 
     * @param array Associative array of additional parameters
     * @return $this This controller itself
     * @throws \Exception Method not available
     * @api
     */
    public function delete($binders = []) {
        throw new \Exception(__CLASS__ . " does not accept DELETE requests.\n");
    }



    /**
     * Calls a view from this controller.
     * 
     * @param string $name Name of the view
     * @param array $_variables Associative array of variables to inject
     * @return $this This controller itself
     */
    protected function view($name, $_variables = []) {
        $_path = 'lib/View/' . $name . '.php'; 
        foreach ($_variables as $name => $value) {
            $$name = $value;
        }

        if (is_readable($_path)) {
            include $_path;
        }

        return $this;
    }
    
    
    
    /**
     * Checks whether required parameters were supplied.
     *
     * Throws an exception if one or more parameters is missing.
     *
     * @param array $parameters Actual array of parameters
     * @param array $required Array of required parameters
     * @return $this This controller itself
     * @throws \Exception At least one parameter is missing
     */
    protected function requiredParameters($parameters = [], $required = []) {
        foreach ($required as $parameter_name) {
            if (!array_key_exists($parameter_name, $parameters) || !isset($parameters[$parameter_name])) {
                throw new \Exception("Parameter $parameter_name is missing");
            }
        }

        return $this;
    }

    
    
    /**
     * Checks whether optional parameters were supplied.
     *
     * Updates missing parameters with their default values, if non null.
     *
     * @param array $parameters Actual array of parameters
     * @param array $default Array of optional parameters with their default value
     * @return $this This controller itself
     */
    protected function optionalParameters(&$parameters = [], $default = []) {
        foreach ($default as $name => $value) {
            if (!array_key_exists($name, $parameters)) {
                $parameters[$name] = $value;
            }
        }

        return $this;
    }
}
