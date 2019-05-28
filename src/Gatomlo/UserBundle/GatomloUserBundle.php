<?php

namespace Gatomlo\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class GatomloUserBundle extends Bundle
{
  public function getParent()
  {
    return 'FOSUserBundle';
  }
}
