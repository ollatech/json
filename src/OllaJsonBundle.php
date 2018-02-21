<?php
namespace Olla\Json;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class OllaJsonBundle extends Bundle
{
	public function build(ContainerBuilder $container)
	{
		parent::build($container);
	
	}
}
