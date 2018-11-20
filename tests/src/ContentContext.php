<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\DeveloperDocumentation\Test;


use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\API\Repository\Repository;
use eZ\Publish\API\Repository\Values\Content\ContentCreateStruct;
use eZ\Publish\Core\FieldType\Image\Value;

class ContentContext implements Context
{
    /** @var Repository */
    private $repository;

    /** @var ContentService */
    private $contentService;

    /** @var LocationService */
    private $locationService;

    private const ADMIN_USER_ID = 14;

    private $pathStringLocationMap;

    public function __construct($repository)
    {
        $this->repository = $repository;
        $this->contentService = $this->repository->getContentService();
        $this->locationService = $this->repository->getLocationService();
        $this->pathStringLocationMap = ["Home" => 2];
    }


    public function createContent($contentTypeIdentifier, $parentPathString, $contentItemData)
    {
        $this->repository->setCurrentUser( $this->repository->getUserService()->loadUser( self::ADMIN_USER_ID ) );
        $locationCreateStruct = $this->locationService->newLocationCreateStruct($this->pathStringLocationMap[$parentPathString]);
        $contentType = $this->repository->getContentTypeService()->loadContentTypeByIdentifier($contentTypeIdentifier);
        $contentCreateStruct = $this->contentService->newContentCreateStruct( $contentType, 'eng-GB' );


        switch ($contentTypeIdentifier)
        {
            case 'folder':
                $this->createFolder($contentCreateStruct, $contentItemData);
                break;
            case 'article':
                $this->createArticle($contentCreateStruct, $contentItemData);
                break;
            case 'tip':
                $this->createTip($contentCreateStruct, $contentItemData);
                break;
            case 'dog_breed':
                $this->createDogBreed($contentCreateStruct, $contentItemData);
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Unrecognised content type: %s', $contentTypeIdentifier));
        }

        $draft = $this->contentService->createContent( $contentCreateStruct, array( $locationCreateStruct ) );
        $content = $this->contentService->publishVersion( $draft->versionInfo );

        $newItemPathString = sprintf('%s/%s', $parentPathString, $contentItemData['contentName']);
        $this->pathStringLocationMap[$newItemPathString] = $content->contentInfo->mainLocationId;
    }

    /**
     * @Given I create :contentTypeIdentifier Content items in :parentPathString
     */
    public function createContentItems($contentTypeIdentifier, $parentPathString, TableNode $contentItemsData)
    {
        foreach($contentItemsData as $contentItemData)
        {
            $this->createContent($contentTypeIdentifier, $parentPathString, $contentItemData);
        }
    }

    private function createDogBreed($contentCreateStruct, $data)
    {

    }

    private function createTip($contentCreateStruct, $data)
    {
        $contentCreateStruct->setField('title', $data['contentName']);
        $contentCreateStruct->setField('body', $data['contentName']);
    }

    private function createArticle($contentCreateStruct, $data)
    {
        $contentCreateStruct->setField('title', $data['contentName']);
        $contentCreateStruct->setField('short_title	', $data['contentName']);

        $filePath = sprintf("images/Photos/Article images/%s", $data['imageName']);
        $value = new Value(
            array(
                'path' => $filePath,
                'fileSize' => filesize( $filePath ),
                'fileName' => basename( $filePath ),
                'alternativeText' => $filePath
            )
        );
        $contentCreateStruct->setField( 'image', $value );

        $inputString = '<<<DOCBOOK
<?xml version="1.0" encoding="UTF-8"?>
<section xmlns="http://docbook.org/ns/docbook"
         xmlns:xlink="http://www.w3.org/1999/xlink"
         xmlns:ezxhtml="http://ez.no/xmlns/ezpublish/docbook/xhtml"
         xmlns:ezcustom="http://ez.no/xmlns/ezpublish/docbook/custom"
         version="5.0-variant ezpublish-1.0">
    <title ezxhtml:level="2">This is a Dog Article.</title>
    <para ezxhtml:class="paraClass">This is a Dog Paragraph.</para>
</section>
DOCBOOK;';

        $contentCreateStruct->setField( "body", $inputString );
    }

    private function createFolder($contentCreateStruct, $data)
    {
        $contentCreateStruct->setField('name', $data['contentName']);
        $contentCreateStruct->setField('short_name', $data['contentName']);
    }
}