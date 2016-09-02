<?php

// add item
$message = $this->itemAdd();

// tree
$this->getParents();
$this->createTree();
$tree = $this->getTree();
// tree


// Edit
$data = $this->getItem();

?>

<p><a href="/admin/dashboard">Dashboard</a></p>

<?php if ($message) echo "<h2>" . $message . "...</h2>" ?>


<form name="category" method="post">

    <b>action_ru</b><br>
    <input type="checkbox" name="action_ru" value="1" <?php if (isset($data['action_ru']) && $data['action_ru'] > 0): ?>checked="checked"<?php endif; ?>><br>
    action_en<br>
    <input type="checkbox" name="action_en" value="1" <?php if (isset($data['action_en']) && $data['action_en'] > 0): ?>checked="checked"<?php endif; ?>><br>

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

    <b>name_ru</b><br>
    <input type="text" name="name_ru" value="<?php echo empty($data['name_ru'])?'':$data['name_ru']; ?>"><br>
    name_en<br>
    <input type="text" name="name_en"><br>
    <b>short_description_ru</b><br>
    <textarea name="short_description_ru"></textarea><br>
    short_description_en<br>
    <textarea name="short_description_en"></textarea><br>
    <b>description_ru</b><br>
    <textarea name="description_ru"></textarea><br>
    description_en<br>
    <textarea name="description_en"></textarea><br>
    <b>meta_title_ru</b><br>
    <input type="text" name="meta_title_ru"><br>
    meta_title_en<br>
    <input type="text" name="meta_title_en"><br>
    meta_description_en<br>
    <textarea name="meta_description_en"></textarea><br>
    <b>meta_description_ru</b><br>
    <textarea name="meta_description_ru"></textarea><br>
    <b>meta_keywords_ru</b><br>
    <textarea name="meta_keywords_ru"></textarea><br>
    meta_keywords_en<br>
    <textarea name="meta_keywords_en"></textarea><br>
    <b>file_ru</b><br>
    <input type="text" name="file_ru"><br>
    file_en<br>
    <input type="text" name="file_en"><br>

    <input type="submit" value="save">


</form>