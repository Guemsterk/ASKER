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

namespace AskerBundle\Entity\DomainKnowledge;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use AskerBundle\Entity\SharedEntity\SharedEntity;

/**
 * Claire exercise knowledge entity
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class Knowledge extends SharedEntity
{
    /**
     * @var Knowledge
     */
    protected $parent;

    /**
     * @var Knowledge
     */
    protected $forkFrom;

    /**
     * @var Collection
     */
    private $requiredKnowledges;

    /**
     * @var Collection
     */
    private $requiredByKnowledges;

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
        $this->requiredKnowledges = new ArrayCollection();
        $this->requiredByKnowledges = new ArrayCollection();
        $this->requiredByResources = new ArrayCollection();
        $this->requiredByModels = new ArrayCollection();
    }

    /**
     * Get requiredKnowledges
     *
     * @return Collection
     */
    public function getRequiredKnowledges()
    {
        return $this->requiredKnowledges;
    }

    /**
     * Set requiredKnowledges
     *
     * @param Collection $requiredKnowledges
     */
    public function setRequiredKnowledges($requiredKnowledges)
    {
        $this->requiredKnowledges = $requiredKnowledges;
    }

    /**
     * Add a Required  Knowledge
     *
     * @param Knowledge $requiredKnowledge Required  Knowledge
     */
    public function addRequiredKnowledge($requiredKnowledge)
    {
        $this->requiredKnowledges->add($requiredKnowledge);
    }

    /**
     * Remove a Required  Knowledge
     *
     * @param Knowledge $requiredKnowledge Required  Knowledge
     */
    public function removeRequiredKnowledge($requiredKnowledge)
    {
        $this->requiredKnowledges->removeElement($requiredKnowledge);
    }

    /**
     * Set forkFrom
     *
     * @param \AskerBundle\Entity\DomainKnowledge\Knowledge $forkFrom
     */
    public function setForkFrom($forkFrom)
    {
        $this->forkFrom = $forkFrom;
    }

    /**
     * Get forkFrom
     *
     * @return \AskerBundle\Entity\DomainKnowledge\Knowledge
     */
    public function getForkFrom()
    {
        return $this->forkFrom;
    }

    /**
     * Set parent
     *
     * @param \AskerBundle\Entity\DomainKnowledge\Knowledge $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return \AskerBundle\Entity\DomainKnowledge\Knowledge
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set requiredByKnowledges
     *
     * @param \Doctrine\Common\Collections\Collection $requiredByKnowledges
     */
    public function setRequiredByKnowledges($requiredByKnowledges)
    {
        $this->requiredByKnowledges = $requiredByKnowledges;
    }

    /**
     * Get requiredByKnowledges
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRequiredByKnowledges()
    {
        return $this->requiredByKnowledges;
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
     * Add child
     *
     * @param \AskerBundle\Entity\DomainKnowledge\Knowledge $child
     *
     * @return Knowledge
     */
    public function addChild(\AskerBundle\Entity\DomainKnowledge\Knowledge $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \AskerBundle\Entity\DomainKnowledge\Knowledge $child
     */
    public function removeChild(\AskerBundle\Entity\DomainKnowledge\Knowledge $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Add forkedBy
     *
     * @param \AskerBundle\Entity\DomainKnowledge\Knowledge $forkedBy
     *
     * @return Knowledge
     */
    public function addForkedBy(\AskerBundle\Entity\DomainKnowledge\Knowledge $forkedBy)
    {
        $this->forkedBy[] = $forkedBy;

        return $this;
    }

    /**
     * Remove forkedBy
     *
     * @param \AskerBundle\Entity\DomainKnowledge\Knowledge $forkedBy
     */
    public function removeForkedBy(\AskerBundle\Entity\DomainKnowledge\Knowledge $forkedBy)
    {
        $this->forkedBy->removeElement($forkedBy);
    }

    /**
     * Add metadatum
     *
     * @param \AskerBundle\Entity\DomainKnowledge\Metadata $metadatum
     *
     * @return Knowledge
     */
    public function addMetadatum(\AskerBundle\Entity\DomainKnowledge\Metadata $metadatum)
    {
        $this->metadata[] = $metadatum;

        return $this;
    }

    /**
     * Remove metadatum
     *
     * @param \AskerBundle\Entity\DomainKnowledge\Metadata $metadatum
     */
    public function removeMetadatum(\AskerBundle\Entity\DomainKnowledge\Metadata $metadatum)
    {
        $this->metadata->removeElement($metadatum);
    }

    /**
     * Add requiredByResource
     *
     * @param \AskerBundle\Entity\ExerciseResource\ExerciseResource $requiredByResource
     *
     * @return Knowledge
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
     * @return Knowledge
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

    /**
     * Add requiredByKnowledge
     *
     * @param \AskerBundle\Entity\DomainKnowledge\Knowledge $requiredByKnowledge
     *
     * @return Knowledge
     */
    public function addRequiredByKnowledge(\AskerBundle\Entity\DomainKnowledge\Knowledge $requiredByKnowledge)
    {
        $this->requiredByKnowledges[] = $requiredByKnowledge;

        return $this;
    }

    /**
     * Remove requiredByKnowledge
     *
     * @param \AskerBundle\Entity\DomainKnowledge\Knowledge $requiredByKnowledge
     */
    public function removeRequiredByKnowledge(\AskerBundle\Entity\DomainKnowledge\Knowledge $requiredByKnowledge)
    {
        $this->requiredByKnowledges->removeElement($requiredByKnowledge);
    }
}
