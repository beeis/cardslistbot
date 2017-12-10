<?php

namespace CardsList\BotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chat
 *
 * @ORM\Table(
 *     name="chat",
 *     indexes={@ORM\Index(name="old_id", columns={"old_id"})},
 *     options={"collate"="utf8mb4_unicode_520_ci", "charset"="utf8mb4"})
 * @ORM\Entity
 */
class Chat
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=160, nullable=false)
     */
    private $type = '';

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, options={"fixed" = true, "default"=""})
     */
    private $title = '';

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=true, options={"fixed" = true})
     */
    private $username;

    /**
     * @var boolean
     *
     * @ORM\Column(name="all_members_are_administrators", type="boolean", nullable=true, options={"default"=false})
     */
    private $allMembersAreAdministrators = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="old_id", type="bigint", nullable=true)
     */
    private $oldId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="CardsList\BotBundle\Entity\User", mappedBy="chat")
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }

}

