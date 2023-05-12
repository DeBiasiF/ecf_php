<?php

class Good {

    private int $id;
    private String $name;
    private String $img;
    private String $description;
    private bool $status;
    private Category $category;
    private User $lender;       

    
    /**
     * Good constructor.
     * @param int $id
     * @param string $name
     * @param string $img
     * @param string $description
     * @param bool $status
     * @param Category $category
     * @param User $lender
     */
    public function __construct(int $id, string $name, string $img, string $description, bool $status, Category $category, User $lender)
    {
        $this->id = $id;
        $this->name = $name;
        $this->img = $img;
        $this->description = $description;
        $this->status = $status;
        $this->category = $category;
        $this->lender = $lender;
    }


    /**
     * Get the value of id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     *
     * @return String
     */
    public function getName(): String
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param String $name
     *
     * @return self
     */
    public function setName(String $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of img
     *
     * @return String
     */
    public function getImg(): String
    {
        return $this->img;
    }

    /**
     * Set the value of img
     *
     * @param String $img
     *
     * @return self
     */
    public function setImg(String $img): self
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get the value of description
     *
     * @return String
     */
    public function getDescription(): String
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param String $description
     *
     * @return self
     */
    public function setDescription(String $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of status
     *
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param bool $status
     *
     * @return self
     */
    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of category
     *
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @param Category $category
     *
     * @return self
     */
    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get the value of lender
     *
     * @return User
     */
    public function getLender(): User
    {
        return $this->lender;
    }

    /**
     * Set the value of lender
     *
     * @param User $lender
     *
     * @return self
     */
    public function setLender(User $lender): self
    {
        $this->lender = $lender;

        return $this;
    }
}
?>