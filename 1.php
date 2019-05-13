<?php
/**
 * Only adjust bitfields, do not rewrite text...
 * All new parsings have the img, flash and quote modes set to true
 *
 * You should make a backup from your users, posts and privmsgs table in case something goes wrong
 * Forum descriptions and rules need to be re-submitted manually.
 */
die("Please read the first lines of this script for instructions on how to enable it");

set_time_limit(0);

define('IN_PHPBB', true);
$phpbb_root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/message_parser.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();


$echos = 0;
function html_to_bbcode_replace($text, $bbcode_uid)
{
    $search = array(
        '/<(span|http)>/is',   //Tag: Open: Ignore: span
        '/<\/(li|p|span)>/is',   //Tag: Close: Ignore: li, p, span
        '/( target| title| style| class| id| rel)=(\'|"|")?(_blank|[^&]+)(\'|"|")?/is',   //Attribute: Ignore: target, title, style
        '/<>/is',    //Special Case: Some people throw gt's instead of bullet points
        '/<blockquote>/is',
        '/<\/blockquote>/is',
        '/<(strong|b)>/is',
        '/<\/(strong|b)>/is',
        '/<(em|i)>/is',
        '/<\/(em|i)>/is',
        '/<u>/is',
        '/<\/u>/is',
        '/<ul( )?>/is',
        '/<ul class=("|")list_small("|")>/is',
        '/<\/(ul|ol|0l)>/is',
        '/<(ol|0l|OL)>/is',
        '/<li>/is',   //Tag: li
        '/<br>/is',
        '/<p>/is',
        '/<img src=("|")([^ ]+)("|")( (width|height|border|alt)=("|")([^"]?)("|"))*>/is',  //Tag: img
        '/<\/a>/is',   //Tag: link: close
        '/<a href="([^ ]+)">([^\[]+)/is',   //Tag: link: simple
        '/<a href=("|")([^ ]+)("|")( )?>([^\[]+)/is',   //Tag: link
        '/<a href=(\')([^ ]+)(\')( )?>([^\[]+)/is',   //Tag: link
        '/<a href=(\'|"|")([^ ]+)(\'|"|")>\[\/url/is',    //Special-Case: This handles links without anchortext
    );
    $replace = array(
        '',   //Tag: Open: Ignore
        '',   //Tag: Close: Ignore
        '',   //Attribute: Ignore: target,
        '&bull;',    //Special Case: Some people throw gt's instead of bullet points
        '[quote:' . $bbcode_uid . ']',
        '[/quote:' . $bbcode_uid . ']',
        '[b:' . $bbcode_uid . ']',
        '[/b:' . $bbcode_uid . ']',
        '[i:' . $bbcode_uid . ']',
        '[/i:' . $bbcode_uid . ']',
        '[u:' . $bbcode_uid . ']',
        '[/u:' . $bbcode_uid . ']',
        '[list:' . $bbcode_uid . ']',
        '[list:' . $bbcode_uid . ']',
        '[/list:' . $bbcode_uid . ']',
        '[list=1:' . $bbcode_uid . ']',
        '[*:' . $bbcode_uid . ']',   //Tag: li
        "\n\n",
        "\n\n",
        '[img:' . $bbcode_uid . ']$2[/img]',
        '[/url:' . $bbcode_uid . ']',   //Tag: link: close
        '[url=$1:' . $bbcode_uid . ']$2',   //Tag: link: simple
        '[url=$2:' . $bbcode_uid . ']$5',   //Tag: link
        '[url=$2:' . $bbcode_uid . ']$5',   //Tag: link
        '[url=$2:' . $bbcode_uid . ']$2[/url',
    );

    return preg_replace($search, $replace, $text);
}

