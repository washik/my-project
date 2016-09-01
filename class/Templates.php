<?php

class Templates
{
    protected $params;
    protected $pdo;
    protected $categories;
    protected $treeHtml;

    public function __construct($params, $pdo)
    {
        $this->params = $params;
        $this->pdo = $pdo;
    }

    public function getHtml()
    {
        $tplPath = $this->getTplPath();
        include('templates/' . $tplPath);
    }

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

    public function itemAdd()
    {
        if (empty($_POST))
            return;

        $val = $_POST['parent_id'];

        // Create item
        $sql = "INSERT INTO category (parent_id) VALUES (:parent_id)";
        $stm = $this->pdo->prepare($sql);
        $stm->bindParam(':parent_id', $val, PDO::PARAM_INT);
        $stm->execute();
        $elementId = $this->pdo->lastInsertId();

        // Create description
        $cols = array('id','action_ru','action_en','name_ru','name_en','short_description_ru','short_description_en','description_ru','description_en','meta_title_ru','meta_title_en','meta_description_en','meta_description_ru','meta_keywords_ru','meta_keywords_en','file_ru','file_en');

        foreach ($cols as $val) {
            $colsPdo[] = "`$val`";
            $valuesPdo[] = ":" .$val;
        }
        $colsPdo = implode(',', $colsPdo);
        $valuesPdo = implode(',', $valuesPdo);

        $sql = "
          INSERT INTO item (
            " . $colsPdo . "
        ) VALUES (
            " .$valuesPdo . "
        )";
        //d($sql,1);
        $stm = $this->pdo->prepare($sql);

        $postParams = $_POST;
        $postParams['id'] = $elementId;

        foreach ($cols as $colName) {
                $stm->bindParam(':' . $colName, $postParams[$colName], PDO::PARAM_INT);
        }
        $stm->execute();
    }


    public function getParents()
    {
        $sql = "
            SELECT * FROM category
            ORDER BY id
        ";

        foreach ($this->pdo->query($sql) as $row) {
            $this->categories[$row['parent_id']][] = $row;
        }
    }

    public function getTree($parent_id = 0, $level = 0) {

        if (isset($this->categories[$parent_id])) { //Если категория с таким parent_id существует
            foreach ($this->categories[$parent_id] as $value) { //Обходим
                /**
                 * Выводим категорию
                 *  $level * 25 - отступ, $level - хранит текущий уровень вложености (0,1,2..)
                 */
                $this->treeHtml.= '<option value="' .$value["id"] . '">' . str_repeat('---', $level) . $value["id"] . "</option>";
                $level = $level + 1; //Увеличиваем уровень вложености
                //Рекурсивно вызываем эту же функцию, но с новым $parent_id и $level
                $this->getTree($value["id"], $level);
                $level = $level - 1; //Уменьшаем уровень вложености
            }
        }
    }

    public function getTreeHtml()
    {
        return $this->treeHtml;
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