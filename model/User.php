<?php

class User {

    private int $id;
    private String $name;
    private String $password;
    private int $points;
    private Role $role;

    /**
     * User constructor.
     * @param int $id
     * @param string $name
     * @param string $password
     * @param int $reward
     * @param Role $role
     */
    public function __construct(int $id, String $name, String $password, int $points, Role $role)
    {
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->points = $points;
        $this->role = $role;
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
     * Get the value of password
     *
     * @return String
     */
    public function getPassword(): String
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param String $password
     *
     * @return self
     */
    public function setPassword(String $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of points
     *
     * @return int
     */
    public function getPoints(): int
    {
        return $this->points;
    }

    /**
     * Set the value of points
     *
     * @param int $points
     *
     * @return self
     */
    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get the value of role
     *
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @param Role $role
     *
     * @return self
     */
    public function setRole(Role $role): self
    {
        $this->role = $role;

        return $this;
    }
}
?>