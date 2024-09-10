<?php
class FormValidator
{
  private $name;
  private $email;
  private $password;
  private $website;
  private $comment;
  private $gender;
  private $errors = [];

  public function __construct($postData)
  {
    $this->name = $this->test_input($postData['name'] ?? '');
    $this->email = $this->test_input($postData['email'] ?? '');
    $this->password = $this->test_input($postData['password'] ?? '');
    $this->website = $this->test_input($postData['website'] ?? '');
    $this->comment = $this->test_input($postData['comment'] ?? '');
    $this->gender = $this->test_input($postData['gender'] ?? '');
  }

  public function validate()
  {
    $this->validateName();
    $this->validateEmail();
    $this->validatePassword();
    $this->validateWebsite();
    $this->validateGender();
  }

  private function validateName()
  {
    if (empty($this->name)) {
      $this->errors['name'] = 'Name is required';
    } elseif (!preg_match('/^[a-zA-Z-\' ]*$/', $this->name)) {
      $this->errors['name'] = 'Only letters and white space allowed';
    }
  }

  private function validateEmail()
  {
    if (empty($this->email)) {
      $this->errors['email'] = 'Email is required';
    } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
      $this->errors['email'] = 'Invalid email format';
    }
  }

  private function validatePassword()
  {
    if (empty($this->password)) {
      $this->errors['password'] = 'Password is required';
    } elseif (strlen($this->password) < 6) {
      $this->errors['password'] = 'Password must be at least 6 characters long';
    }
  }

  private function validateWebsite()
  {
    if (!empty($this->website) && !preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i',
        $this->website)) {
      $this->errors['website'] = 'Invalid URL';
    }
  }

  private function validateGender()
  {
    if (empty($this->gender)) {
      $this->errors['gender'] = 'Gender is required';
    }
  }

  private function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  public function getErrors()
  {
    return $this->errors;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function getWebsite()
  {
    return $this->website;
  }

  public function getComment()
  {
    return $this->comment;
  }

  public function getGender()
  {
    return $this->gender;
  }

  public function getPassword()
  {
    return $this->password;
  }
}

?>
