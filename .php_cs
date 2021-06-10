<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/MangoPay')
    ->in(__DIR__.'/tests')
;

$config = new PhpCsFixer\Config();

return $config->setRules([
        '@PSR12' => true,
        'fully_qualified_strict_types' => true,
        'array_syntax' => ['syntax' => 'short'],
        'visibility_required' => ['property', 'method'],// 'const' is removed for old PHP compat
    ])
    ->setFinder($finder)
;
