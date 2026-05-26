<?php
$crumbs = $breadcrumbs ?? [];
if (!$crumbs) return;
?>
<nav aria-label="Breadcrumb" class="container-page text-sm text-slate-500 py-4">
  <ol class="flex flex-wrap gap-1">
    <?php foreach ($crumbs as $i => $c): ?>
      <li>
        <?php if ($i === count($crumbs) - 1): ?>
          <span class="text-navy font-semibold"><?= e($c['name']) ?></span>
        <?php else: ?>
          <a class="hover:text-navy" href="<?= e($c['url']) ?>"><?= e($c['name']) ?></a>
          <span class="mx-1 text-slate-400">/</span>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ol>
</nav>
