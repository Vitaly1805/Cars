<div class="menu">
    <div class="row">
        <div class="col-2 align-self-center d-none d-lg-block">
            <?php if(preg_match("#(.+admin|(add|edit).+)#i", $_GET['option']) && isset($_COOKIE['authorization'])): ?>
                <h3>ADMIN MENU</h3>
            <?php else: $fl = true;?>
                <h3>MENU</h3>
            <?php endif; ?>
        </div>
        <div class="col-10">
            <nav class="navbar navbar-expand-lg navbar-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav justify-content-around col-12">
                        <?php if($fl):?>
                            <a class="nav-item nav-link" href="?option=Main&id_menu=1&page=1">Главная</a>
                            <?php while($row = mysqli_fetch_assoc($resultMenu)): ?>
                                <a class="nav-item nav-link" href="?option=Main&id_menu=<?=$row['id_menu']?>"><?=$row['name_menu']?></a>
                            <?php endwhile; ?>
                            <?php if(isset($_COOKIE['authorization'])):?>
                                <a class="nav-item nav-link" href="?option=MainAdmin">Админка</a>
                            <?php endif;?>
                        <?php else: ?>
                            <a class="nav-item nav-link" href="?option=Main&id_menu=1&page=1">Выход</a>
                        <?php endif; ?>

