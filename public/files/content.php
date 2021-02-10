<div class='col-12 col-lg-10 p-3'>
<?php if($_GET['id_menu'] === '1' || $_GET['option'] === 'Categories'): ?>
    <?php if(isset($_GET['page']) && isset($_GET['id_menu'])): ?>
        <h3>Все статьи</h3>
    <?php else: $nameCategoriesResult = $this->m->setQuery("SELECT name_category FROM `categories` WHERE id_category={$_GET['id_category']}");?>
        <h3>Все статьи о <?=mysqli_fetch_assoc($nameCategoriesResult)['name_category']?></h3>
    <?php endif; ?>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="article">
                    <h5 class="pb-1"><a href="?option=Article&id=<?=$row['id']?>"><?=$row['title']?></a></h5>
                    <p class="pb-1"><?=substr($row['date'],0,10)?></p>
                    <div class="article_content pb-5">
                        <div class="row">
                            <div class="article_content-image col-lg-5 pb-lg-0 pb-3">
                                <a href="?option=Article&id=<?=$row['id']?>"><img src="<?=$row['img_src']?>" class="img-fluid img-thumbnail" alt="<?=$row['title']?>"></a>
                            </div>
                            <div class="article_content_description col-lg-7">
                                <a href="?option=Article&id=<?=$row['id']?>"><p><?=$row['description']?></p></a>
                            </div>
                        </div>
                    </div>
                </div>
    <?php endwhile; ?>
    <?php if($this->amountRecordingInDB > 1): ?>
                <div class="pagination">
                    <nav aria-label="Page navigation example" style="margin: 0 auto;">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="?option=<?=$_GET['option']?>&<?=$this->nameId?>=1&page=<?=$this->page-1?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php for($i = 1; $i <= $this->amountRecordingInDB; $i++): ?>
                                <?php if($this->page == $i) $class = ' active'; else $class = '';?>
                                <li class="page-item"><a class="page-link<?=$class?>" href="?option=<?=$_GET['option']?>&<?=$this->nameId?>=<?=$_GET[$this->nameId]?>&page=<?=$i?>"><?=$i?></a></li>
                            <?php endfor; ?>
                            <li class="page-item">
                                <a class="page-link" href="?option=<?=$_GET['option']?>&<?=$this->nameId?>=1&page=<?=$this->page+1?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
    <?php endif; ?>
<?php endif; ?>
<?php if(isset($_GET['id_menu'])): $row = mysqli_fetch_assoc($result);?>
    <?php if($row['id_menu'] === $_GET['id_menu']) ?>
        <h3><?=$row['title_menu']?></h3><p><?=$row['text_menu']?></p>
    <?php endif; ?>
<?php if(!isset($_COOKIE['authorization']) && $this->nameOption === 'authorization'): ?>
    <div class="article text-center">
        <div class="article_block text-center" style="display: inline-block; width: 200px">
            <h3>Авторизация</h3>
            <form action="" method="post">
                <input type="text" placeholder="Логин" class="text" name="adminLogin"><br><br>
                <input type="password" placeholder="Пароль" class="text" name="adminPassword"><br><br>
                <input type="checkbox" name="remember" value="true" class="checkbox mr-3">Запомнить меня <br><br>
                <input type="submit" value="Войти" class="submit" name="button">
            </form>
        </div>
    </div>
    <?php if(isset( $_SESSION['error'])):?>
    <br><p class='text-center'><?=$_SESSION['error']?></p>
    <?php $this->m->delSessions(); endif; ?>
<?php endif;?>
<?php if($_GET['option'] === 'Article'): $row = mysqli_fetch_assoc($result);?>
    <div class="article">
        <h3 class="pb-1 text-center article_h3"><?=$row['title']?></h3>
        <div class="article_content pb-5">
            <div class="row">
                <div class="article_content-image col-12 py-3">
                    <img src="<?=$row['img_src']?>" class="img-fluid img-thumbnail rounded mx-auto d-block" style="width: 100%;height: auto;" alt="<?=$row['title']?>" >
                </div>
                <div class="article_content_description col-12" style="border-bottom: none;">
                    <p><?=$row['text']?></p>
                </div>
            </div>
        </div>
        <p style="font-size: 20px;" class="text-right"><?=$row['date']?></p>
    </div>
<?php endif; ?>
<?php if($_SESSION['messageForUser'] === 'true'): unset($_SESSION['messageForUser'])?>
    <p>Сообщение успешно отправлено!</p>
<?php endif; ?>
<?php if($_SESSION['messageForUser'] === 'false'): unset($_SESSION['messageForUser'])?>
    <p>Введены неверные данные</p>
<?php endif; ?>
        </div>
    </div>
</div>
<hr>
