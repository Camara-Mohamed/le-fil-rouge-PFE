<?php

it('user can see home page', function () {
    $page = visit('/');

    $page->assertSee('Page d\'Accueil');
});
