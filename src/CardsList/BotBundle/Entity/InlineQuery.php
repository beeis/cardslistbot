<?php

namespace CardsList\BotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InlineQuery
 *
 * @ORM\Table(
 *     name="inline_query",
 *     indexes={@ORM\Index(name="user_id", columns={"user_id"})},
 *     options={"collate"="utf8mb4_unicode_520_ci", "charset"="utf8mb4"})
 * @ORM\Entity
 */
class InlineQuery
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", length=20, options={"unsigned"=true, "comment" = "Unique identifier for this query"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=true, options={"fixed" = true, "comment" = "Location of the user"})
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="query", type="text", length=65535, nullable=false, options={"comment" = "Text of the query"})
     */
    private $query;

    /**
     * @var string
     *
     * @ORM\Column(name="offset", type="string", length=255, nullable=true, options={"fixed" = true, "comment" = "Offset of the result"})
     */
    private $offset;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true, options={"comment" = "Entry date creation"})
     */
    private $createdAt;

    /**
     * @var \CardsList\BotBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="CardsList\BotBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;


}

