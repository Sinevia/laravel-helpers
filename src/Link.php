<?php

namespace Sinevia\LaravelHelpers;

class Link {

    prrotected static function query($queryData = []) {
        $queryString = '';
        if (count($queryData)) {
            $queryString = '?' . http_build_query($queryData);
        }
        return $queryString;
    }

}
