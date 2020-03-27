<?php
rankCheck(2);
keepOnlineStatus($_SESSION['login']['user']);

echo '
<div>
    <div>
        <table>
        <tr>
            <th>General</th>
            <th>Thread Count</th>
            <th>Last post</th>
        </tr>
        <tr>
            <td><a href="index.php?viewcategory=1">General Discussion</a></td>
            <td>';
            echo countTotalThreads(1);
echo '</td>
            <td>';
            echo displayLastForumPost(1);
echo ' </td>
        </tr>
        <tr>
            <td><a href="index.php?viewcategory=2">Offtopic</a></td>
            <td>';
            echo countTotalThreads(2);
echo '</td>
            <td>';
            echo displayLastForumPost(2);
echo ' </td>
        </tr>
        <tr>
            <td><a href="index.php?viewcategory=3">Technical Support & Help</a></td>
            <td>';
            echo countTotalThreads(3);
echo '</td>
            <td>';
            echo displayLastForumPost(3);
echo ' </td>
        </tr>
        </table>
<br>
        <table>
        <tr>
            <th>News</th>
            <th>Thread Count</th>
            <th>Last post</th>
        </tr>
        <tr>
            <td><a href="index.php?viewcategory=4">Updates</a></td>
            <td>';
            echo countTotalThreads(4);
echo '</td>
            <td>';
            echo displayLastForumPost(4);
echo ' </td>
        </tr>
        <tr>
            <td><a href="index.php?viewcategory=5">Patch Notes</a></td>
            <td>';
            echo countTotalThreads(5);
echo '</td>
            <td>';
            echo displayLastForumPost(5);
echo ' </td>
        </tr>
        <tr>
            <td><a href="index.php?viewcategory=6">Development</a></td>
            <td>';
            echo countTotalThreads(6);
echo '</td>
            <td>';
            echo displayLastForumPost(6);
echo ' </td>
        </tr>        <tr>
            <td><a href="index.php?viewcategory=7">Gitlab Repository</a></td>
            <td>';
            echo countTotalThreads(7);
echo '</td>
            <td>';
            echo displayLastForumPost(7);
echo ' </td>
        </tr>
        </table>
<br>
        <table>
        <tr>
            <th>Guides</th>
            <th>Thread Count</th>
            <th>Last post</th>
        </tr>
        <tr>
            <td><a href="index.php?viewcategory=8">General Gameplay Guides</a></td>
            <td>';
            echo countTotalThreads(8);
echo '</td>
            <td>';
            echo displayLastForumPost(8);
echo ' </td>
        </tr>
        <tr>
            <td><a href="index.php?viewcategory=9">Character Guides</a></td>
            <td>';
            echo countTotalThreads(9);
echo '</td>
            <td>';
            echo displayLastForumPost(9);
echo ' </td>
        </tr>
        <tr>
            <td><a href="index.php?viewcategory=10">Farming Strategies</a></td>
            <td>';
            echo countTotalThreads(10);
echo '</td>
            <td>';
            echo displayLastForumPost(10);
echo ' </td>
        </tr>
        <tr>
            <td><a href="index.php?viewcategory=11">Crafting guides</a></td>
            <td>';
            echo countTotalThreads(11);
echo '</td>
            <td>';
            echo displayLastForumPost(11);
echo ' </td>
        </tr>
        </table>
<br>
    </div>
</div>
';