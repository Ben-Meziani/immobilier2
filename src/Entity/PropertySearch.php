<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch {

    /**
     * @var int|null
     */
    private $minPrice;

    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var int|null
     * @Assert\Range(min=10, max=400)
     */
    private $minSurface;

    /**
     * @var int|null
     * @Assert\Range(min=10, max=400)
     */
    private $maxSurface;

    /**
     * @var int|null
     */
    private $city;

    public function __construct()
    {
        $this->options = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * @param int|null $maxPrice
     * @return PropertySearch
     */
    public function setMaxPrice(int $maxPrice): PropertySearch
    {
        $this->maxPrice = $maxPrice;
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
     * @param int|null $minSurface
     * @return PropertySearch
     */
    public function setMinSurface(int $minSurface): PropertySearch
    {
        $this->minSurface = $minSurface;
        return $this;
    }

     /**
     * @return int|null
     */
    public function getMaxSurface()
    {
        return $this->maxSurface;
    }

    /**
     * @param int|null $maxSurface
     * @return PropertySearch
     */
    public function setMaxSurface($maxSurface)
    {
        $this->maxSurface = $maxSurface;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinPrice()
    {
        return $this->minPrice;
    }

    /**
     * @param int|null $minPrice
     * @return PropertySearch
     */
    public function setMinPrice($minPrice)
    {
        $this->minPrice = $minPrice;

        return $this;
    }

}
