<?php

namespace Aht\Demo\Api\Data;

interface BrandInterface
{
    const ID = "id";

    public function getId();

    public function setId($id);

    public function getName();

    public function setName($name);

    public function getDescription();

    public function setDescription($description);

    public function getLogo();
    
    public function setLogo($logo);
}
