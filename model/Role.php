<?php

class Role {

    private int $id;
    private String $name;

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
}       
?>