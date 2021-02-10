<li class="nav-item dropdown d-lg-none">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #000;">
        Категории
    </a>
<?php if(preg_match("#(.+admin|(add|edit).+)#i", $this->nameOption)): ?>
    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a class="nav-link" href="?option=MainAdmin">Статьи</a>
        <a class="nav-link" href="?option=CategoriesAdmin">Категории</a>
        <a class="nav-link" href="?option=MenuAdmin">Меню</a>
        <a class="nav-link" href="?option=MessagesAdmin">Сообщения</a>
    </div>
<?php else: ?>
    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <?php while($row = mysqli_fetch_assoc($resultMenuCategories)): ?>
            <a class="nav-item nav-link" href="?option=Categories&id_category=<?=$row['id_category']?>"><?=$row['name_category']?></a>
        <?php endwhile; ?>
    </div>
<?php endif; ?>
</li>
</div>
</div>
</nav>
</div>
</div>
</div>
<hr>
