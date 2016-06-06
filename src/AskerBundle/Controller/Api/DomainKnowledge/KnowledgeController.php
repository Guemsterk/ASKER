<?php
/*
 * This file is part of CLAIRE.
 *
 * CLAIRE is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * CLAIRE is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CLAIRE. If not, see <http://www.gnu.org/licenses/>
 */

namespace AskerBundle\Controller\Api\DomainKnowledge;

use Doctrine\DBAL\DBALException;
use AskerBundle\ApiResourcesBundle\Exception\InvalidKnowledgeException;
use AskerBundle\Controller\BaseController;
use AskerBundle\Entity\DomainKnowledge\Knowledge;
use AskerBundle\Exception\Api\ApiBadRequestException;
use AskerBundle\Exception\Api\ApiConflictException;
use AskerBundle\Exception\Api\ApiNotFoundException;
use AskerBundle\Exception\EntityDeletionException;
use AskerBundle\Exception\NoAuthorException;
use AskerBundle\Exception\NonExistingObjectException;
use AskerBundle\Model\Api\ApiCreatedResponse;
use AskerBundle\Model\Api\ApiDeletedResponse;
use AskerBundle\Model\Api\ApiEditedResponse;
use AskerBundle\Model\Api\ApiGotResponse;
use AskerBundle\Model\Api\ApiResponse;
use AskerBundle\Model\Collection\CollectionInformation;
use AskerBundle\Model\Resources\KnowledgeResource;
use AskerBundle\Model\Resources\KnowledgeResourceFactory;

/**
 * API Knowledge controller
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class KnowledgeController extends BaseController
{
    /**
     * View action. View a knowledge.
     *
     * @param int $knowledgeId
     *
     * @throws ApiNotFoundException
     * @return ApiGotResponse
     */
    public function viewAction($knowledgeId)
    {
        try {
            /** @var KnowledgeResource $knowledge */
            $knowledgeResource = $this->get('asker.exercise.knowledge')->getContentFullResource(
                $knowledgeId,
                $this->getUserId()
            );

            return new ApiGotResponse($knowledgeResource, array("details", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(KnowledgeResource::RESOURCE_NAME);
        }
    }

    /**
     * Get all items
     *
     * @param CollectionInformation $collectionInformation
     *
     * @throws \AskerBundle\Exception\Api\ApiNotFoundException
     * @return ApiGotResponse
     */
    public function listAction(CollectionInformation $collectionInformation)
    {
        try {
            $knowledges = $this->get('asker.exercise.knowledge')->getAll(
                $collectionInformation,
                $this->getUserId()
            );

            $knowledgeResources = KnowledgeResourceFactory::createCollection($knowledges);

            return new ApiGotResponse($knowledgeResources, array(
                'details',
                'Default'
            ));
        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(KnowledgeResource::RESOURCE_NAME);
        }
    }

    /**
     * Create a new knowledge (without metadata)
     *
     * @param KnowledgeResource $knowledgeResource
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @return ApiResponse
     */
    public function createAction(KnowledgeResource $knowledgeResource)
    {
        try {
            $this->validateResource($knowledgeResource, array('create'));

            $userId = $this->getUserId();
            $knowledgeResource->setAuthor($userId);
            $knowledgeResource->setOwner($userId);

            /** @var Knowledge $knowledge */
            $knowledge = $this->get('asker.exercise.knowledge')->createAndAdd
                (
                    $knowledgeResource
                );

            $knowledgeResource = KnowledgeResourceFactory::create($knowledge);

            return new ApiCreatedResponse($knowledgeResource, array("details", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(KnowledgeResource::RESOURCE_NAME);
        } catch (NoAuthorException $nae) {
            throw new ApiBadRequestException($nae->getMessage());
        } catch (InvalidKnowledgeException $ike) {
            throw new ApiBadRequestException($ike->getMessage());
        }
    }

    /**
     * Edit a knowledge
     *
     * @param KnowledgeResource $knowledgeResource   knowledge resource
     * @param int               $knowledgeId
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @throws ApiConflictException
     * @return ApiEditedResponse
     */
    public function editAction(KnowledgeResource $knowledgeResource, $knowledgeId)
    {
        try {
            $this->validateResource($knowledgeResource, array('edit', 'Default'));

            $knowledgeResource->setId($knowledgeId);
            $knowledge = $this->get('asker.exercise.knowledge')->edit
                (
                    $knowledgeResource,
                    $this->getUserId()
                );
            $knowledgeResource = KnowledgeResourceFactory::create($knowledge);

            return new ApiEditedResponse($knowledgeResource);

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(KnowledgeResource::RESOURCE_NAME);
        } catch (DBALException $eoe) {
            throw new ApiConflictException($eoe->getMessage());
        } catch (NoAuthorException $nae) {
            throw new ApiBadRequestException($nae->getMessage());
        }
    }

    /**
     * Delete a knowledge
     *
     * @param int $knowledgeId
     *
     * @throws \AskerBundle\Exception\Api\ApiBadRequestException
     * @throws \AskerBundle\Exception\Api\ApiNotFoundException
     * @return \AskerBundle\Model\Api\ApiDeletedResponse
     */
    public function deleteAction($knowledgeId)
    {
        try {
            $this->get('asker.exercise.knowledge')->remove($knowledgeId, $this->getUserId());

            return new ApiDeletedResponse();

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(KnowledgeResource::RESOURCE_NAME);
        } catch (EntityDeletionException $ede) {
            throw new ApiBadRequestException($ede->getMessage());
        }
    }

    /**
     * Subscribe to a knowledge
     *
     * @param int $knowledgeId
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @return ApiResponse
     */
    public function subscribeAction($knowledgeId)
    {
        try {
            $knowledge = $this->get('asker.exercise.knowledge')->subscribe(
                $this->getUserId(),
                $knowledgeId
            );

            $knowledgeResource = KnowledgeResourceFactory::create($knowledge);

            return new ApiCreatedResponse($knowledgeResource, array("details", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(KnowledgeResource::RESOURCE_NAME);
        }
    }

    /**
     * Duplicate a knowledge
     *
     * @param int $knowledgeId
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @return ApiResponse
     */
    public function duplicateAction($knowledgeId)
    {
        try {
            /** @var Knowledge $knowledge */
            $knowledge = $this->get('asker.exercise.knowledge')->duplicate(
                $knowledgeId,
                $this->getUserId()
            );

            $knowledgeResource = KnowledgeResourceFactory::create($knowledge);

            return new ApiCreatedResponse($knowledgeResource, array("details", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(KnowledgeResource::RESOURCE_NAME);
        }
    }

    /**
     * Import a knowledge
     *
     * @param int $knowledgeId
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @return ApiResponse
     */
    public function importAction($knowledgeId)
    {
        try {
            /** @var Knowledge $knowledge */
            $knowledge = $this->get('asker.exercise.knowledge')->import(
                $this->getUserId(),
                $knowledgeId
            );

            $knowledgeResource = KnowledgeResourceFactory::create($knowledge);

            return new ApiCreatedResponse($knowledgeResource, array("details", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(KnowledgeResource::RESOURCE_NAME);
        }
    }
}
