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

namespace AskerBundle\Entity\ExerciseResource;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use AskerBundle\Entity\SharedEntity\SharedEntity;

/**
 * Claire exercise resource entity
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class ExerciseResource extends SharedEntity
{
    /**
     * @var ExerciseResource
     */
    protected $parent;

    /**
     * @var ExerciseResource
     */
    protected $forkFrom;

    /**
     * @var Collection
     */
    private $requiredExerciseResources;

    /**
     * @var Collection
     */
    private $requiredKnowledges;

    /**
     * @var Collection
     */
    private $requiredByResources;

    /**
     * @var Collection
     */
    private $requiredByModels;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->requiredExerciseResources = new ArrayCollection();
        $this->requiredKnowledges = new ArrayCollection();
        $this->requiredByResources = new ArrayCollection();
        $this->requiredByModels = new ArrayCollection();
    }

    /**
     * Get requiredExerciseResources
     *
     * @return Collection
     */
    public function getRequiredExerciseResources()
    {
        return $this->requiredExerciseResources;
    }

    /**
     * Set requiredExerciseResources
     *
     * @param Collection $requiredExerciseResources
     */
    public function setRequiredExerciseResources($requiredExerciseResources)
    {
        $this->requiredExerciseResources = $requiredExerciseResources;
    }

    /**
     * Add a Required Exercise Resource
     *
     * @param ExerciseResource $requiredExerciseResource Required Exercise Resource
     */
    public function addRequiredExerciseResource($requiredExerciseResource)
    {
        $this->requiredExerciseResources->add($requiredExerciseResource);
    }

    /**
     * Remove a Required Exercise Resource
     *
     * @param ExerciseResource $requiredExerciseResource Required Exercise Resource
     */
    public function removeRequiredExerciseResource($requiredExerciseResource)
    {
        $this->requiredExerciseResources->removeElement($requiredExerciseResource);
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
     * Set forkFrom
     *
     * @param \AskerBundle\Entity\ExerciseResource\ExerciseResource $forkFrom
     */
    public function setForkFrom($forkFrom)
    {
        $this->forkFrom = $forkFrom;
    }

    /**
     * Get forkFrom
     *
     * @return \AskerBundle\Entity\ExerciseResource\ExerciseResource
     */
    public function getForkFrom()
    {
        return $this->forkFrom;
    }

    /**
     * Set parent
     *
     * @param \AskerBundle\Entity\ExerciseResource\ExerciseResource $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return \AskerBundle\Entity\ExerciseResource\ExerciseResource
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set requiredByResources
     *
     * @param \Doctrine\Common\Collections\Collection $requiredByResources
     */
    public function setRequiredByResources($requiredByResources)
    {
        $this->requiredByResources = $requiredByResources;
    }

    /**
     * Get requiredByResources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRequiredByResources()
    {
        return $this->requiredByResources;
    }

    /**
     * Set requiredByModels
     *
     * @param \Doctrine\Common\Collections\Collection $requiredByModels
     */
    public function setRequiredByModels($requiredByModels)
    {
        $this->requiredByModels = $requiredByModels;
    }

    /**
     * Get requiredByModels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRequiredByModels()
    {
        return $this->requiredByModels;
    }

    /**
     * Add child
     *
     * @param \AskerBundle\Entity\ExerciseResource\ExerciseResource $child
     *
     * @return ExerciseResource
     */
    public function addChild(\AskerBundle\Entity\ExerciseResource\ExerciseResource $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \AskerBundle\Entity\ExerciseResource\ExerciseResource $child
     */
    public function removeChild(\AskerBundle\Entity\ExerciseResource\ExerciseResource $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Add forkedBy
     *
     * @param \AskerBundle\Entity\ExerciseResource\ExerciseResource $forkedBy
     *
     * @return ExerciseResource
     */
    public function addForkedBy(\AskerBundle\Entity\ExerciseResource\ExerciseResource $forkedBy)
    {
        $this->forkedBy[] = $forkedBy;

        return $this;
    }

    /**
     * Remove forkedBy
     *
     * @param \AskerBundle\Entity\ExerciseResource\ExerciseResource $forkedBy
     */
    public function removeForkedBy(\AskerBundle\Entity\ExerciseResource\ExerciseResource $forkedBy)
    {
        $this->forkedBy->removeElement($forkedBy);
    }

    /**
     * Add metadatum
     *
     * @param \AskerBundle\Entity\ExerciseResource\Metadata $metadatum
     *
     * @return ExerciseResource
     */
    public function addMetadatum(\AskerBundle\Entity\ExerciseResource\Metadata $metadatum)
    {
        $this->metadata[] = $metadatum;

        return $this;
    }

    /**
     * Remove metadatum
     *
     * @param \AskerBundle\Entity\ExerciseResource\Metadata $metadatum
     */
    public function removeMetadatum(\AskerBundle\Entity\ExerciseResource\Metadata $metadatum)
    {
        $this->metadata->removeElement($metadatum);
    }

    /**
     * Add requiredKnowledge
     *
     * @param \AskerBundle\Entity\DomainKnowledge\Knowledge $requiredKnowledge
     *
     * @return ExerciseResource
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

    /**
     * Add requiredByResource
     *
     * @param \AskerBundle\Entity\ExerciseResource\ExerciseResource $requiredByResource
     *
     * @return ExerciseResource
     */
    public function addRequiredByResource(\AskerBundle\Entity\ExerciseResource\ExerciseResource $requiredByResource)
    {
        $this->requiredByResources[] = $requiredByResource;

        return $this;
    }

    /**
     * Remove requiredByResource
     *
     * @param \AskerBundle\Entity\ExerciseResource\ExerciseResource $requiredByResource
     */
    public function removeRequiredByResource(\AskerBundle\Entity\ExerciseResource\ExerciseResource $requiredByResource)
    {
        $this->requiredByResources->removeElement($requiredByResource);
    }

    /**
     * Add requiredByModel
     *
     * @param \AskerBundle\Entity\ExerciseModel\ExerciseModel $requiredByModel
     *
     * @return ExerciseResource
     */
    public function addRequiredByModel(\AskerBundle\Entity\ExerciseModel\ExerciseModel $requiredByModel)
    {
        $this->requiredByModels[] = $requiredByModel;

        return $this;
    }

    /**
     * Remove requiredByModel
     *
     * @param \AskerBundle\Entity\ExerciseModel\ExerciseModel $requiredByModel
     */
    public function removeRequiredByModel(\AskerBundle\Entity\ExerciseModel\ExerciseModel $requiredByModel)
    {
        $this->requiredByModels->removeElement($requiredByModel);
    }
}
