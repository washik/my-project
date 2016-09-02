<?php

// tree
$this->getParents();
$this->createTree();
$tree = $this->getTree();
// tree



?>


<?php foreach ($tree as $option): ?>
    <?php echo str_repeat('|--- ', $option['level']) . $option['title'] ?> <?php echo $option['title'] ?> <a href="/admin/item/add?item=<?php echo $option['id'] ?>">[Edit]</a><br>
<?php endforeach; ?>
