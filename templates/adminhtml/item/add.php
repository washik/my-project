<?php

// add item
$message = $this->itemAdd();

if ($message == 200)
    header('Location: http://symfony.loc/admin/dashboard');

// tree
$this->getChildren();
$this->createTree();
$tree = $this->getTree();
// tree


// Edit
$data = $this->getItem();
//d($data,1);
?>

<p><a href="/admin/dashboard">Dashboard</a></p>

<?php if ($message) echo "<h2>" . $message . "...</h2>" ?>


<form name="category" method="post">


    action<br>
    <input type="checkbox" name="action" value="1" <?php if (isset($data['action']) && $data['action'] > 0): ?>checked="checked"<?php endif; ?>><br>

    parent_id<br>
    <select name="parent_id">
        <option value="0">root</option>
        <?php foreach ($tree as $option): ?>
            <option value="<?php echo $option['id'] ?>"<?php if (isset($data['parent_id']) && $option['id'] == $data['parent_id']): ?>selected="selected"<?php endif?>>
                <?php echo str_repeat('|--- ', $option['level']) . $option['title'] ?>
                <?php if (isset($_GET['item']) && $option['id'] == $_GET['item']): ?>(*)<?php endif?>
            </option>
        <?php endforeach; ?>
    </select><br>

    url_key<br>
    <input type="text" name="url_key" value="<?php echo empty($data['url_key'])?'':$data['url_key']; ?>"><br>


    name<br>
    <input type="text" name="name" value="<?php echo empty($data['name'])?'':$data['name']; ?>"><br>

    short_description<br>
    <textarea name="short_description"><?php echo empty($data['short_description'])?'':$data['short_description']; ?></textarea><br>

    description<br>
    <textarea name="description"><?php echo empty($data['description'])?'':$data['description']; ?></textarea><br>

    meta_title<br>
    <input type="text" name="meta_title" value="<?php echo empty($data['meta_title'])?'':$data['meta_title']; ?>"><br>

    meta_description<br>
    <textarea name="meta_description"><?php echo empty($data['meta_description'])?'':$data['meta_description']; ?></textarea><br>

    meta_keywords<br>
    <textarea name="meta_keywords"><?php echo empty($data['meta_keywords'])?'':$data['meta_keywords']; ?></textarea><br>

    file<br>
    <input type="text" name="file" value="<?php echo empty($data['file'])?'':$data['file']; ?>"><br>

    <input type="submit" value="save">


</form>