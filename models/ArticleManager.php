<?php


class ArticleManager {
    
    public function getArticle($url) {
        return DBWrapper::getRow('
            SELECT `clanky_id`, `titulek`, `obsah`, `url`, `popisek`, `klicova_slova`
            FROM `clanky`
            WHERE `url` = ?
        ', array($url));
    }

    public function getArticles() {
        return DBWrapper::getAllRows('
            SELECT `clanky_id`, `titulek`, `url`, `popisek`
            FROM `clanky`
            ORDER BY `clanky_id` DESC
        ');
    }
}