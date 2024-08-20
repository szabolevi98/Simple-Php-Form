<?php

class FormHandler {
    /**
     * @var mysqli
     */
    private mysqli $conn;
    /**
     * @var string|null
     */
    private ?string $name = null;
    /**
     * @var string|null
     */
    private ?string $nameError = null;
    /**
     * @var string|null
     */
    private ?string $email = null;
    /**
     * @var string|null
     */
    private ?string $emailError = null;
    /**
     * @var string|null
     */
    private ?string $phone = null;
    /**
     * @var string|null
     */
    private ?string $phoneError = null;
    /**
     * @var string|null
     */
    private ?string $message = null;
    /**
     * @var string|null
     */
    private ?string $messageError = null;
    /**
     * @var string|null
     */
    private ?string $successMessage = null;
    /**
     * @var string|null
     */
    private ?string $errorMessage = null;

    /**
     * @param string $host
     * @param string $userName
     * @param string $password
     * @param string $database
     * @throws Exception
     */
    public function __construct(string $host, string $userName, string $password, string $database) {
        $this->conn = new mysqli($host, $userName, $password, $database);
        if ($this->conn->connect_error) {
            throw new Exception("Connection failed: " . $this->conn->connect_error);
        }
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getNameError(): ?string
    {
        return $this->nameError;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getEmailError(): ?string
    {
        return $this->emailError;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return string|null
     */
    public function getPhoneError(): ?string
    {
        return $this->phoneError;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @return string|null
     */
    public function getMessageError(): ?string
    {
        return $this->messageError;
    }

    /**
     * @return string|null
     */
    public function getSuccessMessage(): ?string
    {
        return $this->successMessage;
    }

    /**
     * @return string|null
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * @param string|null $data
     * @param string $fieldName
     * @param int $minLength
     * @param int $maxLength
     * @param bool $isEmail
     * @return string|null
     */
    public function validateInput(?string $data, string $fieldName, int $minLength = 0, int $maxLength = 255, bool $isEmail = false): ?string
    {
        $error = null;
        if (empty($data)) {
            $error = ucfirst($fieldName) . " is required";
        } elseif ($isEmail && !filter_var($data, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format";
        } elseif (strlen($data) < $minLength || strlen($data) > $maxLength) {
            $error = ucfirst($fieldName) . " must be between $minLength and $maxLength characters";
        }
        return $error;
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $phone
     * @param string $message
     * @return bool
     */
    public function saveMessage(string $name, string $email, string $phone, string $message): bool
    {
        $sql = "INSERT INTO messages (name, email, phone, message) VALUES (?, ?, ?, ?)";

        $statement = $this->conn->prepare($sql);
        if ($statement === false) {
            $this->errorMessage = "Query prepare failed: " . $this->conn->error;
            return false;
        }
        $statement->bind_param("ssss", $name, $email, $phone, $message);

        if ($statement->execute()) {
            $statement->close();
            $this->name = null;
            $this->email = null;
            $this->phone = null;
            $this->message = null;
            return true;
        } else {
            $this->errorMessage = "Query execution failed: " . $statement->error;
            $statement->close();
            return false;
        }
    }

    /**
     * @param $postData
     * @return void
     */
    public function handleRequest($postData): void
    {
        $this->name = $postData['name'] ?? "";
        $this->email = $postData['email'] ?? "";
        $this->phone = $postData['phone'] ?? "";
        $this->message = $postData['message'] ?? "";

        $this->nameError = $this->validateInput($this->name, "name", 3, 100);
        $this->emailError = $this->validateInput($this->email, "email", 3, 255, true);
        $this->phoneError = $this->validateInput($this->phone, "phone", 7, 15);
        $this->messageError = $this->validateInput($this->message, "message", 10, 1000);

        if (!$this->nameError && !$this->emailError && !$this->phoneError && !$this->messageError) {
            if ($this->saveMessage($this->name, $this->email, $this->phone, $this->message)) {
                $this->successMessage = "Message sent successfully!";
            }
        }
    }

    public function __destruct() {
        $this->conn->close();
    }
}
