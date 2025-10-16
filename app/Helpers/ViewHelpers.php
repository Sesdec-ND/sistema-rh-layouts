<?php

if (!function_exists('showDebugInfo')) {
    function showDebugInfo() {
        if (app()->environment('local')) {
            $route = app('Illuminate\Routing\Route');
            return sprintf(
                "<!-- Controller: %s | Method: %s | File: %s -->",
                get_class($route->getController()),
                $route->getActionMethod(),
                debug_backtrace()[1]['file'] ?? 'N/A'
            );
        }
        return '';
    }
}