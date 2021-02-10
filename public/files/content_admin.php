        <div class='col-12 col-lg-10 p-3'>
        <?php if($_GET['option'] === 'MessagesAdmin'): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="row mb-3 mx-1" style="border: 1px solid #000;">
                <div class='my-3 col-9'><h5><?=$row[$this->nameTitle]?> (<?=$row['login_message']?>)</h5></div>
                <div class='my-3 col-3 pl-5'><?=$row['date_message']?></div>
                <div class="col-11"><?=$row['message']?></div>
                <div class="col-10"></div>
                <div class='my-3 col-1'><a href='?option=MessagesAdmin&id_message=<?=$row[$this->nameId]?>' class='pl-3 delParagraph'>Удалить</a></div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <a href='?option=Add<?=$this->nameAdditionEN?>'><h4>Добавить <?=$this->nameAdditionRU?></h4></a>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <?php if($_GET['option'] === 'MainAdmin'): ?>
                <div class='mb-3'><a href='?option=EditArticle&id=<?=$row[$this->nameId]?>'><?=$row[$this->nameTitle]?></a>
                <a href='?option=MainAdmin&id=<?=$row[$this->nameId]?>' class='pl-3 delParagraph'>Удалить</a></div>
                <?php endif; ?>
                <?php if($_GET['option'] === 'CategoriesAdmin'): ?>
                    <div class='mb-3'><a href='?option=EditCategory&id_category=<?=$row[$this->nameId]?>'><?=$row[$this->nameTitle]?></a>
                    <a href='?option=CategoriesAdmin&id_category=<?=$row[$this->nameId]?>' class='pl-3 delParagraph'>Удалить</a></div>
                <?php endif; ?>
                <?php if($_GET['option'] === 'MenuAdmin'): ?>
                    <div class='mb-3'><a href='?option=EditMenu&id_menu=<?=$row[$this->nameId]?>'><?=$row[$this->nameTitle]?></a>
                    <a href='?option=MenuAdmin&id_menu=<?=$row[$this->nameId]?>' class='pl-3 delParagraph'>Удалить</a></div>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php endif; ?>
        </div>
    </div>
</div>
<hr>