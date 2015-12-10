<?php
namespace PNV\Utils;
use CrEOF\Spatial\PHP\Types\Geometry\Point;
use CrEOF\Spatial\PHP\Types\Geometry\LineString;
use CrEOF\Spatial\PHP\Types\Geometry\Polygon;

class GeometryService{
    /**
     *Retourne un objet geometrique de type Point
     */
    public function getPoint($coords){
        return new Point($coords[0][0], $coords[0][1], 4326);
    }
    /**
     *Retourne un objet geometrique de type LineString
     */
    public function getLineString($coords){
        return new LineString($coords, 4326);
    }
    /**
     *Retourne un objet geometrique de type Polygon
     */
    public function getPolygon($coords){
        $coords[] = $coords[0];
        $_coords = array();
        foreach($coords as $ptc){
            $_coords[] = $this->getPoint(array($ptc));
        }
        $ls = $this->getLineString($_coords);
        return new Polygon(array($ls), 4326);
    }
}