function html_to_bbcode()
{
    global $db;

    // Convert HTML to BBCode in posts
    $tables = array('post', 'pm', 'sig');
    $tables = array('post');

    // Pull only the posts that have HTML in them.
    $sql['select']['post'] = "SELECT post_id, post_text, bbcode_uid
       FROM " . POSTS_TABLE . "
       WHERE
        post_text LIKE '%&lt%'";

    //For private messages:
    $sql['select']['pm'] = 'SELECT msg_id, message_text, bbcode_uid
       FROM ' . PRIVMSGS_TABLE . "
       WHERE
        message_text LIKE '%&lt%'";

    //For signatures:
    $sql['select']['sig'] = 'SELECT user_id, user_sig, user_sig_bbcode_uid
       FROM ' . USERS_TABLE . "
       WHERE
        user_sig LIKE '%&lt%'";

    foreach ( $tables as $table )
    {
        $result = $db->sql_query($sql['select'][$table]);

        echo '<pre>';
        //echo sizeof($db->sql_fetchrow($result));
        echo mysql_num_rows($result);
        while ($row = $db->sql_fetchrow($result))
        {
            //Standardize the variable references across the tables
            $text = $row['post_text'] . $row['user_sig'] . $row['message_text'];
            $bbcode_uid = $row['bbcode_uid'] . $row['user_sig_bbcode_uid'];
            $record_id = $row['post_id'] . $row['user_id'] . $row['msg_id'];

            echo '
            Before:
            ' . $row['post_id'] . ' ' . $row['count'] . $row['post_text'];
            //preg out the junk
            $text = html_to_bbcode_replace($text, $bbcode_uid);
            echo '
            After:
            ' . $text;

            $sql['update']['post'] = 'UPDATE ' . POSTS_TABLE . " SET post_text = '". $db->sql_escape($text) ."'
                 WHERE post_id = " . $record_id;

            $sql['update']['pm'] = 'UPDATE ' . PRIVMSGS_TABLE . " SET message_text = '". $db->sql_escape($text) ."'
                 WHERE msg_id = " . $record_id;

            $sql['update']['sig'] = 'UPDATE ' . USERS_TABLE . " SET user_sig = '". $db->sql_escape($text) ."'
                 WHERE user_id = " . $record_id;

            $db->sql_query($sql['update'][$table]);

            flush();
        }
        $db->sql_freeresult($result);
    }

    echo "<br>Finished with topics...<br>";

}











