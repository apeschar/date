<?php

return (new PhpCsFixer\Config())
    ->setFinder(PhpCsFixer\Finder::create()->in(__DIR__))
    ->setRules([
        '@PSR12' => true,
        'braces' => [
            'position_after_functions_and_oop_constructs' => 'same',
        ],
    ]);
