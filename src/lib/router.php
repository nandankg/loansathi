<?php

function routes_table(): array {
    return [
        '/'                 => 'home',
        '/submit-lead'      => 'handlers/submit-lead',
        '/thank-you'        => 'thank-you',
    ];
}

/**
 * Match a path against a routes table.
 * Returns ['page' => '...', 'params' => [...]] or null.
 */
function match_route(string $path, array $routes): ?array {
    $path = '/' . trim(preg_replace('#/+#', '/', $path), '/');
    if ($path === '/' && isset($routes['/'])) {
        return ['page' => $routes['/'], 'params' => []];
    }

    foreach ($routes as $pattern => $page) {
        if ($pattern === '/') continue;
        $regex = '#^' . preg_replace('#\{([a-z_]+)\}#', '(?P<$1>[^/]+)', $pattern) . '$#';
        if (preg_match($regex, $path, $m)) {
            $params = [];
            foreach ($m as $k => $v) {
                if (!is_int($k)) $params[$k] = $v;
            }
            return ['page' => $page, 'params' => $params];
        }
    }
    return null;
}

function route(string $path): void {
    $match = match_route($path, routes_table());
    if ($match === null) {
        http_response_code(404);
        require __DIR__ . '/../pages/404.php';
        return;
    }
    $GLOBALS['route_params'] = $match['params'];
    $page = $match['page'];
    $subdir = str_starts_with($page, 'handlers/') ? '' : 'pages/';
    $file = __DIR__ . '/../' . $subdir . $page . '.php';
    if (!file_exists($file)) {
        http_response_code(404);
        require __DIR__ . '/../pages/404.php';
        return;
    }
    require $file;
}
