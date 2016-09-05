<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/lib/bootstrap/img/favicon.ico">

    <title>Off Canvas Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/lib/bootstrap/css/offcanvas.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="/lib/bootstrap/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<?php
$this->getChildren();
$this->createTree();
$categories = $this->getCategories();

?>

<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Project name</a>
        </div>


        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <?php foreach ($categories[0] as $item): ?>
                        <li class="active dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="<?php echo '/' . $item['url_key'] ?>.html"><?php echo $this->getAttr($item['id'], 'name')  ?> <?php if (!empty($categories[$item['id']])): ?><b class="caret"></b><?php endif; ?></a>
                            <?php if (!empty($categories[$item['id']])): ?>
                                <ul class="dropdown-menu">
                                    <?php foreach ($categories[$item['id']] as $subItem): ?>
                                        <li>
                                            <a href="<?php echo '/' . $item['url_key'] . '/' . $subItem['url_key'] ?>.html"><?php echo $this->getAttr($subItem['id'], 'name')  ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>

                            <?php endif; ?>
                        </li>
                <?php endforeach; ?>
            </ul>
        </div><!-- /.nav-collapse -->


    </div><!-- /.container -->
</div><!-- /.navbar -->

<div class="container">
