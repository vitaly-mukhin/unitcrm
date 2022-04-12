<?php

namespace Core\EventListener;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class TablePrefixEventListener
{
    protected array $config;

    /**
     * @param array $config
     */
    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs): void
    {
        $classMetadata = $eventArgs->getClassMetadata();

        if (!$classMetadata->isInheritanceTypeSingleTable() || $classMetadata->getName() === $classMetadata->rootEntityName) {
            $classMetadata->setPrimaryTable([
                'name' => $this->getPrefix($classMetadata->getName(), $classMetadata->getTableName()) . $classMetadata->getTableName(),
            ]);
        }

        foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping) {
            if ($mapping['type'] == ClassMetadataInfo::MANY_TO_MANY && $mapping['isOwningSide']) {
                $mappedTableName = $mapping['joinTable']['name'];
                $classMetadata->associationMappings[$fieldName]['joinTable']['name'] = $this->getPrefix($mapping['targetEntity'], $mappedTableName) . $mappedTableName;
            }
        }
    }

    protected function getPrefix(string $className, string $tableName): string
    {
        $nameSpaces = explode('\\', $className);
        $bundleName = isset($nameSpaces[0]) ? strtolower($nameSpaces[0]) : null;

        if (!$bundleName || !isset($this->config[$bundleName])) {
            return '';
        }

        $prefix = $this->config[$bundleName];
        if (str_starts_with($tableName, $prefix)) {
            return '';
        }

        return $prefix;
    }
}