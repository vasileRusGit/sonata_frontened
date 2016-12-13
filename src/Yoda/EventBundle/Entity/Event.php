<?php

namespace Yoda\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Event
 *
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="Yoda\EventBundle\Repository\EventRepository")
 */
class Event
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="product_name", type="string", length=255)
     */
    private $product_name;

    /**
     * @var string
     *
     * @ORM\Column(name="car_mark", type="string", length=255)
     */
    private $car_mark;

    /**
     * @var string
     *
     * @ORM\Column(name="car_model", type="string", length=255)
     */
    private $car_model;

    /**
     * @var string
     *
     * @ORM\Column(name="car_year", type="string", length=255)
     */
    private $car_year;

    /**
     * @var boolean
     *
     * @ORM\Column(name="stock", type="boolean")
     */
    private $stock;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="string", length=255)
     */
    private $details;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted;

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * @Assert\File(maxSize="6000000")
     */
    private $files;

    /**
     *
     * @ORM\Column(name="cover", type="string")
     */
    private $cover;


    /**
     * @param string $cover
     */
    public function setCover($cover)
    {
        $this->cover = $cover;
    }

    /**
     * Get Cover
     * @return string
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Sets Files
     * @param UploadedFile $files
     */
    public function setFiles(UploadedFile $files = null)
    {
        $this->files = $files;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFiles()
    {
        return $this->files;
    }


    /**
     * Get web path to upload directory
     *
     * @return string
     */
    protected function getUploadPath()
    {
        return 'uploads/covers';
    }

    /**
     * Get absolute path to upload directory
     *
     * @return string
     */
    protected function getUploadAbsolutePath()
    {
        return __DIR__ . '/../../../../web/' . $this->getUploadPath();
    }

    /**
     * Get path to a cover
     *
     * @return null|string
     */
    public function getCoverWeb()
    {
        return NULL === $this->getCover() ? NULL : $this->getUploadPath() . '/' . $this->getCover();
    }

    /**
     * Get path on disk to a cover
     *
     * @return null|string
     */
    public function getCoverAbsolute()
    {
        return NULL === $this->getCover() ? NULL : $this->getUploadAbsolutePath() . '/' . $this->getCover();
    }

    /**
     * Upload a cover File
     */
    public function upload()
    {
        if (null === $this->getFiles()) {
            return;
        }

        $filename = $this->getFiles()->getClientOriginalName();

        // move the uploaded file to target directory using original name
        $this->getFiles()->move($this->getUploadAbsolutePath(), $filename);

        // set the cover
        $this->setCover($filename);

        // cleanup
        $this->setFiles();
        return 'Done';
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set product_name
     *
     * @param string $product_name
     * @return Event
     */
    public function setProductName($product_name)
    {
        $this->product_name = $product_name;

        return $this;
    }

    /**
     * Get product_name
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->product_name;
    }

    /**
     * Set details
     *
     * @param string $details
     * @return Event
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @return string
     */
    public function getCarMark()
    {
        return $this->car_mark;
    }

    /**
     * @param string $car_mark
     */
    public function setCarMark($car_mark)
    {
        $this->car_mark = $car_mark;
    }

    /**
     * @return string
     */
    public function getCarModel()
    {
        return $this->car_model;
    }

    /**
     * @param string $car_model
     */
    public function setCarModel($car_model)
    {
        $this->car_model = $car_model;
    }

    /**
     * @return string
     */
    public function getCarYear()
    {
        return $this->car_year;
    }

    /**
     * @param string $car_year
     */
    public function setCarYear($car_year)
    {
        $this->car_year = $car_year;
    }

    /**
     * @return mixed
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param mixed $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param mixed $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }


}
