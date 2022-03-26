<?php

function cmp($a, $b): bool
{
    return strtotime($a->released) > strtotime($b->released);
}
