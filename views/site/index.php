<?php

/* @var $this yii\web\View */

$this->title = 'Nix Libro de Aguas';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Bienvenido a nix!</h1>

        <p class="lead">Libro de Aguas desarrollado por la Facultad de Informática de la Universidad Nacional del Comahue.</p>
        <a href="<?=Yii::$app->urlManager->createUrl('site/login');?>"type="button" class="btn btn-success" >Login</a>
        
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Como empezar?</h2>

                <p>Desde cualquier celular instalar la aplicación telegram.  Luego enviarle un mensaje al bot @librodeaguas_bot.
                Dar de alta /rescate, /primerosauxilios, /prevencion o /novedad
             </p>

                <p>Y listo..</p>
            </div>
            <!--
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>-->
        </div>

    </div>
</div>
