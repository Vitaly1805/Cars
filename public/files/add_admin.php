        <div class='col-12 col-lg-10 p-3'>
            <?php if($_GET['option'] === 'AddMenu'): ?>
            <h3>Добавление меню</h3>
            <form action="" method="post">
                <label for="name" class="pr-3">Введите название пункта меню:</label><br><input type="text" name="name_menu" id="name" style="width: 424px;"><br>
                <label for="title_menu">Введите заголовок контента:</label><br><textarea name="title_menu" id="title_menu" cols="50" rows="10"></textarea><br>
                <label for="text_menu">Введите содержимое контента:</label><br><textarea name="text_menu" id="text_menu" cols="50" rows="20"></textarea><br>
                <input class="mt-3" type="submit" name="button" value="Сохранить">
            </form>
            <?php endif; ?>
            <?php if($_GET['option'] === 'AddCategory'): ?>
            <h3>Добавление категории</h3>
            <form action="" method="post">
                <label for="name" class="pr-3">Введите название категории:</label><br><input type="text" name="name_category" id="name" style="width: 223px;" class="mb-3"><br>
                <input type="submit" name="button" value="Сохранить">
            </form>
            <?php else: ?>
            <h3>Добавление статьи</h3>
            <form action="" enctype="multipart/form-data" method="post" class="">
                <label for="title" class="pr-3">Введите заголовок:</label><br><input type="text" name="title" id="title" style="width: 424px;"><br>
                <label for="description">Введите описание:</label><br><textarea name="description" id="description" cols="50" rows="10"></textarea><br>
                <label for="text">Введите основной текст:</label><br><textarea name="text" id="text" cols="50" rows="20"></textarea><br>
                <label for="img_src" class="pr-3">Выберите изображение:</label><br><input type="file" name="img_src" id="img_src" style="width: 424px;" accept=".jpg, .jpeg, .png"><br>
                <label for="cat" class="pr-3">Выберите категорию:</label><br><select name="cat" id="cat">
                    <?php $result = $this->m->setQuery("SELECT * FROM `categories` WHERE `id_category` != '{$row['cat']}'");
                    while($row = mysqli_fetch_assoc($result)):?>
                        <option value="<?=$row['id_category']?>"><?=$row['name_category']?></option>
                    <?php endwhile;?>
                </select><br>
                <input class="mt-3" type="submit" name="button" value="Сохранить">
            </form>
            <?php endif; ?>
            <?=$this->m->getMessageAboutSuccess()?>
        </div>
    </div>
</div>
<hr>