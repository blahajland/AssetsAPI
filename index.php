<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>B.L.A.S</title>
    <link rel="stylesheet" href="css/api.css">
    <link rel="icon" href="https://blahaj.land/static/api/?type=image&bucket=pictures&file=favicon">
    <meta property="og:title" content="B.L.A.S">
    <meta property="og:description" content="Blahaj&bull;Land&bull;Assets&bull;Store" />
    <meta property="og:image" content="https://blahaj.land/static/api/?type=image&bucket=pictures&file=thumbnail" />
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:image" content="https://blahaj.land/static/api/?type=image&bucket=pictures&file=thumbnail-twitter" />
    <meta property="twitter:description" content="Blahaj&bull;Land&bull;Assets&bull;Store" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <pre class="anim a1">
<?php echo file_get_contents('ascii/blahaj.txt'); ?>
    </pre>
    <pre class="anim a2">
<?php echo file_get_contents('ascii/title.txt'); ?>
    </pre>
    <p class="anim a3">Blahaj&bull;Land&bull;Assets&bull;Store</p>
    <p><br/></p>
    <p class="warning anim a4">=== Warning ===</p>
    <p class="warning anim a5">This API, while public, is not meant to be used by any other apps or websites.<br/>
        If you're a dev, please refer to the internal API documentation for more information.<br/>
        Otherwise, please enjoy the UI of this page B)</p>
    <p><br/></p>
    <p class="anim a6">=== Current treeview ===</p>
    <div class="anim a7">

        <?php

        include_once "api/_tools.php";

        $tree = getTree('json/filetree.json');

        foreach ($tree as $type => $desc) {
            echo "<ul><li>" . $type;
            if (isset($desc['is-bucket']) && $desc['is-bucket'] === true) {
                echo " <span>(bucket)</span></li><ul>";
                foreach ($desc["buckets"] as $bucket => $bdesc) {
                    echo "<li>" . $bucket . "</li>";
                }
                echo "</ul>";
            } else {
                echo "</li>";
            }
            echo "</ul>";
        }

        ?>
    </div>
    <p><br/></p>
    <p class="anim a8">=== Test function ===</p>
    <form class="fakeInput anim a9" method="get" action="api/">
        <p>api/&quest;type&equals;</p>
        <label for="type">
            <input type="text" name="type">
        </label>
        <p>&amp;bucket&equals;</p>
        <label for="bucket">
            <input type="text" name="bucket">
        </label>
        <p>&amp;file&equals;</p>
        <label for="file">
            <input type="text" name="file">
        </label>
        <button type="submit" class="submit">
            >>> Submit <<<
        </button>
    </form>
</body>
</html>