<?php
include(realpath($_SERVER['DOCUMENT_ROOT'] . '/../app/bootstrap.php'));

$articles = $article->getArticles(999);

include(TEMPLATES_PATH . '/_header.php')
?>

<div class="container container-admin-index">
    <!-- Row for buttons/navigation on top of admin page -->
    <div class="row text-center">
        <a href="#" class="btn btn-default btn-lg"><i class="fa fa-plus" aria-hidden="true"></i> New Article</a>
    </div>
    <br>
    <div class="row">
        <div class="col-md-9">
            <table class="table table-condensed table-bordered">
                <tr>
                    <th>id</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Created on</th>
                    <th>Options</th>
                </tr>

                <?php foreach ($articles as $article):?>
                    <tr>
                        <td><?php echo htmlspecialchars($article['id']); ?></td>
                        <td><?php echo htmlspecialchars($article['title']); ?></td>
                        <td><?php echo htmlspecialchars($article['category_name']); ?></td>
                        <td><?php echo htmlspecialchars($article['author']); ?></td>
                        <td><?php echo htmlspecialchars(date("d.m.Y", $article['created_at'])); ?></td>
                        <td>
                            <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="#" class="btn btn-danger btn-xs"><i class="fa fa-times" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </table>
        </div>
    </div>


</div>


<?php include(TEMPLATES_PATH . '/_footer.php'); ?>
