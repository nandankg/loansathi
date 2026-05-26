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
}
