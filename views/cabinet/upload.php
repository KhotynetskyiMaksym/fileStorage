<?php include ROOT . '/views/layouts/header.php'; ?>
    <div class="col-sm-4 col-sm-offset-4 padding-right">
        <?php if (isset($errors) && is_array($errors)): ?>
            <ul>
                <?php foreach($errors as $error): ?>
                    <li> -  <?php echo $error; ?> </li>
                <?php endforeach; ?>
            </ul>
        <?php elseif (isset($result)): ?>
            <ul>
                    <li> -  <?php echo $result; ?> </li>
            </ul>
        <?php endif; ?>
    </div>
        <br/>
        <br/>
    </div>
    <section class="uploadfile">
        <form method="post" action="#"  enctype="multipart/form-data">
            <input type="hidden" name="MAX_FILE_SIZE" value="524288">
            <input name="userfile" type="file">
            <input type="submit" name="upload" class="upload" value="upload">
        </form>
    </section>
<?php include ROOT . '/views/layouts/footer.php'; ?>