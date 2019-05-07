<?php

class Exchange {

    private $receiver;
    private $product;
    private $dateDebut;
    private $dateFin;
    private $emailSender;
    private $dbConnection;

    public function __construct($receiver,$product, $dateDebut, $dateFin, $emailSender, $dbConnection)
    {
        $this->receiver = $receiver;
        $this->product = $product;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->emailSender = $emailSender;
        $this->dbConnection = $dbConnection;
    }

    /**
     * @return mixed
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param mixed $receiver
     */
    public function setReceiver($receiver): void
    {
        $this->receiver = $receiver;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product): void
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param mixed $dateDebut
     */
    public function setDateDebut($dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return mixed
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param mixed $dateFin
     */
    public function setDateFin($dateFin): void
    {
        $this->dateFin = $dateFin;
    }

    /**
     * @return mixed
     */
    public function getEmailSender()
    {
        return $this->emailSender;
    }

    /**
     * @param mixed $emailSender
     */
    public function setEmailSender($emailSender): void
    {
        $this->emailSender = $emailSender;
    }

    /**
     * @return mixed
     */
    public function getDbConnection()
    {
        return $this->dbConnection;
    }

    /**
     * @param mixed $dbConnection
     */
    public function setDbConnection($dbConnection): void
    {
        $this->dbConnection = $dbConnection;
    }

    public function save() {
        if ($this->isValid()) {
            try {
                $this->dbConnection->saveUser($this->receiver);
                $this->dbConnection->saveProduct($this->product);
                $this->dbConnection->saveExchange($this);
            } catch (Exception $e) {
                return false;
            }
            if ($this->receiver->getAge() < 18) {
                $this->emailSender->sendEmail($this->receiver->getEmail(), 'vous devez etre majeur !');
            }
            return true;
        } else {
            return false;
        }
    }

    public function isValid() {
        $dateCheckExchange = new DateTime();
        return $this->receiver->isValid()
            && $this->product->isValid()
            && $this->dateDebut > $dateCheckExchange->format('Y-m-d')
            && $this->dateFin > $this->dateDebut
            && !empty($this->receiver)
            && !empty($this->product)
            && !empty($this->dateDebut)
            && !empty($this->dateFin);
    }
}

?>