<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\DeveloperDocumentation\Test;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\TableNode;
use eZ\Publish\API\Repository\Values\ContentType\FieldDefinitionCreateStruct;
use Symfony\Component\Yaml\Yaml;

class EnterpriseTutorialContext implements Context
{
    /** @var \EzSystems\RepositoryForms\Behat\Context\ContentTypeContext */
    private $contentTypeContext;

    private $fieldTypeMap = ['Text line' => 'ezstring', 'Image' => 'ezimage', 'RichText' => 'ezrichtext', 'Text block' => 'eztext'];

    /** @BeforeScenario */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();
        $this->contentTypeContext = $environment->getContext('EzSystems\RepositoryForms\Behat\Context\ContentTypeContext');
    }

    /**
     * @Given I create a :contentTypeName Content Type with :contentTypeIdentifier identifier:
     */
    public function iCreateAContentTypeWithIdentifier($contentTypeName, $contentTypeIdentifier, TableNode $fieldDetails)
    {
        $contentTypeCreateStruct = $this->contentTypeContext->newContentTypeCreateStruct($contentTypeIdentifier);
        $contentTypeCreateStruct->names = ['eng-GB' => $contentTypeName];
        $fieldDefinitions = $this->createFieldDefinitions($fieldDetails);

        foreach ($fieldDefinitions as $definition)
        {
            $contentTypeCreateStruct->addFieldDefinition($definition);
        }

        $this->contentTypeContext->createContentType($contentTypeCreateStruct);
    }

    /**
     * @Given I add field to :contentTypeIdentifier Content Type
     */
    public function iAddFieldToArticleContentType($contentTypeIdentifier, TableNode $fieldDetails)
    {
        $fieldDefinitions = $this->createFieldDefinitions($fieldDetails);
        $this->contentTypeContext->addFieldsTo($contentTypeIdentifier, $fieldDefinitions);
    }

    private function getFieldDefinitionData(array $tableRow, int $position)
    {
        return [
            'fieldTypeIdentifier' => $this->fieldTypeMap[$tableRow['Field Type']],
            'identifier' =>  $tableRow['Identifier'],
            'names' => ['eng-GB' => $tableRow['Name']],
            'position' => $position,
            'isRequired' => $this->parseBool($tableRow['Required']),
            'isTranslatable' => $this->parseBool($tableRow['Translatable']),
            'isSearchable' => $this->parseBool($tableRow['Searchable']),
        ];
    }

    private function createFieldDefinitions(TableNode $fieldDetails) : array
    {
        $positionCounter = 1;
        $fieldDefinitions = [];

        foreach ($fieldDetails->getHash() as $field)
        {
            $fieldDefinitions[] = new FieldDefinitionCreateStruct($this->getFieldDefinitionData($field, $positionCounter++));
        }

        return $fieldDefinitions;
    }

    private function parseBool(string $value): bool
    {
        return $value === 'yes';
    }


}