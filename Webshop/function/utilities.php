<?php
function isPost():bool{
    return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
  }