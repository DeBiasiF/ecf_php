<?php

class Contact {

    private int $id;
    private String $lastname;
    private String $firstname;
    private String $mail;
    private String $phone;
    private String $birthday;
    private String $file;

    

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
     * Get the value of lastname
     *
     * @return String
     */
    public function getLastname(): String
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @param String $lastname
     *
     * @return self
     */
    public function setLastname(String $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of firstname
     *
     * @return String
     */
    public function getFirstname(): String
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @param String $firstname
     *
     * @return self
     */
    public function setFirstname(String $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of mail
     *
     * @return String
     */
    public function getMail(): String
    {
        return $this->mail;
    }

    /**
     * Set the value of mail
     *
     * @param String $mail
     *
     * @return self
     */
    public function setMail(String $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get the value of phone
     *
     * @return String
     */
    public function getPhone(): String
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @param String $phone
     *
     * @return self
     */
    public function setPhone(String $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of birthday
     *
     * @return String
     */
    public function getBirthday(): String
    {
        return $this->birthday;
    }

    /**
     * Set the value of birthday
     *
     * @param String $birthday
     *
     * @return self
     */
    public function setBirthday(String $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get the value of file
     *
     * @return String
     */
    public function getFile(): String
    {
        return $this->file;
    }

    /**
     * Set the value of file
     *
     * @param String $file
     *
     * @return self
     */
    public function setFile(String $file): self
    {
        $this->file = $file;

        return $this;
    }
}
