<?php
// app/Views/Pagers/custom.php
// Template de paginação customizado (Bootstrap-like)

$pager->setSurroundCount(2);
?>

<?php if ($pager && count($pager->links()) > 0): ?>
    <nav aria-label="Navegação de páginas">
        <ul class="pagination justify-content-center mb-0">
            <?php if (method_exists($pager, 'hasPreviousPage') ? $pager->hasPreviousPage() : $pager->hasPrevious()): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= method_exists($pager, 'getFirstPageURI') ? $pager->getFirstPageURI() : $pager->getFirst() ?>" aria-label="Primeira">
                        <i class="fas fa-angle-double-left"></i>
                    </a>
                </li>

                <li class="page-item">
                    <a class="page-link" href="<?= method_exists($pager, 'getPreviousPageURI') ? $pager->getPreviousPageURI() : $pager->getPrevious() ?>" aria-label="Anterior">
                        <i class="fas fa-angle-left"></i>
                    </a>
                </li>
            <?php endif; ?>

            <?php foreach ($pager->links() as $link): ?>
                <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                    <a class="page-link" href="<?= esc($link['uri']) ?>">
                        <?= esc($link['title']) ?>
                    </a>
                </li>
            <?php endforeach; ?>

            <?php if (method_exists($pager, 'hasNextPage') ? $pager->hasNextPage() : $pager->hasNext()): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= method_exists($pager, 'getNextPageURI') ? $pager->getNextPageURI() : $pager->getNext() ?>" aria-label="Próxima">
                        <i class="fas fa-angle-right"></i>
                    </a>
                </li>

                <li class="page-item">
                    <a class="page-link" href="<?= method_exists($pager, 'getLastPageURI') ? $pager->getLastPageURI() : $pager->getLast() ?>" aria-label="Última">
                        <i class="fas fa-angle-double-right"></i>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>