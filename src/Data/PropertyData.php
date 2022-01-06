<?php
namespace App\Data;

use Symfony\Component\Validator\Constraints as Assert;

class PropertyData {

    /**
     * @var int
     */
    public $page = 1;


    /**
     * @var string
     */
    public $job= '';

    
    /**
     * @var string
     */
    public $city= '';

    /**
     * @var null|integer
     * @Assert\Range(max=65000)
     */
    public $max;

     /**
     * @var null|integer
     * @Assert\Range(min=0)
     */
    public $min;



}