<?php
/**
 * Post Model
 * 
 * Provides CRUD functionality for a post.
 * Also provides generic functions to retrieve post lists from the database
 * 
 * @param id the post id
 * @param url the post URL
 * @param title the post title
 * @param content the post HTML content
 * @param excerpt the post excerpt
 * @param author_ip the I.P. address of the author
 * @param daily_count the number of posts from the day
 */
class Post {
    var $id;
    var $url;
    var $title;
	var $password;
    var $content;
    var $excerpt;
    var $author_ip;
    
    private static $m_pInstance; 
    
    public static function getInstance() 
    { 
        if (!self::$m_pInstance) 
        { 
            self::$m_pInstance = new Post(); 
        } 

        return self::$m_pInstance; 
    }
    
    private function __construct() {
        $this->author_ip = $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Reads a post from the database by its numeric id. DOES NOT FILTER FOR XSS
     * Also updates view counters.
     * 
     * @param $post Id the id of the post to get
     * @return $tmpl array of template ready data
     */
    public function readIdUnfiltered($postId) {
        global $db;
        
        // Grab the post
        $queryStr = sprintf(
            "SELECT
                p.`post_date`,
                p.`post_title`,
                p.`post_content`,
                p.`post_excerpt`,
                m.`post_views`
            FROM  `posts` p
            INNER JOIN `posts_meta` m
            ON p.`id` = m.`post_id`
            WHERE id = %s
            LIMIT 1",
            $db->real_escape_string($postId));
        
        // Check for valid post id
        if ($query = $db->query($queryStr)) {
            $row = $query->fetch_assoc();
            // Set template variables
            foreach ($row as $key => $data) {
                $tmpl[$key] = $data;
            }
            
            // Update post views
            $updateViewQuery = sprintf(
            "UPDATE `posts_meta` SET 
                `post_views_day` = `post_views_day`+1,
                `post_views_week` =  `post_views_week`+1,
                `post_views_month` =  `post_views_month`+1,
                `post_views_year` =  `post_views_year`+1,
                `post_views` =   `post_views`+1
            WHERE  `posts_meta`.`post_id` =%s;",
            $db->real_escape_string($postId));
            $db->query($updateViewQuery);
            
            // Return template var array on success
            return $tmpl;
        } else {
            return null;
        }
    }

    /**
     * Reads a post from the database by its numeric id.
     * Also updates view counters.
     * 
     * @param $post Id the id of the post to get
     * @return $tmpl array of template ready data
     */
    public function readId($postId) {
        global $db;
        
        // Grab the post
        $queryStr = sprintf(
            "SELECT
                p.`post_date`,
                p.`post_title`,
                p.`post_content`,
                p.`post_excerpt`,
                m.`post_views`
            FROM  `posts` p
            INNER JOIN `posts_meta` m
            ON p.`id` = m.`post_id`
            WHERE id = %s
            LIMIT 1",
            $db->real_escape_string($postId));
        
        // Check for valid post id
        if ($query = $db->query($queryStr)) {
            $row = $query->fetch_assoc();
            // Set template variables
            foreach ($row as $key => $data) {
                $tmpl[$key] = xss_clean($data);
            }
            
            // Update post views
            $updateViewQuery = sprintf(
            "UPDATE `posts_meta` SET 
                `post_views_day` = `post_views_day`+1,
                `post_views_week` =  `post_views_week`+1,
                `post_views_month` =  `post_views_month`+1,
                `post_views_year` =  `post_views_year`+1,
                `post_views` =   `post_views`+1
            WHERE  `posts_meta`.`post_id` =%s;",
            $db->real_escape_string($postId));
            $db->query($updateViewQuery);
            
            // Return template var array on success
            return $tmpl;
        } else {
            return null;
        }
    }
    
    /**
     * checks to see if the alphanumeric URL coresponds to an ID in the post database
     * @param postUrl the URL to check
     * @return boolean whether the URL is valid
     */
    function validUrl($postUrl) {
        global $db;
        $id = alphaID($postUrl, true, PADUP);
        
        $queryStr = sprintf(
            "SELECT id FROM posts WHERE id=%s LIMIT 1",
            $db->real_escape_string($id));
        $db->query($queryStr);

        if ($db->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Retrieves post list from database by date
     * @param $dateFrom the number of seconds back to check
     * @return $tmpl array of template ready data
     */
    public function readFromDate($dateFrom) {
        global $db;
        $date = date('Y-m-d', time() - $dateFrom);
        $queryStr = sprintf(
            "SELECT
                p.`id`,
                p.`post_date`,
                p.`post_title`,
                p.`post_content`,
                p.`post_excerpt`,
                m.`post_views`,
                m.`post_url`
            FROM  `posts` p
            INNER JOIN `posts_meta` m
            ON p.`id` = m.`post_id`
            WHERE `post_date` >  '%s%%'
            ORDER BY `post_views` DESC
            LIMIT 0 , 100",
            $db->real_escape_string($date));
        if ($query = $db->query($queryStr)) {
            while ($row = $query->fetch_assoc()) {
                foreach ($row as $key => $data) {
                    $tmpl[$key][] = xss_clean($data);
                }
            }
            return $tmpl;
        } else {
            return false;
        }
    }
	
	/**
     * Retrieves post list from database by date
     * @param $dateFrom the number of seconds back to check
     * @return $tmpl array of template ready data
     */
    public function readFromNow() {
        global $db;
        $date = date('Y-m-d', time() - $dateFrom);
        $queryStr = sprintf(
            "SELECT
                p.`id`,
                p.`post_date`,
                p.`post_title`,
                p.`post_content`,
                p.`post_excerpt`,
                m.`post_views`,
                m.`post_url`
            FROM  `posts` p
            INNER JOIN `posts_meta` m
            ON p.`id` = m.`post_id`
            ORDER BY `post_date` DESC
            LIMIT 0 , 100");
        if ($query = $db->query($queryStr)) {
            while ($row = $query->fetch_assoc()) {
                foreach ($row as $key => $data) {
                    $tmpl[$key][] = xss_clean($data);
                }
            }
            return $tmpl;
        } else {
            return false;
        }
    }
    
        
		
    /**
     * create a new post
     * 
     * @param title the post title
     * @param content the post content
     * @param excerpt the post excerpt
     */
    public function create($title, $content, $excerpt, $password) {
        global $db;
		
		/**
		 * Prepares content to be used as a post excerpt.
		 * @param content the post content.
		 * @return excerpt a meta ready post excerpt.
		 */
		function prepareExcerpt($content) {
			$excerpt = str_replace('</span>',' ', $content);
			$excerpt = str_replace('<br>',' ', $content);
			$excerpt = str_replace('</li>',' ', $excerpt);
			$excerpt = str_replace('</div>',' ', $excerpt);
			$excerpt = str_replace('.','. ', $excerpt);
			$excerpt = strip_tags($excerpt);
			$excerpt = substr($excerpt, 0, 150);
			return $excerpt;
		}
		
        $this->title = $title;
        $this->content = $content;
        $this->excerpt = (empty($excerpt)) ? prepareExcerpt($content) : $excerpt;
        $this->password = md5($password);
		
        $queryStr = sprintf(
            "INSERT INTO  `lettur`.`posts` (
                `id` ,
                `post_date` ,
                `post_title` ,
                `post_content` ,
                `post_excerpt`
            ) VALUES (
                NULL , NOW() , '%s',  '%s',  '%s');",
                $db->real_escape_string($this->title), 
                $db->real_escape_string($this->content),
                $db->real_escape_string($this->excerpt));
        $db->query($queryStr);
        $this->id = $db->insert_id;
        $this->url = alphaID($this->id, false, PADUP);
        
        $queryStr2 = sprintf(    
            "INSERT INTO  `lettur`.`posts_meta` (
                `post_id` ,
                `post_url` ,
                `post_fulltext` ,
                `post_password` ,
                `post_author_ip` ,
                `post_views_day` ,
                `post_views_week` ,
                `post_views_month` ,
                `post_views_year` ,
                `post_views` ,
                `post_remove_ads`
            ) VALUES ('%s', '%s',  '%s',  '%s',  '%s',  '0',  '0',  '0',  '0',  '0',  '0'
                );",
                $this->id,
                $this->url,
                $db->real_escape_string(strip_tags($this->content)),
                $this->password,
                $db->real_escape_string($this->author_ip));
        $db->query($queryStr2);
    }

    
}

?>