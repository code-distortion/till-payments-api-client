<?php

namespace CodeDistortion\TillPayments\Support\RequestTraits;

trait HasDescriptionTrait
{
    /** @var string|null The description to add. */
    private ?string $description = null;



    /**
     * Set the description.
     *
     * @param string|null $description The description to set.
     * @return $this
     */
    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get the description.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}
