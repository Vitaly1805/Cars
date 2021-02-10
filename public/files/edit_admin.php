        <div class='col-12 col-lg-10 p-3'>
            <h4>Редактирование <?=$this->nameEdit?></h4>
            <?php if($_GET['option'] === 'EditMenu'): ?>
                <form action="" method="post" class="">
                    <label for="name" class="pr-3">Изменить название пункта меню:</label><br><input type="text" name="name_menu" id="name" style="width: 424px;" value="<?=$row['name_menu']?>"><br>
                    <label for="title_menu">Изменить заголовок контента:</label><br><textarea name="title_menu" id="title_menu" cols="50" rows="10"><?=$row['title_menu']?></textarea><br>
                    <label for="text_menu">Изменить содержимое контента:</label><br><textarea name="text_menu" id="text_menu" cols="50" rows="20"><?=$row['text_menu']?></textarea><br>
                    <input class="mt-3" type="submit" name="button" value="Сохранить">
                </form>
            <?php endif; ?>
            <?php if($_GET['option'] === 'EditCategory'): ?>
                <form action="" method="post">
                    <label for="name" class="pr-3">Измените название категории:</label><br><input type="text" name="name_category" id="name" style="width: 223px;" class="mb-3" value="<?=$row['name_category']?>"><br>
                    <input type="submit" name="button" value="Сохранить">
                </form>
            <?php endif; ?>
            <?php if($_GET['option'] === 'EditArticle'): ?>
                <form action="" enctype="multipart/form-data" method="post">
                    <label for="title" class="pr-3">Изменить заголовок:</label><br><input type="text" name="title" id="title" style="width: 424px;" value="<?=$row['title']?>"><br>
                    <label for="description">Изменить описание:</label><br><textarea name="description" id="description" cols="50" rows="10"><?=$row['description']?></textarea><br>
                    <label for="text">Изменить основной текст:</label><br><textarea name="text" id="text" cols="50" rows="20"><?=$row['text']?></textarea><br>
                    <label for="cat" class="pr-3">Изменить категорию:</label><br><select name="cat" id="cat">
                        <?php $result = $this->m->setQuery("SELECT * FROM `categories` WHERE `id_category` = '{$row['cat']}'");
                        $row = mysqli_fetch_assoc($result)?>
                        <option value="<?=$row['id_category']?>"><?=$row['name_category']?></option>
                        <?php $result = $this->m->setQuery("SELECT * FROM `categories` WHERE `id_category` != '{$row['cat']}'");
                        while($row = mysqli_fetch_assoc($result)):?>
                            <option value="<?=$row['id_category']?>"><?=$row['name_category']?></option>
                        <?php endwhile;?>
                    </select><br>
                    <input class="mt-3" type="submit" name="button" value="Сохранить">
                </form>
            <?php endif;?>
            <?=$this->m->getMessageAboutSuccess();?>
        </div>
   </div>
</div>
<hr>