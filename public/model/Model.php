<?php

class Model
{
    protected $db;
    protected $amountRecording = 3;
    protected $amountRecordingInDB;
    protected $page;
    protected $nameId;
    protected $nameTitle;
    protected $nameOption;
    protected $nameAdditionEN;
    protected $nameAdditionRU;
    protected $nameAdd;
    protected $amountNewMessages = '';
    protected $arrOptions = ['MainAdmin', 'CategoriesAdmin', 'MenuAdmin', 'MessagesAdmin','Categories', 'Article', 'Main', 'EditMenu', 'EditArticle', 'EditCategory', 'AddMenu', 'AddCategory', 'AddArticle'];
    protected $arrOptionsLow = ['mainadmin', 'categoriesadmin', 'menuadmin', 'messagesadmin', 'categories', 'article', 'main', 'editmenu', 'editarticle', 'editcategory','addmenu', 'addcategory', 'addarticle', 'authorization'];

    public function __construct()
    {
        $this->db = mysqli_connect(HOST,USER,PASSWORD,DB);
        if(!$this->db)
            echo "Ошибка соединения с БД";
    }

    public function getHeader()
    {
        $this->messageFromUser();
        if(isset($_POST['button']))
            $this->setSessions($_GET['option']);
    }

    public function getMenu()
    {
        return $this->setQuery("SELECT * FROM `menu`");
    }

    public function getMenuCategories()
    {
        return $this->setQuery("SELECT * FROM `categories`");
    }

    public function getSidebar()
    {
        return $this->setQuery("SELECT * FROM `categories`");
    }

    public function getContent($nameOption)
    {
        for($i = 0; $i < count($this->arrOptions); $i++)
        {
            if($nameOption === $this->arrOptionsLow[$i])
            {
                $nameMethod = "getContent{$this->arrOptions[$i]}";
                $result = $this->$nameMethod();
            }
            if($nameOption === 'main')
                $this->nameId = 'id_menu';
        }
        //$this->checkId();
        $this->getAmountNewMessages();
        $this->setModelVar();
        return $result;
    }

    protected function getContentMain()
    {
        $this->setGetMain();

        if(isset($_GET['id_menu']) && $_GET['id_menu'] != 1)
            return $this->setQuery("SELECT * FROM `menu` WHERE id_menu={$_GET['id_menu']}");
        else
        {
            $result = $this->setQuery('SELECT COUNT(*) as count FROM `articles`');
            $this->amountRecordingInDB = ceil(mysqli_fetch_assoc($result)['count'] / $this->amountRecording);
            $this->page = $this->setPage($this->amountRecordingInDB);
            $from = ($this->page - 1) * $this->amountRecording;
            return  $this->setQuery("SELECT * FROM `articles` WHERE id>0 ORDER BY date DESC LIMIT $from, $this->amountRecording");
        }
    }

    protected function getContentCategories()
    {
        $this->checkId('categories', 'id_category');

        if(isset($_GET['id_category']))
        {
            $result = $this->setQuery("SELECT COUNT(*) as count FROM `articles` WHERE cat={$_GET['id_category']}");
            $this->amountRecordingInDB = ceil(mysqli_fetch_assoc($result)['count'] / $this->amountRecording);
            $this->page = $this->setPage($this->amountRecordingInDB);
            $from = ($this->page - 1) * $this->amountRecording;

            return $this->setQuery("SELECT * FROM `articles` WHERE cat={$_GET['id_category']} LIMIT $from, $this->amountRecording");
        }
    }

    protected function getContentArticle()
    {
        $this->checkId('articles', 'id');

        if(isset($_GET['id']))
        {
            $query = "SELECT * FROM `articles` WHERE id={$_GET['id']}";
            $result = $this->setQuery($query);
            $row = mysqli_fetch_assoc($result);
            if((int)$_GET['id'] === (int)$row['id'])
                return $this->setQuery($query);
        }
    }

    protected function getContentMainAdmin()
    {
        if(isset($_GET['id'])) {
            $this->delCategoryArticleMenu($_GET['id'], 'articles', 'id');
        }
        $this->setValuesVarsContent('id', 'title', 'Article', 'статью');

        return $this->setQuery("SELECT id,title FROM `articles` ORDER BY date DESC");
    }

    protected function getContentCategoriesAdmin()
    {
        if(isset($_GET['id_category'])) {
            $this->delCategoryArticleMenu($_GET['id_category'], 'categories', 'id_category');
        }
        $this->setValuesVarsContent('id_category', 'name_category', 'Category', 'категорию');

        return $this->setQuery("SELECT * FROM `categories`");
    }