if ( isset($_GET['1']) )
{
    html_to_bbcode();
    die();
}
else if ( isset($_GET['2']) )
{

    // Adjust user signatures

    $message_parser = new parse_message();
    $message_parser->mode = 'sig';
    $message_parser->bbcode_init();

    $sql = 'SELECT user_id, user_sig, user_sig_bbcode_uid, user_sig_bbcode_bitfield
       FROM ' . USERS_TABLE;
    $result = $db->sql_query($sql);

    while ($row = $db->sql_fetchrow($result))
    {
        // Convert bbcodes back to their normal form
        if ($row['user_sig_bbcode_uid'] && $row['user_sig'])
        {
            decode_message($row['user_sig'], $row['user_sig_bbcode_uid']);

            $message_parser->message = &$row['user_sig'];
            $bbcodeId = $message_parser->bbcode_uid;

            $message_parser->prepare_bbcodes();
            $message_parser->parse_bbcode();

            $bitfield = $message_parser->bbcode_bitfield;

            $sql = 'UPDATE ' . USERS_TABLE . " SET user_sig = '" . $db->sql_escape($row['user_sig']) . "', user_sig_bbcode_uid = '" . $db->sql_escape($bbcodeId) . "', user_sig_bbcode_bitfield = '" . $db->sql_escape($bitfield) . "'
             WHERE user_id = " . $row['user_id'];
            $db->sql_query($sql);

            if ($echos > 100)
            {
                echo '<br />' . "\n <strong>USER_ID = " . $row['user_id'] . "</strong>";
                $echos = 0;
            }

            echo $row['user_id'] . '.';
            $echos++;

            flush();
        }
        else
        {
            $sql = 'UPDATE ' . USERS_TABLE . " SET user_sig_bbcode_bitfield = ''
             WHERE user_id = " . $row['user_id'];
            $db->sql_query($sql);
        }
    }
    $db->sql_freeresult($result);


    echo "<br>Finished with signatures...<br>";
    // Now adjust posts

    $message_parser = new parse_message();
    $message_parser->mode = 'post';
    $message_parser->bbcode_init();

    // Update posts
    $sql = "SELECT post_id, post_text, bbcode_uid, enable_bbcode, enable_smilies, enable_sig
       FROM " . POSTS_TABLE . " WHERE post_text LIKE '%[%'";
    $result = $db->sql_query($sql);

    while ($row = $db->sql_fetchrow($result))
    {
        // Convert bbcodes back to their normal form
        if ($row['enable_bbcode'])
        {
            decode_message($row['post_text'], $row['bbcode_uid']);

            $message_parser->message = &$row['post_text'];
            $bbcodeId = $message_parser->bbcode_uid;

            $message_parser->prepare_bbcodes();
            $message_parser->parse_bbcode();

            $bitfield = $message_parser->bbcode_bitfield;

            $sql = 'UPDATE ' . POSTS_TABLE . " SET post_text = '". $db->sql_escape($row['post_text']) ."', bbcode_uid = '". $db->sql_escape($bbcodeId) ."', bbcode_bitfield = '" . $db->sql_escape($bitfield) . "'
             WHERE post_id = " . $row['post_id'];
            $db->sql_query($sql);

            if ($echos > 100)
            {
                echo '<br />' . "\n <strong>POST_ID = " . $row['post_id'] . "</strong>";
                $echos = 0;
            }

            echo $row['post_id'] . '.';
            $echos++;

            flush();
        }
        else
        {
            $sql = 'UPDATE ' . POSTS_TABLE . " SET bbcode_bitfield = ''
             WHERE post_id = " . $row['post_id'];
            $db->sql_query($sql);
        }
    }
    $db->sql_freeresult($result);

    echo "<br>Finished with topics...<br>";

    // Now to the private messages
    $message_parser = new parse_message();
    $message_parser->mode = 'post';
    $message_parser->bbcode_init();

    // Update pms
    $sql = 'SELECT msg_id, message_text, bbcode_uid, enable_bbcode
       FROM ' . PRIVMSGS_TABLE;
    $result = $db->sql_query($sql);

    while ($row = $db->sql_fetchrow($result))
    {
        // Convert bbcodes back to their normal form
        if ($row['enable_bbcode'])
        {
            decode_message($row['message_text'], $row['bbcode_uid']);

            $message_parser->message = &$row['message_text'];
            $bbcodeId = $message_parser->bbcode_uid;

            $message_parser->prepare_bbcodes();
            $message_parser->parse_bbcode();

            $bitfield = $message_parser->bbcode_bitfield;

            $sql = 'UPDATE ' . PRIVMSGS_TABLE . " SET message_text = '" . $db->sql_escape($row['message_text']) . "', bbcode_uid = '" . $db->sql_escape($bbcodeId) . "', bbcode_bitfield = '" . $db->sql_escape($bitfield) . "'
             WHERE msg_id = " . $row['msg_id'];
            $db->sql_query($sql);

            if ($echos > 100)
            {
                echo '<br />' . "\n <strong>MESSAGE_ID = " . $row['msg_id'] . "</strong>";
                $echos = 0;
            }

            echo $row['msg_id'] . '...';
            $echos++;

            flush();
        }
        else
        {
            $sql = 'UPDATE ' . PRIVMSGS_TABLE . " SET bbcode_bitfield = ''
             WHERE msg_id = " . $row['msg_id'];
            $db->sql_query($sql);
        }
    }
    $db->sql_freeresult($result);

    echo "<br>Finished with private messages...<br>";

    // Done
    $db->sql_close();
}
else header('Location:http://www.denverpost.com');
?>