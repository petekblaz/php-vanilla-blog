<?php
include(realpath($_SERVER['DOCUMENT_ROOT'] . '/../app/bootstrap.php'));

// Getting list of all categories
$categories = $article->getCategories();

// If it is POST request, new article was already submitted. Validate & store it
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$articleTitle = $_POST['title'];  
	$articleBody = $_POST['body'];
	$articleCategory = $_POST['category'];
	$articleAuthorId = (int)$_POST['authorId'];

	if ($articleId = $article->validateAndStoreArticle($articleTitle, $articleBody, $articleCategory, $articleAuthorId)) {
		$success_messages[] = 'Article successfully added.';
		header('location: /article.php?id=' . $articleId);
	}
	else {
		$error_messages[] = 'Failed to submit article. Try again!';
	}
}



include(TEMPLATES_PATH . '/_header.php');
?>

<!-- Main content -->
<div class="container container-new-article">
	<div class="col-md-8 col-md-offset-2">

		<form class="article-form" action="" method="post">
			<p>Article Title</p>
			<input type="text" name="title">
			<p>Article Body</p>
			<textarea name="body" rows="8"></textarea>
			<select class="category form-control" name="category">
				<?php foreach ($categories as $category): ?>
					<option value='<?php echo $category["id"]; ?>'><?php echo $category['category_name']; ?></option>
				<?php endforeach; ?>
			</select>
			<input type="hidden" name="authorId" value="1">
			<button type="submit" name="submit">Send now</button>
		</form>

	</div>
</div>
<!-- End of main content -->

<!-- CKEditor script that replaced textarea with ckeditor -->
<script>
    CKEDITOR.replace( 'body' );
</script>

<?php include(TEMPLATES_PATH . '/_footer.php'); ?>
