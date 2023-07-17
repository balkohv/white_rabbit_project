<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LocationRepository::class)
 */
class Location
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;
    
    /**
     * @ORM\Column(type="string", length=30)
     */
    private $ville;
    
    /**
     * @ORM\Column(type="string", length=30)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $codePostal;
    
    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $note;
    
    /**
     * @ORM\Column(type="string", length=30)
     */
    private $pays;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $estimation;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $french;

    /**
     * @ORM\Column(type="boolean")
     */
    private $made=false;

    /**
     * @ORM\Column(type="float")
     */
    private $lon;

    /**
     * @ORM\Column(type="float")
     */
    private $lat;

    /**
     * @ORM\Column(type="integer")
     */
    private $dist;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }
    
    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }
    
    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }
    
    public function getEstimation(): ?string
    {
        return $this->estimation;
    }

    public function setEstimation(int $estimation): self
    {
        $this->estimation = $estimation;

        return $this;
    }
    
    public function getFrench(): ?bool
    {
        return $this->french;
    }

    public function setFrench(bool $french): self
    {
        $this->french = $french;

        return $this;
    }

    public function getMade(): ?bool
    {
        return $this->made;
    }

    public function setMade(bool $made): self
    {
        $this->made = $made;

        return $this;
    }

    public function setLonLat()
    {   
        //dd('https://api-adresse.data.gouv.fr/search/?q='.str_replace(' ', '+',$this->adresse." ".$this->codePostal." ".$this->ville));
        $json = file_get_contents('https://api-adresse.data.gouv.fr/search/?q='.str_replace(' ', '+',$this->adresse." ".$this->codePostal." ".$this->ville));
        $data = json_decode($json);
        if(count($data->features)>0 && $data->features[0] != null){
            $this->lon = $data->features[0]->geometry->coordinates[0];
            $this->lat = $data->features[0]->geometry->coordinates[1];
        }else{
            $this->lat=0.0;
            $this->lon=0.0;
        }
        return $this;
    }


    public function getLon(): ?float
    {
        return $this->lon;
    }

    public function setLon(float $lon): self
    {
        $this->lon = $lon;

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getDist(): ?int
    {
        return $this->dist;
    }

    public function setDist(int $dist): self
    {
        $this->dist = $dist;

        return $this;
    }
}
