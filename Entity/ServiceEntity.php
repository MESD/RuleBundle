<?php

namespace Mesd\RuleBundle\Entity;


/**
 * ServiceEntity.
 */
class ServiceEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return ServiceEntity
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $attributes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $actions;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->attributes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->actions    = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add attributes.
     *
     * @param \Mesd\RuleBundle\Entity\AttributeEntity $attributes
     *
     * @return ServiceEntity
     */
    public function addAttribute(\Mesd\RuleBundle\Entity\AttributeEntity $attributes)
    {
        $this->attributes[] = $attributes;

        return $this;
    }

    /**
     * Remove attributes.
     *
     * @param \Mesd\RuleBundle\Entity\AttributeEntity $attributes
     */
    public function removeAttribute(\Mesd\RuleBundle\Entity\AttributeEntity $attributes)
    {
        $this->attributes->removeElement($attributes);
    }

    /**
     * Get attributes.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Add actions.
     *
     * @param \Mesd\RuleBundle\Entity\ActionEntity $actions
     *
     * @return ServiceEntity
     */
    public function addAction(\Mesd\RuleBundle\Entity\ActionEntity $actions)
    {
        $this->actions[] = $actions;

        return $this;
    }

    /**
     * Remove actions.
     *
     * @param \Mesd\RuleBundle\Entity\ActionEntity $actions
     */
    public function removeAction(\Mesd\RuleBundle\Entity\ActionEntity $actions)
    {
        $this->actions->removeElement($actions);
    }

    /**
     * Get actions.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActions()
    {
        return $this->actions;
    }
}
