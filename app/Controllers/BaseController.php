<?php

namespace App\Controllers;

class BaseController
{
  protected function sanitizeString(string $value): string
  {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
  }
}
