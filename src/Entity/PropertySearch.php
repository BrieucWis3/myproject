<?php
namespace App\Entity;

use App\Repository\SearchRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=SearchRepository::class)
 */
class PropertySearch {
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @var int|null
     * @Assert\Range(
     *      min=50000,
     *      max=1000000
     * ) 
     */
    private $maxPrice;
    
    /**
     * @var int|null 
     * @Assert\Range(
     *      min=10,
     *      max=400
     * ) 
     */
    private $minSurface;
   
    /**
     * @var ArrayCollection
     */
    private $options;
    
    public function __contruct() 
    {
        $this->options= new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * @return int|null 
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }
    
    /**
     * @param int|null
     * @return PropertySearch 
     */
    public function setMaxPrice(?int $maxPrice): self
    {
        $this->maxPrice=$maxPrice;
        return $this;
    }
    
    /**
     * @return int|null 
     */
    public function getMinSurface(): ?int
    {
        return $this->minSurface;   
    }
    
    /**
     * @param int|null
     * @return PropertySearch 
     */
    public function setMinSurface(?int $minSurface): self
    {
        $this->minSurface=$minSurface;
        return $this;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getOptions(): ?ArrayCollection
    {
        return $this->options;
    }
    
    /**
     * @param ArrayCollection $options
     */
    public function setOptions(?ArrayCollection $options): void
    {
        $this->options=$options;
        //return $this;
    }
}


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

