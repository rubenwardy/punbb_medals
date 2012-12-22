Punbb Medals Extension
======================

This project adds user medals to punbb.

![Screenshot of a post](http://multa.bugs3.com/upload/punbb_medals.png)

Setting Up
==========

At the momment, there is no install script, and you need to do some preparation.

1 - Database
------------

Go to the "users" table in the database, and add a field called "medals"

2 - viewtopic.php
-----------------

At line 303 in viewtopic.php, look for a line like this:

    'SELECT'     => 'u.email, u.title, u.url, u.location, u.signature, u.email_setting, u.num_posts,

add 'u.medals' to there

2 - hooks
---------

There is no hook existing in the right place. you need to add one.

Go to line 562 in viewtopic.php, look for a paragraph like this:

    <ul class="author-info">
         <?php echo implode("\n\t\t\t\t\t\t", $forum_page['author_info'])."\n"; ?>
    </ul>

add

    <?php($hook = get_hook('vt_row_userbar_bottom')) ? eval($hook) : null;?>
    
before

    </ul>

