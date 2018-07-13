<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModelesRepository")
 * @Vich\Uploadable
 */
class Modeles
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $ajoutAt;

    /**
     * @Vich\UploadableField(mapping="modeles_image", fileNameProperty="imageName", size="imageSize")
     */
    private $ImageFile;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $ImageName;

    /**
     * @ORM\Column(type="integer")
     */
    private $ImageSize;

    public function getId()
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAjoutAt(): ?\DateTimeInterface
    {
        return $this->ajoutAt;
    }

    public function setAjoutAt(\DateTimeInterface $ajoutAt): self
    {
        $this->ajoutAt = $ajoutAt;

        return $this;
    }
    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     * @throws \Exception
     */
    public function setImageFile(?File $image = null): void
    {
        $this->ImageFile = $image;

        if (null !== $image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->ajoutAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile()
    {
        return $this->ImageFile;
    }

    public function getImageName(): ?string
    {
        return $this->ImageName;
    }

    public function setImageName(string $imageName): void
    {
        $this->ImageName = $imageName;
    }

    public function getImageSize(): ?int
    {
        return $this->ImageSize;
    }

    public function setImageSize(int $imageSize): void
    {
        $this->ImageSize = $imageSize;
    }
}
