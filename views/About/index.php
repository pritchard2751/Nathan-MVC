
<p>Description of this customised version of Nathan-MVC to follow.</p>

<?php
$contributors = $viewModel->__get('contributors');

if (!empty($contributors)) {
    if (is_array($contributors)) {
        for ($i = 0; $i < count($contributors); $i++) { ?>
            <p>
                <a href="?c=about&a=index&cid=<?php echo $i; ?>">
                <?php echo $contributors[$i]; ?>
                </a>
            </p>
    <?php
        }
    } else {
        echo $contributors;
    }
}

?>