    protected function getContentMenuAdmin()
    {
        if(isset($_GET['id_menu'])) {
            $this->delCategoryArticleMenu($_GET['id_menu'], 'menu', 'id_menu');
        }
        $this->setValuesVarsContent('id_menu', 'name_menu', 'Menu', 'пункт меню');

        return $this->setQuery("SELECT id_menu,name_menu FROM `menu`");
    }

    protected function getContentMessagesAdmin()
    {
        if(isset($_GET['id_message']))
            $this->delCategoryArticleMenu($_GET['id_message'], 'messages', 'id_message');

        $this->setValuesVarsContent('id_message', 'name_message', 'Message');

        $result = $this->setQuery('SELECT read_message FROM `messages`');
        while ($row = mysqli_fetch_assoc($result))
        {
            $this->setQuery('UPDATE `messages` SET read_message=1');
        }

        return $this->setQuery("SELECT * FROM `messages` ORDER BY date_message DESC");
    }

    public function getContentEditMenu()
    {
        $this->nameEdit = 'меню';

        if(isset($_GET['id_menu ']))
            $this->checkId('menu', 'id_menu');

        if(isset($_GET['id_menu']))
            return $this->setJson($_GET['id_menu'], 'menu', 'id_menu');
        else
        {
            $data = $this->getJson();

            $selectResult = $this->setQuery("SELECT * FROM `menu` WHERE `id_menu`='{$data['id_menu']}'");
            $row = mysqli_fetch_assoc($selectResult);

            if($_SESSION['name_menu'] !== $row['name_menu'])
            {
                $_SESSION['message'] = '<p>Пункт меню успешно обновлен!</p>';
                $this->setQuery("UPDATE `menu` SET `name_menu`='{$_SESSION['name_menu']}',`title_menu`='{$_SESSION['title_menu']}',`text_menu`='{$_SESSION['text_menu']}' WHERE `id_menu`='{$data['id_menu']}'");
            }

            return $this->setQuery("SELECT * FROM `menu` WHERE id_menu='{$data['id_menu']}'");
        }
    }

        public function getContentEditArticle()
        {
            $this->nameEdit = 'статьи';

            if(isset($_GET['id']))
                $this->checkId('articles', 'id');

            if(isset($_GET['id']))
                return $this->setJson($_GET['id'], 'articles', 'id');
            else
            {
                $data = $this->getJson();

                $selectResult =  $this->setQuery("SELECT * FROM `articles` WHERE `id`='{$data['id']}'");
                $row =mysqli_fetch_assoc($selectResult);

                if($_SESSION['title'] !== $row['title'] || $_SESSION['description'] !== $row['description'] || $_SESSION['text'] !== $row['text'] || $_SESSION['cat'] !== $row['cat'])
                {
                    $_SESSION['message'] = '<p>Статья успешно обновлена!</p>';
                    $this->setQuery("UPDATE `articles` SET `title`='{$_SESSION['title']}',`description`='{$_SESSION['description']}',`text`='{$_SESSION['text']}',`cat`='{$_SESSION['cat']}' WHERE `id`='{$data['id']}'");
                }

                return $this->setQuery("SELECT * FROM `articles` WHERE id='{$data['id']}'");
            }
        }

    public function getContentEditCategory()
    {
        $this->nameEdit = 'категории';

        if(isset($_GET['id_category']))
            $this->checkId('categories', 'id_category');

        if(isset($_GET['id_category']))
           return $this->setJson($_GET['id_category'], 'categories', 'id_category');
        else
        {
            $data = $this->getJson();

            $selectResult =  $this->setQuery("SELECT * FROM `categories` WHERE `id_category`='{$data['id_category']}'");
            $row =mysqli_fetch_assoc($selectResult);

            if($_SESSION['name_category'] != $row['name_category'])
            {
                $_SESSION['message'] = '<p>Категория успешно обновлена!</p>';
                $this->setQuery("UPDATE `categories` SET `name_category`='{$_SESSION['name_category']}' WHERE `id_category`='{$data['id_category']}'");
            }

            return $this->setQuery("SELECT * FROM `categories` WHERE id_category='{$data['id_category']}'");
        }
    }

