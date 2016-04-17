<?php
namespace FoolCMS;

class Post extends FoolObject {

    private function loadObject($id) {
        $res = Dbaccess::getInstance()->getOneObject($id);
        // res - массив с ключами name, dt_create, content
        // или False, если id не существует
        if ($res) {
            return $this->formatHTML($res);
        }
        else {
            return $res; // вернуть false в случае неудачи
        }
    }

    private function formatHTML($obj) {
        $pattern_text_full = '{(\[text\].*?\[\/text\])}';
        $pattern_text_contents = '{(\[text\](.*?)\[\/text\])}';
        $pattern_p_full = '{(\[p\].*?\[\/p\])}';
        $pattern_p_contents = '{(\[p\](.*?)\[\/p\])}';
        $open = "<article>";
        $close = "</article>";
        $post_hdr = "";
        $post_txt = "";
        if(array_key_exists("name", $obj)) {
            $post_hdr = "<header class=\"post-header\"><h3 class=\"header\">" .
                        $obj["name"] .
                        "</h3></header>";
        }
        if(array_key_exists("content", $obj)) {
            $content = $obj["content"];
            preg_match($pattern_text_contents, $content, $tmp);
            $content = preg_replace($pattern_text_full, "<noindex><div class=\"post-entry\">$tmp[2]</div></noindex>", $content);
            preg_match_all($pattern_p_contents, $content, $tmp, PREG_PATTERN_ORDER);
            foreach($tmp[2] as $match) {
                $content = preg_replace($pattern_p_full, "<p>$match</p>", $content, 1);
            }
            $post_txt = $content;
        }
        return $open . $post_hdr . $post_txt . $close;
    }

    public function get($id) {
        $res = false;
        $res = $this->loadObject($id);
        return $res;
    }
}

?>
