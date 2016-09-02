<?php

class Templates
{
    protected $params;
    protected $pdo;
    protected $categories;
    protected $tree;
    protected $parents;

    public function __construct($params, $pdo)
    {
        $this->params = $params;
        $this->pdo = $pdo;
        $this->parents = array();
    }

    public function getHtml()
    {
        $tplPath = $this->getTplPath();
        include('templates/' . $tplPath);
    }

    /**
     * Get tpl
     *
     * @return string
     */
    public function getTplPath()
    {
        $path = '';
        if (empty($this->params)) {

        } elseif ($this->params[0] == 'admin') {
            $urlPath = $this->params;
            array_shift($urlPath);
            $urlPath = implode('/', $urlPath);
            $urlPath = preg_replace('#\.html#', '', $urlPath);
            $path = 'adminhtml/' . $urlPath . '.php';
            return $path;
        } else {

        }
    }

    public function getParents($id)
    {
        $sql = "
            SELECT id, parent_id FROM category
            WHERE id = " . $id . "

        ";
        foreach ($this->pdo->query($sql) as $row) {
            if ($row['parent_id'] > 0) {
                $this->parents[] = $row['parent_id'];
                $this->getParents($row['parent_id']);
            }
        }
    }

    /**
     * Add element
     *
     * @return string|void
     */
    public function itemAdd()
    {
        if (empty($_POST))
            return;

        $val = empty($_POST['parent_id'])?0:(int)$_POST['parent_id'];
        if (!empty($_GET['item'])) $itemId = (int)$_GET['item']; else $itemId = 0;

        // Validation
        if ($val > 0 && $val == $itemId) {
            return "[ERROR]: id = parent_id";
        }
        if ($val > 0)
        {
            $this->getParents($val);
            if (in_array($itemId, $this->parents))
                return "[ERROR]: parent_id is children";
        }


        // Save/Update tree
        if ($itemId < 1) {
            // Create item
            $sql = "INSERT INTO category (parent_id) VALUES (:parent_id)";
            $stm = $this->pdo->prepare($sql);
            $stm->bindParam(':parent_id', $val, PDO::PARAM_INT);
            $stm->execute();
            $elementId = $this->pdo->lastInsertId();
        } else {
            $sql = "UPDATE category SET parent_id = :parent_id WHERE id = " . $itemId;
            $stm = $this->pdo->prepare($sql);
            $stm->bindParam(':parent_id', $val, PDO::PARAM_INT);
            $stm->execute();
        }



        // Create description
        $cols = array('id','action_ru','action_en','name_ru','name_en','short_description_ru','short_description_en','description_ru','description_en','meta_title_ru','meta_title_en','meta_description_en','meta_description_ru','meta_keywords_ru','meta_keywords_en','file_ru','file_en');

        foreach ($cols as $val) {
            $colsPdo[] = "`$val`";
            $valuesPdo[] = ":" .$val;
            $update[] = $val . ' = :' . $val;
        }
        $colsPdo = implode(',', $colsPdo);
        $valuesPdo = implode(',', $valuesPdo);
        $update = implode(',', $update);


        // Save/Update item
        if ($itemId < 1) {
            $sql = "
              INSERT INTO item (
                " . $colsPdo . "
            ) VALUES (
                " . $valuesPdo . "
            )";
        } else {
            $sql = "
              UPDATE item SET
              " . $update . "
              WHERE id = " . $itemId . "
              ";
        }
        $stm = $this->pdo->prepare($sql);
        $postParams = $_POST;
        if ($itemId < 1)
            $postParams['id'] = $elementId;
        else
            $postParams['id'] = $itemId;

        foreach ($cols as $colName) {
                $stm->bindParam(':' . $colName, $postParams[$colName], PDO::PARAM_INT);
        }
        $stm->execute();
    }


    public function getChildren()
    {
        $sql = "
            SELECT * FROM category
            ORDER BY id
        ";

        foreach ($this->pdo->query($sql) as $row) {
            $this->categories[$row['parent_id']][] = $row;
        }
    }

    public function getAttr($id, $attribute)
    {
        $sql = "
            SELECT " . $attribute . " as attr FROM item
            WHERE id = " . $id . "

        ";
        foreach ($this->pdo->query($sql) as $row) {
            return $row['attr'];
        }
        return '';
    }

    /**
     * Build Tree
     *
     * @param int $parent_id
     * @param int $level
     */
    public function createTree($parent_id = 0, $level = 0) {

        if (isset($this->categories[$parent_id])) { //Если категория с таким parent_id существует
            foreach ($this->categories[$parent_id] as $value) { //Обходим
                $this->tree[] = array(
                    'id' => $value["id"],
                    'level' => $level,
                    'title' => $this->getAttr($value["id"], 'name_ru')
                );


                $level = $level + 1; //Увеличиваем уровень вложености
                //Рекурсивно вызываем эту же функцию, но с новым $parent_id и $level
                $this->createTree($value["id"], $level);
                $level = $level - 1; //Уменьшаем уровень вложености
            }
        }
    }

    public function getTree(){
        return $this->tree;
    }

    public function getItem()
    {
        if (empty($_GET['item']))
            return;

        $id = (int)$_GET['item'];
        $sql = "
            SELECT t1.parent_id, t2.*  FROM category AS t1
            LEFT JOIN item as t2 ON t1.id = t2.id
            WHERE t1.id = ".$id."
        ";

        foreach ($this->pdo->query($sql) as $row) {
            return $row;
        }
        return array();
    }
}