    public function getContentAddMenu()
    {
        $flag = true;

        if(isset($_SESSION['name_menu']))
        {
            $result = $this->setQuery("SELECT `name_menu`,`title_menu`,`text_menu` FROM `menu`");

            while($row = mysqli_fetch_assoc($result))
            {
                if($row['name_menu'] === $_SESSION['name_menu'] || $row['title_menu'] === $_SESSION['title_menu'] || $row['text_menu'] === $_SESSION['text_menu'])
                {
                    $flag = false;
                    $_SESSION['message'] = "Такой элемент уже существует!";
                }
            }

            if($flag)
            {
                $_SESSION['message'] = '<p>Пункт меню успешно добавлен!</p>';
                $this->setQuery("INSERT INTO `menu`(`name_menu`,`title_menu`,`text_menu`) VALUES ('{$_SESSION['name_menu']}','{$_SESSION['title_menu']}','{$_SESSION['text_menu']}')");
            }
        }
    }

    public function getContentAddCategory()
    {
        $flag = true;

        if(isset($_SESSION['name_category']))
        {
            $result = $this->setQuery("SELECT name_category FROM `categories`");

            while($row = mysqli_fetch_assoc($result))
            {
                if($row['name_category'] === $_SESSION['name_category'])
                {
                    $flag = false;
                    $_SESSION['message'] = "Такой элемент уже существует!";
                }
            }

            if($flag)
            {
                $_SESSION['message'] = '<p>Категория успешно добавлена!</p>';
                $this->setQuery("INSERT INTO `categories`(`name_category`) VALUES ('{$_SESSION['name_category']}')");
            }
        }
    }

    public function getContentAddArticle()
    {
        $flag = true;

        if(isset($_SESSION['title']))
        {
            $result = $this->setQuery("SELECT `title`,`description`,`text`,`img_src`,`cat` FROM `articles`");

            while($row = mysqli_fetch_assoc($result))
            {
                if($row['title'] === $_SESSION['title'] || $row['description'] === $_SESSION['description'] || $row['text'] === $_SESSION['text'])
                {
                    $flag = false;
                    $_SESSION['message'] = "<p>Такой элемент уже существует!</p>";
                }
            }

            if($flag)
            {
                $_SESSION['message'] = '<p>Категория успешно добавлена!</p>';
                $this->setQuery("INSERT INTO `articles`(`title`, `description`, `text`, `img_src`, `cat`) VALUES ('{$_SESSION['title']}','{$_SESSION['description']}','{$_SESSION['text']}','{$_SESSION['img_src']}','{$_SESSION['cat']}')");
            }
        }
    }

    public function setQuery($query)
    {
        $result = mysqli_query($this->db, $query);
        if(!$result)
            die("Ошибка соединения с БД");
        return $result;
    }

    public function setSessions($class)
    {
        if(!empty($_FILES['img_src']))
            $this->checkImage();

        foreach($_POST as $key => $value)
        {
            if($key === 'button')
                continue;
            $_SESSION[$key]= $value;
        }

        header("Location: ?option=$class");
        die;
    }

    public function setPage($amountRecordingInDB)
    {
        if(empty($_GET['page']))
            $_GET['page'] = 1;
        else
            $page = intval($_GET['page']);

        if ($page < 1)
            $page = 1;

        if($page > $amountRecordingInDB)
            $page = $amountRecordingInDB;

        return $page;
    }

    public function checkAuthorization()
    {
        if ($_POST['adminLogin'] === $_SESSION['adminLogin'] && $_POST['adminPassword'] === $_SESSION['adminPassword'])
        {
            if(isset($_POST['remember']))
                setcookie('authorization', 'true', time()+100000*1000*1000);
            else
                setcookie('authorization', 'true');
            header("Refresh:0");
            die;
        }
        elseif(!empty($_POST['login']) || !empty($_POST['password']))
            $_SESSION['error'] = 'Неверно введен логин или пароль';
    }

    public function setNameOption($nameOption)
    {
        if(!empty($_GET['option']) && !preg_match("#\bACore(|Admin)\b#i", $_GET['option']))
            $nameOption = strtolower(trim(strip_tags($_GET['option'])));
        else
            $nameOption = "Main";

        if(preg_match("#\b(edit|add).+\b#i", $nameOption) && !isset($_COOKIE['authorization']))
            return $this->nameOption = 'main';
        elseif(preg_match("#\b.+admin\b#i", $nameOption) && !isset($_COOKIE['authorization']))
            return  $this->nameOption = 'authorization';
        elseif($this->checkOption($nameOption))
            return  $this->nameOption = $nameOption;
        else
            return  $this->nameOption = 'main';
    }

    protected function messageFromUser()
    {
        if(!empty($_POST['name']) && !empty($_POST['login']) && !empty($_POST['message']))
        {
            $this->postStripTags('name', 'login', 'message');
            $this->setQuery("INSERT INTO `messages`(`name_message`, `login_message`, `message`, `read_message`) VALUES ('{$_POST['name']}', '{$_POST['login']}', '{$_POST['message']}', '{$_POST['read_message']}')");

            $_SESSION['messageForUser'] = 'true';
            header("Location: http://cars/public/?option=Main&id_menu=5");
            die;
        }
        elseif(isset($_POST['read_message']))
        {
            $_SESSION['messageForUser'] = 'false';
            header("Location: http://cars/public/?option=Main&id_menu=5");
            die;
        }
    }

