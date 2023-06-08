<?php
/**
 * Copyright © Samdoit (support@samdoit.com). All rights reserved.
 * Please visit Samdoit.com for license details (http://www.samdoit.com/end-user-license-agreement).
 */

namespace Samdoit\Community\Cron;

use Samdoit\Community\Model\SectionFactory;
use Samdoit\Community\Model\Section\Info;
use Magento\Framework\App\ResourceConnection;

/**
 * Class Sections
 * @package Samdoit\Community
 */
class Sections
{
    /**
     * @var SectionFactory
     */
    protected $sectionFactory;

    /**
     * @var Info
     */
    protected $info;

    /**
     * @var ResourceConnection
     */
    protected $resource;

    /**
     * Sections constructor.
     * @param ResourceConnection $resource
     * @param SectionFactory $sectionFactory
     * @param Info $info
     */
    public function __construct(
        ResourceConnection $resource,
        SectionFactory $sectionFactory,
        Info $info
    ) {
        $this->resource = $resource;
        $this->sectionFactory = $sectionFactory;
        $this->info = $info;
    }

    /**
     * Execute cron job
     */
    public function execute()
    {
        $connection = $this->resource->getConnection();
        $table = $this->resource->getTableName('core_config_data');
        $path = 'gen' . 'er' . 'al'. '/' . 'ena' . 'bled';

        $select = $connection->select()->from(
            [$table]
        )->where(
            'path LIKE ?',
            '%' . $path
        );

        $sections = [];
        foreach ($connection->fetchAll($select) as $config) {
            $matches = false;
            preg_match("/(.*)\/" . str_replace('/', '\/', $path) . "/", $config['path'], $matches);
            if (empty($matches[1])) {
                continue;
            }
            $section = $this->sectionFactory->create([
                'name' => $matches[1]
            ]);

            if ($section->getModule()) {
                $sections[$section->getModule()] = $section;
            } else {
                unset($section);
            }
        }

        if (count($sections)) {
            $data = $this->info->load($sections);

            if ($data && is_array($data)) {
                foreach ($data as $module => $item) {
                    $section = $sections[$module];
                    if (!$section->validate($data)) {
                        $connection->update(
                            $table,
                            [
                                'value' => 0
                            ],
                            ['path = ? ' => $section->getName() . '/' . $path]
                        );
                    }
                }
            }
        }
    }
}
