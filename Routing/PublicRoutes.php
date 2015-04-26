<?php

namespace MessageAutoReplies\Routing;

use XenForo_RouteMatch;
use XenForo_Router;
use Zend_Controller_Request_Http;

class PublicRoutes {

    /**
     * Handles routing
     * @param $routePath
     * @param Zend_Controller_Request_Http $request
     * @param XenForo_Router $router
     * @return XenForo_RouteMatch
     */
    public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router) {
        $path = explode("/", $routePath);
        if ($path[0] == "formatters") {
            return $router->getRouteMatch('MessageAutoReplies\ControllerPublic\Formatters', "showHelp");
        }
    }
} 