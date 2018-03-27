<?php

isset($title) ?: $title = '';

?>

<!DOCTYPE html>
<html>

<head>
    <title><?php echo $title ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/uikit.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="/assets/js/uikit.min.js"></script>
    <script src="/assets/js/uikit-icons.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>

</head>

<body class="uk-offcanvas-content">



<div id="menu" uk-offcanvas>
    <div class="uk-offcanvas-bar">

        <button class="uk-offcanvas-close" type="button" uk-close></button>

        <h3>Menu</h3>

        <?php require_once __DIR__ . '/menu.php'; ?>

    </div>
</div>

<div uk-sticky class="uk-background-primary uk-padding-small">
    <button type="button"
            class="uk-button uk-button-secondary uk-display-inline-block uk-margin-small-right"
            style="vertical-align: text-bottom; border: 1px solid white;"
            uk-toggle="target: #menu"
    >
        MENU <span class="uk-margin-small-left" uk-icon="icon: menu"></span>
    </button>
    <h1 class="uk-display-inline-block uk-text-uppercase uk-heading-primary uk-margin-remove">
        Gestion des plannings
    </h1>
</div>
