<?php

/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\Entity\Network;

use CertUnlp\NgenBundle\Entity\Contact\Contact;
use CertUnlp\NgenBundle\Entity\Contact\ContactEmail;
use CertUnlp\NgenBundle\Entity\Contact\ContactPhone;
use CertUnlp\NgenBundle\Entity\Contact\ContactTelegram;
use CertUnlp\NgenBundle\Entity\Entity;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;


/**
 * NetworkAdmin
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="CertUnlp\NgenBundle\Repository\NetworkAdminRepository")
 * @JMS\ExclusionPolicy("all")
 */
class NetworkAdmin extends Entity
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     * @JMS\Expose()
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=100,nullable=true,unique=true)
     * */
    private $slug;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Contact\Contact",mappedBy="network_admin",cascade={"persist"},orphanRemoval=true)
     */
    private $contacts;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CertUnlp\NgenBundle\Entity\Network\Network",mappedBy="network_admin"))
     */
    private $networks;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @JMS\Expose()
     */
    private $isActive = true;

    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $createdAt;

    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d h:m:s'>")
     */
    private $updatedAt;

    /**
     * Constructor
     * @param string $name
     */
    public function __construct(string $name = '')
    {
        $this->setName($name);
        $this->networks = new ArrayCollection();
        $this->contacts = new ArrayCollection();
    }

    public function addContact(Contact $contact): NetworkAdmin
    {
        $newObj = $contact;
        switch ($contact->getContactType()) {
            case 'telegram':
                $newObj = $contact->castAs(new ContactTelegram());
                break;
            case 'mail':
                $newObj = $contact->castAs(new ContactEmail());
                break;
            case 'phone':
                $newObj = $contact->castAs(new ContactPhone());
                break;
        }

        if (!$this->contacts->contains($newObj)) {
            $newObj->setNetworkAdmin($this);
        }
        $this->contacts->add($newObj);
        return $this;

    }

    public function removeContact(Contact $contact): NetworkAdmin
    {
        $this->contacts->removeElement($contact);
        $contact->setNetworkAdmin();
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get id
     *
     * @param int $id
     * @return integer
     */
    public function setId(int $id = null): int
    {
        return $this->id = $id;
    }

    /**
     * Add networks
     *
     * @param Network $networks
     * @return NetworkAdmin
     */
    public function addNetwork(Network $networks): NetworkAdmin
    {
        $this->networks[] = $networks;

        return $this;
    }

    /**
     * Remove networks
     *
     * @param Network $networks
     * @return bool
     */
    public function removeNetwork(Network $networks): bool
    {
        return $this->networks->removeElement($networks);
    }

    /**
     * Get networks
     *
     * @return Collection
     */
    public function getNetworks(): Collection
    {
        return $this->networks;
    }

    public function __toString(): string
    {
        return $this->getName() . ' (' . $this->getEmailsAsString() . ')';
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return NetworkAdmin
     */
    public function setName(string $name): NetworkAdmin
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get emails
     *
     * @return string
     */
    public function getEmailsAsString(): string
    {
        return implode(',', $this->getEmails());
    }

    /**
     * Get emails
     *
     * @return array
     */
    public function getEmails(): array
    {
        $array_mails = $this->getContacts()->map(static function (Contact $value) {
            return $value->getEmail();
        }); // [2, 3, 4]
        return $array_mails->toArray();
    }

    /**
     * @param int|null $priorityCode
     * @return Collection
     */
    public function getContacts(int $priorityCode = null): Collection
    {
        if ($priorityCode !== null) {
            return $this->contacts->filter(static function (Contact $contact) use ($priorityCode) {
                return $contact->getContactCase()->getLevel() >= $priorityCode;
            });
        }

        return $this->contacts;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return NetworkAdmin
     */
    public function setSlug(string $slug): NetworkAdmin
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return NetworkAdmin
     */
    public function setIsActive(bool $isActive): NetworkAdmin
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param DateTime $createdAt
     * @return NetworkAdmin
     */
    public function setCreatedAt(DateTime $createdAt): NetworkAdmin
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt
     *
     * @param DateTime $updatedAt
     * @return NetworkAdmin
     */
    public function setUpdatedAt(DateTime $updatedAt): NetworkAdmin
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'users';
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return 'info';
    }
}
