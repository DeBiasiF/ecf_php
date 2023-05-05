<?php

class Borrowing {

    private int $id;
    private String $startBorrow;
    private String $endBorrow;
    private User $borrower;
    private Good $good;       

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
     * Get the value of startBorrow
     *
     * @return String
     */
    public function getStartBorrow(): String
    {
        return $this->startBorrow;
    }

    /**
     * Set the value of startBorrow
     *
     * @param String $startBorrow
     *
     * @return self
     */
    public function setStartBorrow(String $startBorrow): self
    {
        $this->startBorrow = $startBorrow;

        return $this;
    }

    /**
     * Get the value of endBorrow
     */ 
    public function getEndBorrow()
    {
        return $this->endBorrow;
    }

    /**
     * Set the value of endBorrow
     *
     * @return  self
     */ 
    public function setEndBorrow($endBorrow)
    {
        $this->endBorrow = $endBorrow;

        return $this;
    }

    /**
     * Get the value of borrower
     *
     * @return User
     */
    public function getBorrower(): User
    {
        return $this->borrower;
    }

    /**
     * Set the value of borrower
     *
     * @param User $borrower
     *
     * @return self
     */
    public function setBorrower(User $borrower): self
    {
        $this->borrower = $borrower;

        return $this;
    }

    /**
     * Get the value of good
     *
     * @return Good
     */
    public function getGood(): Good
    {
        return $this->good;
    }

    /**
     * Set the value of good
     *
     * @param Good $good
     *
     * @return self
     */
    public function setGood(Good $good): self
    {
        $this->good = $good;

        return $this;
    }
}
?>