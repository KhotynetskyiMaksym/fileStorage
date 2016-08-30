<?php
include ROOT . '/views/layouts/header.php'; ?>

    <section>
        <div class="container">
            <div class="row">

                <div class="col-sm-4 col-sm-offset-4 padding-right">
                        <?php if (isset($errors) && is_array($errors)): ?>
                            <ul>
                                <?php foreach($errors as $error): ?>
                                    <li> -  <?php echo $error; ?> </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <div class="signup-form"><!--sign up form-->
                            <h2>Вход на сайте</h2>
                            <form action="#" method="post">
                                <input type="name" name="name" placeholder="Name" value="<?php echo $name; ?>"/>
                                <input type="password" name="password" placeholder="Пароль" value="<?php echo $password; ?>"/>
                                <input type="submit" name="submit" class="btn btn-default" value="Вход" />
                            </form>
                        </div><!--/sign up form-->
                    <br/>
                    <br/>
                </div>
            </div>
        </div>
    </section>

<?php include ROOT . '/views/layouts/footer.php'; ?>