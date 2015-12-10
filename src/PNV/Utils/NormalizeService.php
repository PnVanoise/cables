<?php

namespace PNV\Utils;


use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;


class NormalizeService{
    private $normalizer;

    function __construct(){
        $this->normalizer = new GetSetMethodNormalizer();
    }

    function normalize($obj, $ignores=array()){
        $this->normalizer->setIgnoredAttributes($ignores);
        return $this->normalizer->normalize($obj);
    }

}
