<?php

function breadcrumbs()
{
    $segments = request()->segments();
    $breadcrumbs = [];

    foreach ($segments as $index => $segment) {
        $url = implode('/', array_slice($segments, 0, $index + 1));
        $breadcrumbs[] = [
            'label' => ucfirst($segment),
            'url' => url($url),
        ];
    }

    return $breadcrumbs;
}