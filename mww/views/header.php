<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-133227161-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-133227161-1');
        </script>

        <meta charset="<?php bloginfo('charset'); ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Lucas Bustamante - PHP Back-end developer, specialized in Wordpress.</title>

        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
    <div id="head">Code is Poetry<span class="cursor"></span></div>
    <div id="bar">
        <div id="red"></div>
        <div id="yellow"></div>
        <div id="green"></div>
        <div id="headerText">Terminal</div>
        <div id="bgImage" style="background-image: url(<?= wp_get_attachment_url(5) ?>);">
            <div id="screen">
                <div id="content">