<?php
$cacheConfig = [
    'path'=>__DIR__. '../../cache',
    'preventCacheSlams'=>true,
    'cacheSlamsTimeout'=>20,
    //'secureFileManipulation'=>true
];
//initialize cache
$cacheInit = new Phpfastcache\Config\ConfigurationOption($cacheConfig);

\Phpfastcache\CacheManager::setDefaultConfig($cacheInit);
$cache = \Phpfastcache\CacheManager::getInstance('Files');