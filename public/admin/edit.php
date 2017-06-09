<?php
// bootstrap
include(realpath($_SERVER['DOCUMENT_ROOT'] . '/../app/bootstrap.php'));
$currentPage = 'admin';
$page = 'admin-article-index';

// If not logged in, redirect to login page
if (!$user->isLoggedIn()) {
    header('location: /admin/login.php');
    die();
}

// If POST request, update article
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $article->edit();
} else {
    // Otherwise, get article fro its ID + categories for form
    $articleData = $article->getArticleById();
    $categories = $article->getCategories();
}

include(TEMPLATES_PATH . '/_header.php');
?>

<!-- Main content -->
<div class="container container-new-article">
	<div class="row">

		<!-- Sidebar column-->
		<?php include(TEMPLATES_PATH . '/admin/_side-nav.php'); ?>

		<!-- edit article form column -->
		<div class="col-md-9">
			<form class="article-form" action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="articleId" value="<?php echo $articleId; ?>">
				<p>Article Title</p>
				<input type="text" name="title" placeholder="Article title here" required="required" class="form-control" value="<?php echo $articleData['title']; ?>">
				<p>Article Body</p>
				<textarea name="body" rows="8"><?php echo $articleData['body']; ?></textarea>
                <p>Image (appears on article thumbnail / 400x200)</p>
				<input type="file" name="image" class="form-control" accept="image/*">
				<p>Category</p>
				<select class="category form-control" name="categoryId">
					<?php foreach ($categories as $category): ?>
						<option value='<?php echo $category["id"]; ?>' <?php echo ($category['category_name'] == $articleData['category_name'] ? 'selected' : ''); ?>><?php echo $category['category_name']; ?></option>
					<?php endforeach; ?>
				</select>
				<input type="hidden" name="authorId" value="1">
				<button type="submit" name="submit" class="btn btn-danger btn-block">Update article <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
			</form>
		</div>

	</div>
</div>
<!-- End of main content -->

<!-- CKEditor script that replaced textarea with ckeditor -->
<script>
    CKEDITOR.replace('body');
</script>

<!-- footer -->
<?php include(TEMPLATES_PATH . '/_footer.php'); ?>




?>
