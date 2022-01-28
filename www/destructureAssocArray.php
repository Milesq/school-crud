<?php
return function($arr, ...$keys) {
  return array_map(fn($el) => $arr[$el], $keys);
};