    protected function checkOption($nameOption)
    {
        for($i = 0; $i < count($this->arrOptionsLow); $i++)
        {
            if($this->arrOptionsLow[$i] === $nameOption)
                return true;
        }
        return false;
    }

    protected function setGetMain()
    {
        $flag = true;
        $result = $this->setQuery("SELECT id_menu FROM `menu`");
        while ($row = mysqli_fetch_assoc($result))
        {
            if($_GET['id_menu'] === $row['id_menu'])
                $flag = false;
        }

        if($flag)
        {
            $_GET['option'] = 'main';
            if($_GET['id_menu'] !== '1')
                $_GET['id_menu'] = '1';
            if(empty($_GET['page']))
                $_GET['page'] = '1';
        }
    }

    protected function checkImage()
    {
        if(!move_uploaded_file($_FILES['img_src']['tmp_name'], 'images/' . $_FILES['img_src']['name']))
        {
            die("Не удалось загрузить изображение");
        }
        $_POST['img_src'] = "images/" . $_FILES['img_src']['name'];
    }

    public function delCategoryArticleMenu($id, $table, $nameId)
    {
        $this->setQuery("DELETE FROM {$table} WHERE {$nameId}={$id}");
    }

    protected function setModelVar()
    {
        global $core;

        if(!empty($this->amountRecordingInDB))
            $core->amountRecordingInDB = $this->amountRecordingInDB;
        if(!empty($this->nameId))
            $core->nameId = $this->nameId;
        if(!empty($this->nameTitle))
            $core->nameTitle = $this->nameTitle;
        if(!empty($this->nameAdditionRU))
            $core->nameAdditionRU = $this->nameAdditionRU;
        if(!empty($this->nameAdditionEN))
            $core->nameAdditionEN = $this->nameAdditionEN;
        if(!empty($this->page))
            $core->page = $this->page;
        if(!empty($this->nameEdit))
            $core->nameEdit = $this->nameEdit;
        if(!empty($this->amountNewMessages))
            $core->amountNewMessages = $this->amountNewMessages;
    }

    protected function setValuesVarsContent($nameId = '', $nameTitle = '', $nameAdditionEN = '', $nameAdditionRU = '')
    {
        $this->nameId = $nameId;
        $this->nameTitle = $nameTitle;
        $this->nameAdditionEN = $nameAdditionEN;
        $this->nameAdditionRU = $nameAdditionRU;
    }

    protected function setJson($id, $table, $nameId)
    {
        $jsonData = json_encode($_GET);
        file_put_contents('id.json', $jsonData);
        return $this->setQuery("SELECT * FROM `$table` WHERE `$nameId`='$id'");
    }

    protected function getJson()
    {
        $result = file_get_contents('id.json');
        return json_decode($result, true);
    }

    public function getMessageAboutSuccess()
    {
        if(isset($_SESSION['message']))
        {
            echo $_SESSION['message'];
            if(preg_match("#edit.+#i", $_GET['option']))
                unset($_SESSION['message']);
            else
                $this->delSessions();
        }
    }

    public function delSessions()
    {
        foreach ($_SESSION as $key=>$value)
        {
            if($key === 'adminLogin' || $key === 'adminPassword' || $key === 'authorization')
                continue;
            unset($_SESSION[$key]);
        }
    }

    protected function getAmountNewMessages()
    {
        $count = 0;
        $result = $this->setQuery('SELECT read_message FROM `messages` WHERE read_message=0');
        while ($row = mysqli_fetch_assoc($result))
            $count++;
        $this->amountNewMessages = "$count";
    }

    protected function checkId($table, $nameId)
    {
        $flag = true;

        $result = $this->setQuery("SELECT $nameId as id FROM `$table`");
        while($row = mysqli_fetch_assoc($result))
        {
            if($row['id'] === $_GET[$nameId])
                $flag = false;
        }

        if($flag)
        {
            $result = $this->setQuery("SELECT $nameId as id FROM `$table` WHERE $nameId>0 LIMIT 1");
            $_GET[$nameId] =  mysqli_fetch_assoc($result)['id'];
        }
    }

    protected function postStripTags(...$arr)
    {
        foreach ($arr as $key)
        {
            $_POST[$key] = strip_tags($_POST[$key]);
        }
    }
}