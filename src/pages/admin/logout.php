<?php
require_once __DIR__ . '/../../lib/auth.php';

if (admin_user() !== null) {
    admin_logout();
}

redirect('/admin/login');
