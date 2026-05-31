<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/lib/router.php';

class RouterTest extends TestCase
{
    public function test_matches_static_route(): void
    {
        $routes = ['/' => 'home', '/about' => 'about'];
        $this->assertSame(['page' => 'home', 'params' => []], match_route('/', $routes));
        $this->assertSame(['page' => 'about', 'params' => []], match_route('/about', $routes));
    }

    public function test_matches_dynamic_route(): void
    {
        $routes = ['/blog/{slug}' => 'blog-post'];
        $result = match_route('/blog/hello-world', $routes);
        $this->assertSame('blog-post', $result['page']);
        $this->assertSame(['slug' => 'hello-world'], $result['params']);
    }

    public function test_returns_null_on_no_match(): void
    {
        $routes = ['/' => 'home'];
        $this->assertNull(match_route('/nope', $routes));
    }

    public function test_strips_trailing_slash(): void
    {
        $routes = ['/about' => 'about'];
        $this->assertSame('about', match_route('/about/', $routes)['page']);
    }

    public function test_multiple_params(): void
    {
        $routes = ['/admin/posts/{id}/edit' => 'admin/post-edit'];
        $result = match_route('/admin/posts/42/edit', $routes);
        $this->assertSame('admin/post-edit', $result['page']);
        $this->assertSame(['id' => '42'], $result['params']);
    }

    public function test_admin_lead_route_is_registered(): void
    {
        $result = match_route('/admin/leads/42', routes_table());
        $this->assertSame('admin/lead-detail', $result['page']);
        $this->assertSame(['id' => '42'], $result['params']);
    }

    /**
     * Compliance & education-funnel routes must resolve to real pages, not the
     * 'coming-soon' stub, and each page file must exist.
     */
    public function test_compliance_and_education_routes_are_live(): void
    {
        $routes = routes_table();
        $expected = [
            '/privacy-policy'      => 'privacy-policy',
            '/terms-of-service'    => 'terms-of-service',
            '/disclaimer'          => 'disclaimer',
            '/about'               => 'about',
            '/contact'             => 'contact',
            '/emi-calculator'      => 'emi-calculator',
            '/eligibility-checker' => 'eligibility-checker',
            '/loan-comparison'     => 'loan-comparison',
            '/application-guide'   => 'application-guide',
        ];
        foreach ($expected as $path => $page) {
            $result = match_route($path, $routes);
            $this->assertNotNull($result, "Route $path should match");
            $this->assertSame($page, $result['page'], "Route $path should map to $page, not a stub");
            $this->assertFileExists(
                __DIR__ . '/../../src/pages/' . $page . '.php',
                "Page file for $path should exist"
            );
        }
    }
}
