<?php

    function getGETParameter(string $key): ?string
    {
        return $_GET[$key] ?? null;
    }