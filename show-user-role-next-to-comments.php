<?php
/**
 * Plugin Name: Show user role next to comments
 * Plugin URI: https://github.com/ramhee98/show-user-role-next-to-comments
 * Description: This simple WordPress plugin shows the user role next to the username when commenting
 * Version: 1.0
 * Author: ramhee
 * Author URI: https://ramhee.ch/
 * License: GPL-3.0
 * License URI: https://github.com/ramhee98/show-user-role-next-to-comments/blob/main/LICENSE
 */

if (!class_exists("WPB_Comment_Author_Role_Label")):
    class WPB_Comment_Author_Role_Label
    {
        public function __construct()
        {
            add_filter(
                "get_comment_author",
                [$this, "wpb_get_comment_author_role"],
                10,
                3
            );
            add_filter("get_comment_author_link", [
                $this,
                "wpb_comment_author_role",
            ]);
        }

        // Get comment author role
        function wpb_get_comment_author_role($author, $comment_id, $comment)
        {
            $authoremail = get_comment_author_email($comment);
            // Check if user is registered
            if (email_exists($authoremail)) {
                $commet_user_role = get_user_by("email", $authoremail);
                $comment_user_role = $commet_user_role->roles[0];
                // HTML output to add next to comment author name
                $this->comment_user_role =
                    ' <span class="comment-author-label comment-author-label-' .
                    $comment_user_role .
                    '">' .
                    ucfirst($comment_user_role) .
                    "</span>";
            } else {
                $this->comment_user_role = "";
            }
            return $author;
        }

        // Display comment author
        function wpb_comment_author_role($author)
        {
            return $author .= $this->comment_user_role;
        }
    }
    new WPB_Comment_Author_Role_Label();
endif;

?>
