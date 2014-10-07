<?php

namespace MicroCMS\DAO;

use MicroCMS\Domain\Comment;

class CommentDAO extends DAO 
{
    /** @var \MicroCMS\DAO\ArticleDAO */
    protected $articleDAO;

    /** @var \MicroCMS\DAO\UserDAO */
    protected $userDAO;

    public function setArticleDAO($articleDAO) {
        $this->articleDAO = $articleDAO;
    }

    public function setUserDAO($userDAO) {
        $this->userDAO = $userDAO;
    }

    /** Returns a list of all comments for an article, sorted by date (most recent first).
     * @param $articleId The article id.
     * @return array A list of all comments for the article. */
    public function findAllByArticle($articleId) {
        $sql = "select * from t_comment where art_id=? order by com_id";
        $result = $this->getDb()->fetchAll($sql, array($articleId));
        
        // Convert query result to an array of Comment objects
        $comments = array();
        foreach ($result as $row) {
            $comId = $row['com_id'];
            $comments[$comId] = $this->buildDomainObject($row);
        }
        return $comments;
    }

    /** Creates an Comment object based on a DB row.
     * @param array $row The DB row containing Comment data.
     * @return \MicroCMS\Domain\Comment */
    protected function buildDomainObject($row) {
        // Find the associated article
        $articleId = $row['art_id'];
        $article = $this->articleDAO->find($articleId);

        // Find the associated user
        $userId = $row['usr_id'];
        $user = $this->userDAO->find($userId);

        $comment = new Comment();
        $comment->setId($row['com_id']);
        $comment->setContent($row['com_content']);
        $comment->setArticle($article);
        $comment->setAuthor($user);
        return $comment;
    }
    
     /** Saves a comment into the database.
     * @param \MicroCMS\Domain\Comment $comment The comment to save */
    public function save($comment) {
        $commentData = array(
            'art_id' => $comment->getArticle()->getId(),
            'usr_id' => $comment->getAuthor()->getId(),
            'com_content' => $comment->getContent()
            );

        if ($comment->getId()) {
            // The comment has already been saved : update it
            $this->getDb()->update('t_comment', $commentData, array('com_id' => $comment->getId()));
        } else {
            // The comment has never been saved : insert it
            $this->getDb()->insert('t_comment', $commentData);
            // Get the id of the newly created comment and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $comment->setId($id);
        }
    }
}