<?php

class Article
{
    private $db;

    /**
     * Just set property $db to argument, which
     * has to be an instance of Db object
     *
     * @param Db $db Object Db
     */
    public function __construct(Db $db)
    {
        $this->db = $db->getConnection();
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Get custom number of articles from database, newest first
     *
     * @param  int $numberOfArticles number of articles
     *
     * @return array                        Array of all articles
     */
    public function getArticles($numberOfArticles)
    {
        $stmt = $this->db->prepare(
            'SELECT articles.id, articles.title, articles.body, articles.created_at,
					users.username as author, article_categories.category_name
			FROM articles
			JOIN users ON articles.author_id = users.id
			JOIN article_categories ON articles.category_id = article_categories.id
			ORDER BY articles.id
			LIMIT :numberOfArticles
		');
        $stmt->bindParam(':numberOfArticles', $numberOfArticles, PDO::PARAM_INT);
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $articles;
    }

    /**
     * Returns single article by its ID
     *
     * @param  int $id ID of article
     *
     * @return array Associative array of articles
     */
    public function getSingleArticleById($id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $stmt = $this->db->prepare(
            'SELECT articles.title, articles.body, articles.created_at,
				    article_categories.category_name, users.username as author
			FROM articles
			JOIN article_categories ON articles.category_id = article_categories.id
			JOIN users ON articles.author_id = users.id
			WHERE articles.id = :id
			LIMIT 1
			');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        return $article;
    }

    /**
     * Checks if data is valid.
     * For now, it only checks if everything was filled in
     *
     * @param  string $title    Article title
     * @param  string $body     Article body
     * @param  int    $authorId ID of author
     *
     * @return bool               Return true, if all fields were filled, false otherwise
     */
    public function formDataIsValid($title, $body, $authorId)
    {
        if (!empty($title) && !empty($body) && is_int($authorId)) {
            return true;
        } else {
            return false;
        }
    }

    public function saveArticle($title, $body, $authorId)
    {
        $stmt = $this->db->prepare(
            'INSERT INTO articles
			(title, body, author_id, created_at)
			VALUES (:title, :body, :authorId, :createdAt)
			');
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':body', $body, PDO::PARAM_STR);
        $stmt->bindParam(':authorId', $authorId, PDO::PARAM_INT);
        $currentTime = time();
        $stmt->bindParam(':createdAt', $currentTime, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }
}

