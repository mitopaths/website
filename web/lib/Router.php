<?php
/**
 * Generic conjunction.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 * @package Mitopaths
 */
namespace Mitopaths;

/**
 * Router.
 * 
 * This class exhibits a Fluent Interface.
 * 
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 mitopatHs
 * @package Mitopaths
 */
class Router {
    /**
     * @var bool $matched Tells whether a route already matched
     */
    private $matched = false;


    /**
     * Declares a route.
     *
     * Patterns may use paramters or optional parameters, in the form of:
     * /path/{parameter}/{optional_parameter?}/other_path.
     * 
     * @param string $pattern Pattern to match
     * @param string $controller_name Fully qualified name of controller to use
     * @return $this This router itself
     * @api
     * @note This method expects global arrays such as $_SERVER to be set
     */
    public function declareRoute($pattern, $controller_name) {
        if ($this->matched) {
            return $this;
        }

        $binders = $this->routeMatch($pattern, $_SERVER['REQUEST_URI']);

        // Returns if route does not match
        if ($binders === false) {
            return $this;
        }

        $controller = new $controller_name();
        $method = $this->getMethod();

        $controller->$method($binders);
        $this->matched = true;

        return $this;
    }



    /**
     * Declares a default route.
     * 
     * Uses route incontitionately, usually to show a 404 error page.
     * 
     * @param string $controller_name Fully qualified name of controller to use
     * @api
     */
    public function defaultRoute($controller_name) {
        if ($this->matched) {
            return $this;
        }

        $controller = new $controller_name();
        $method = $this->getMethod();

        $controller->$method([]);
        $this->matched = true;

        return $this;
    }



    /**
     * Checks whether given URI matches a pattern.
     * 
     * Returns an associative array of parameters and values, or false
     * if the URI does not match.
     * 
     * @param string $pattern Pattern to check
     * @param string $requested_uri URi to check
     * @return array|bool Array of buond parameters or false
     */
    protected function routeMatch($pattern, $requested_uri) {
        // Converts a piece of pattern into a piece of regular expression
        $string_to_regexp = function ($string) {
            if (preg_match('/\{([^\?}]*)(\?)?\}/', $string, $matches)) {
                $label = $matches[1];
                $optional = isset($matches[2]) ? '?' : '';
                return [$label => '(\/([^\/]*))' . $optional];
            }
            return [$string => '\/' . $string];
        };

        // Converts the pattern into a regular expression
        $pieces = explode('/', $pattern);
        $pieces = array_filter($pieces, 'strlen');
        $pieces = array_map($string_to_regexp, $pieces);
        $pieces = array_reduce($pieces, 'array_merge', []);
        $regexp = '/^' . implode('', array_values($pieces)) . '$/';

        // Removes query string
        $requested_uri = parse_url($requested_uri, PHP_URL_PATH);

        // Returns false if the URI does not match
        if (preg_match($regexp, $requested_uri, $matches) === 0) {
            return false;
        }

        // Matches and reads parameters
        $binders = [];
        $i = 0;
        foreach ($pieces as $label => $regexp) {
            if (strpos($regexp, '(\/([^\/]*))') !== 0) {
                continue;
            }

            $offset = 2 + 2 * $i;
            $binders[$label] = isset($matches[$offset]) ? urldecode($matches[$offset]) : null;
            ++$i;
        }

        return $binders;
    }



    /**
     * Returns name of request method.
     * 
     * Returns 'get' if method could not be detected.
     * 
     * @return string Name of request method.
     */
    protected function getMethod() {
        if (!isset($_SERVER['REQUEST_METHOD'])) {
            return 'get';
        }
        elseif (isset($_POST['_method'])) {
            return strtolower($_POST['_method']);
        }
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}
