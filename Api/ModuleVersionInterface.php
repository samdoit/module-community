<?php
/**
 * Copyright © Samdoit (support@samdoit.com). All rights reserved.
 * Please visit Samdoit.com for license details (http://www.samdoit.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Samdoit\Community\Api;

/**
 * Return module version by module name
 *
 * @api
 */
interface ModuleVersionInterface
{
    /**
     * Get module version
     *
     * @api
     * @param  string $moduleName
     * @return string
     */
    public function execute(string $moduleName) : string;
}
