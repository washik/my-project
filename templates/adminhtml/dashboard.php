<?php

// tree
$this->getChildren();
$this->createTree();
$tree = $this->getTree();
// tree

?>

<p><a href="/admin/item/add">Add item</a></p>

<?php if (!empty($tree)): ?>
    <?php foreach ($tree as $option): ?>
        <?php echo str_repeat('|--- ', $option['level']) ?> <?php echo $option['title'] ?> <a href="/admin/item/add?item=<?php echo $option['id'] ?>">[Edit]</a><br>
    <?php endforeach; ?>
<?php endif; ?>
