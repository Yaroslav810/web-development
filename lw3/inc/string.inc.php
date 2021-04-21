<?php

    function isIdentifier(?string $identifier): bool
    {
        if (is_null($identifier))
        {
            throw new Exception('Нет идентификатора "identifier"!');
        }

        if (mb_strlen($identifier) === 0)
        {
            throw new Exception('Пустой идентификатор "identifier"!');
        }

        if (!ctype_alpha($identifier[0]))
        {
            throw new Exception('Первый символ не является латинской буквой');
        }

        if (!ctype_alnum($identifier))
        {
            throw new Exception('Строка не является буквенно-цифровой');
        }

        return true;
    }