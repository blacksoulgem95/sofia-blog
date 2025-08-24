<?php

// @var $container \Illuminate\Container\Container
// @var $events \TightenCo\Jigsaw\Events\EventBus

/*
 * You can run custom code at different stages of the build process by
 * listening to the 'beforeBuild', 'afterCollections', and 'afterBuild' events.
 *
 * For example:
 *
 * $events->beforeBuild(function (Jigsaw $jigsaw) {
 *     // Your code here
 * });
 */

// Assicuriamoci che il nostro parser personalizzato venga eseguito prima 
// di qualsiasi altro listener (priorità alta)
$events->beforeBuild(App\Listeners\CustomizeMdParser::class, 100);

// Eseguiamo una funzione in-line dopo la costruzione delle collezioni
// per assicurarci che il Markdown sia processato correttamente
$events->afterCollections(function ($jigsaw) {
    // Otteniamo il convertitore Markdown personalizzato
    $converter = $jigsaw->app->make('markdownConverter');

    // Applichiamo alcune configurazioni aggiuntive se necessario
    if ($converter) {
        // Possiamo aggiungere configurazioni aggiuntive qui se necessario
        // ...
    }
});

$events->afterBuild(App\Listeners\GenerateSitemap::class);
$events->afterBuild(App\Listeners\GenerateIndex::class);
