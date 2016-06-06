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

namespace AskerBundle\Entity\CreatedExercise;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use AskerBundle\Entity\ExerciseModel\ExerciseModel;

/**
 * Claire stored exercise entity
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class StoredExercise
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $content;

    /**
     * @var ExerciseModel
     */
    private $exerciseModel;

    /**
     * @var Collection $items
     */
    private $items;

    /**
     * @var Collection $attempts
     */
    private $attempts;

    /**
     * @var Collection $items
     */
    private $testPositions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->attempts = new ArrayCollection();
    }

    /**
     * Set attempts
     *
     * @param \Doctrine\Common\Collections\Collection $attempts
     */
    public function setAttempts($attempts)
    {
        $this->attempts = $attempts;
    }

    /**
     * Get attempts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttempts()
    {
        return $this->attempts;
    }

    /**
     * Set content
     *
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set exerciseModel
     *
     * @param \AskerBundle\Entity\ExerciseModel\ExerciseModel $exerciseModel
     */
    public function setExerciseModel($exerciseModel)
    {
        $this->exerciseModel = $exerciseModel;
    }

    /**
     * Get exerciseModel
     *
     * @return \AskerBundle\Entity\ExerciseModel\ExerciseModel
     */
    public function getExerciseModel()
    {
        return $this->exerciseModel;
    }

    /**
     * Set id
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set items
     *
     * @param \Doctrine\Common\Collections\Collection $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * Add item
     *
     * @param Item $item
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set testPositions
     *
     * @param \Doctrine\Common\Collections\Collection $testPositions
     */
    public function setTestPositions($testPositions)
    {
        $this->testPositions = $testPositions;
    }

    /**
     * Get testPositions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTestPositions()
    {
        return $this->testPositions;
    }


    /**
     * Remove item
     *
     * @param \AskerBundle\Entity\CreatedExercise\Item $item
     */
    public function removeItem(\AskerBundle\Entity\CreatedExercise\Item $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Add attempt
     *
     * @param \AskerBundle\Entity\CreatedExercise\Attempt $attempt
     *
     * @return StoredExercise
     */
    public function addAttempt(\AskerBundle\Entity\CreatedExercise\Attempt $attempt)
    {
        $this->attempts[] = $attempt;

        return $this;
    }

    /**
     * Remove attempt
     *
     * @param \AskerBundle\Entity\CreatedExercise\Attempt $attempt
     */
    public function removeAttempt(\AskerBundle\Entity\CreatedExercise\Attempt $attempt)
    {
        $this->attempts->removeElement($attempt);
    }

    /**
     * Add testPosition
     *
     * @param \AskerBundle\Entity\Test\TestPosition $testPosition
     *
     * @return StoredExercise
     */
    public function addTestPosition(\AskerBundle\Entity\Test\TestPosition $testPosition)
    {
        $this->testPositions[] = $testPosition;

        return $this;
    }

    /**
     * Remove testPosition
     *
     * @param \AskerBundle\Entity\Test\TestPosition $testPosition
     */
    public function removeTestPosition(\AskerBundle\Entity\Test\TestPosition $testPosition)
    {
        $this->testPositions->removeElement($testPosition);
    }
}
