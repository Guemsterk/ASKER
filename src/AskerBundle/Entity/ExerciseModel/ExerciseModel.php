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

namespace AskerBundle\Entity\ExerciseModel;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use AskerBundle\Entity\SharedEntity\SharedEntity;

/**
 * Claire exercise model entity
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class ExerciseModel extends SharedEntity
{
    /**
     * @var ExerciseModel
     */
    protected $parent;

    /**
     * @var ExerciseModel
     */
    protected $forkFrom;

    /**
     * @var Collection
     */
    private $exercises;

    /**
    /**
     * @var Collection
     */
    private $requiredExerciseResources;

    /**
     * @var Collection
     */
    private $requiredKnowledges;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->requiredExerciseResources = new ArrayCollection();
        $this->requiredKnowledges = new ArrayCollection();
        $this->exercises = new ArrayCollection();
    }

    /**
     * Set requiredExerciseResources
     *
     * @param \Doctrine\Common\Collections\Collection $requiredExerciseResources
     */
    public function setRequiredExerciseResources($requiredExerciseResources)
    {
        $this->requiredExerciseResources = $requiredExerciseResources;
    }

    /**
     * Get requiredExerciseResources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRequiredExerciseResources()
    {
        return $this->requiredExerciseResources;
    }

    /**
     * Set requiredKnowledges
     *
     * @param \Doctrine\Common\Collections\Collection $requiredKnowledges
     */
    public function setRequiredKnowledges($requiredKnowledges)
    {
        $this->requiredKnowledges = $requiredKnowledges;
    }

    /**
     * Get requiredKnowledges
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRequiredKnowledges()
    {
        return $this->requiredKnowledges;
    }

    /**
     * Set parent
     *
     * @param \AskerBundle\Entity\ExerciseModel\ExerciseModel $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return \AskerBundle\Entity\ExerciseModel\ExerciseModel
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set forkFrom
     *
     * @param \AskerBundle\Entity\ExerciseModel\ExerciseModel $forkFrom
     */
    public function setForkFrom($forkFrom)
    {
        $this->forkFrom = $forkFrom;
    }

    /**
     * Get forkFrom
     *
     * @return \AskerBundle\Entity\ExerciseModel\ExerciseModel
     */
    public function getForkFrom()
    {
        return $this->forkFrom;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getTitle();
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->setTitle($name);
    }

    /**
     * Delete resource node
     */
    /*
	public function deleteResourceNode()
    {
        $this->resourceNode = null;
    }
	*/
	
    /**
     * Set exercises
     *
     * @param \Doctrine\Common\Collections\Collection $exercises
     */
    public function setExercises($exercises)
    {
        $this->exercises = $exercises;
    }

    /**
     * Get exercises
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExercises()
    {
        return $this->exercises;
    }
    /**
     * var \AppBundle\Entity\Resource\ResourceNode
     *//*
    private $resourceNode;*/


    /**
     * Set resourceNode
     *
     * @param \AppBundle\Entity\Resource\ResourceNode $resourceNode
     *
     * @return ExerciseModel
     *//*
    public function setResourceNode(\AppBundle\Entity\Resource\ResourceNode $resourceNode = null)
    {
        $this->resourceNode = $resourceNode;

        return $this;
    }*/

    /**
     * Get resourceNode
     *
     * @return \AppBundle\Entity\Resource\ResourceNode
     *//*
    public function getResourceNode()
    {
        return $this->resourceNode;
    }*/

    /**
     * Add child
     *
     * @param \AskerBundle\Entity\ExerciseModel\ExerciseModel $child
     *
     * @return ExerciseModel
     */
    public function addChild(\AskerBundle\Entity\ExerciseModel\ExerciseModel $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \AskerBundle\Entity\ExerciseModel\ExerciseModel $child
     */
    public function removeChild(\AskerBundle\Entity\ExerciseModel\ExerciseModel $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Add forkedBy
     *
     * @param \AskerBundle\Entity\ExerciseModel\ExerciseModel $forkedBy
     *
     * @return ExerciseModel
     */
    public function addForkedBy(\AskerBundle\Entity\ExerciseModel\ExerciseModel $forkedBy)
    {
        $this->forkedBy[] = $forkedBy;

        return $this;
    }

    /**
     * Remove forkedBy
     *
     * @param \AskerBundle\Entity\ExerciseModel\ExerciseModel $forkedBy
     */
    public function removeForkedBy(\AskerBundle\Entity\ExerciseModel\ExerciseModel $forkedBy)
    {
        $this->forkedBy->removeElement($forkedBy);
    }

    /**
     * Add metadatum
     *
     * @param \AskerBundle\Entity\ExerciseModel\Metadata $metadatum
     *
     * @return ExerciseModel
     */
    public function addMetadatum(\AskerBundle\Entity\ExerciseModel\Metadata $metadatum)
    {
        $this->metadata[] = $metadatum;

        return $this;
    }

    /**
     * Remove metadatum
     *
     * @param \AskerBundle\Entity\ExerciseModel\Metadata $metadatum
     */
    public function removeMetadatum(\AskerBundle\Entity\ExerciseModel\Metadata $metadatum)
    {
        $this->metadata->removeElement($metadatum);
    }

    /**
     * Add exercise
     *
     * @param \AskerBundle\Entity\CreatedExercise\StoredExercise $exercise
     *
     * @return ExerciseModel
     */
    public function addExercise(\AskerBundle\Entity\CreatedExercise\StoredExercise $exercise)
    {
        $this->exercises[] = $exercise;

        return $this;
    }

    /**
     * Remove exercise
     *
     * @param \AskerBundle\Entity\CreatedExercise\StoredExercise $exercise
     */
    public function removeExercise(\AskerBundle\Entity\CreatedExercise\StoredExercise $exercise)
    {
        $this->exercises->removeElement($exercise);
    }

    /**
     * Add requiredExerciseResource
     *
     * @param \AskerBundle\Entity\ExerciseResource\ExerciseResource $requiredExerciseResource
     *
     * @return ExerciseModel
     */
    public function addRequiredExerciseResource(\AskerBundle\Entity\ExerciseResource\ExerciseResource $requiredExerciseResource)
    {
        $this->requiredExerciseResources[] = $requiredExerciseResource;

        return $this;
    }

    /**
     * Remove requiredExerciseResource
     *
     * @param \AskerBundle\Entity\ExerciseResource\ExerciseResource $requiredExerciseResource
     */
    public function removeRequiredExerciseResource(\AskerBundle\Entity\ExerciseResource\ExerciseResource $requiredExerciseResource)
    {
        $this->requiredExerciseResources->removeElement($requiredExerciseResource);
    }

    /**
     * Add requiredKnowledge
     *
     * @param \AskerBundle\Entity\DomainKnowledge\Knowledge $requiredKnowledge
     *
     * @return ExerciseModel
     */
    public function addRequiredKnowledge(\AskerBundle\Entity\DomainKnowledge\Knowledge $requiredKnowledge)
    {
        $this->requiredKnowledges[] = $requiredKnowledge;

        return $this;
    }

    /**
     * Remove requiredKnowledge
     *
     * @param \AskerBundle\Entity\DomainKnowledge\Knowledge $requiredKnowledge
     */
    public function removeRequiredKnowledge(\AskerBundle\Entity\DomainKnowledge\Knowledge $requiredKnowledge)
    {
        $this->requiredKnowledges->removeElement($requiredKnowledge);
    }
}
