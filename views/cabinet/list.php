<?php include ROOT . '/views/layouts/header.php'; ?>

    <section>
        <div class="container">
            <div class="row">

                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <h2 class="title text-center">Хранилище</h2>

                        <?php if ($uploadedFileList): ?>
                            <p>Вы загрузили такие файлы:</p>
                            <table class="table-bordered table-striped table">
                                <tr>
                                    <th>Номер</th>
                                    <th>Название</th>
                                    <th>Расширение</th>
                                    <th>Размер, Кб</th>
                                    <th>Дата</th>
                                    <th>Скачать</th>
                                    <th>Удалить</th>
                                </tr>
                                <?php foreach ($uploadedFileList as $file): ?>
                                    <tr>
                                        <td><?php echo $file['id'];?></td>
                                        <td><?php echo $file['name'];?></td>
                                        <td><?php echo $file['type'];?></td>
                                        <td><?php echo $file['size'];?></td>
                                        <td><?php echo $file['date'];?></td>
                                        <td>
                                            <a href="/cabinet/download/<?php echo $file['id'];?>">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="/cabinet/delete/<?php echo $file['id'];?>">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="6">Общее количество, шт:</td>
                                    <td><?php echo $amountOfFiles;?></td>
                                </tr>

                            </table>

                        <?php else: ?>
                            <p>Хранилище пустое пустое</p>
                        <?php endif; ?>

                    </div>



                </div>
            </div>
        </div>
    </section>

<?php include ROOT . '/views/layouts/footer.php'; ?>