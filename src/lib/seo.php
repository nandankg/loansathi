<?php

function ld_organization(): array {
    return [
        '@context' => 'https://schema.org',
        '@type'    => 'Organization',
        'name'     => config('site_name'),
        'url'      => config('base_url'),
        'logo'     => asset('images/logo.svg'),
        'contactPoint' => [[
            '@type'         => 'ContactPoint',
            'telephone'     => config('contact.phone'),
            'contactType'   => 'customer service',
            'areaServed'    => 'IN',
            'availableLanguage' => ['English', 'Hindi'],
        ]],
    ];
}

function ld_breadcrumbs(array $crumbs): array {
    $items = [];
    foreach ($crumbs as $i => $c) {
        $items[] = [
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'name'     => $c['name'],
            'item'     => $c['url'],
        ];
    }
    return ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $items];
}

function render_json_ld(array ...$schemas): string {
    $out = '';
    foreach ($schemas as $s) {
        $out .= '<script type="application/ld+json">' . json_encode($s, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
    return $out;
}
