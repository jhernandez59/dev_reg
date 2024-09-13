<?php
class FormValidator
{
  private $name;
  private $surname;
  private $phone;
  private $email;
  private $password;
  private $confirm_password;
  private $website;
  private $comment;
  private $gender;
  private $errors = [];

  public function __construct($postData)
  {
    $this->name = $this->test_input($postData['name'] ?? '');
    $this->surname = $this->test_input($postData['surname'] ?? '');
    $this->phone = $this->test_input($postData['phone'] ?? '');
    $this->email = $this->test_input($postData['email'] ?? '');
    $this->password = $this->test_input($postData['password'] ?? '');
    $this->confirm_password = $this->test_input($postData['confirm_password'] ?? '');
    $this->website = $this->test_input($postData['website'] ?? '');
    $this->comment = $this->test_input($postData['comment'] ?? '');
    $this->gender = $this->test_input($postData['gender'] ?? '');
  }

  public function validate()
  {
    $this->validateName();
    $this->validateSurname();
    $this->validatePhone();
    $this->validateEmail();
    $this->validatePassword();
    $this->validateConfirmPassword();
    $this->validateWebsite();
    $this->validateGender();
  }

  protected function validateName()
  {
    if (empty($this->name)) {
      $this->errors['name'] = 'Name is required';
    } elseif (!preg_match('/^[a-zA-Z-\' ]*$/', $this->name)) {
      $this->errors['name'] = 'Only letters and white space allowed';
    }
  }

  protected function validateSurname()
  {
    if (empty($this->surname)) {
      $this->errors['surname'] = 'Surname is required';
    } elseif (!preg_match('/^[a-zA-Z-\' ]*$/', $this->surname)) {
      $this->errors['surname'] = 'Only letters and white space allowed';
    }
  }

  protected function validatePhone()
  {
    if (empty($this->phone)) {
      $this->errors['phone'] = 'Phone is required';
    } elseif (!preg_match('/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/', $this->phone)) {
      $this->errors['phone'] = 'Invalid phone format';
    }
  }

  protected function validateEmail()
  {
    if (empty($this->email)) {
      $this->errors['email'] = 'Email is required';
    } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
      $this->errors['email'] = 'Invalid email format';
    }
  }

  protected function validatePassword()
  {
    if (empty($this->password)) {
      $this->errors['password'] = 'Password is required';
    } elseif (strlen($this->password) < 4) {
      $this->errors['password'] = 'Password must be at least 6 characters long';
    }
  }

  protected function validateConfirmPassword()
  {
    if (empty($this->confirm_password)) {
      $this->errors['confirm_password'] = 'Confirm Password is required';
    } elseif (strlen($this->confirm_password) < 4) {
      $this->errors['confirm_password'] = 'Confirm Password must be at least 6 characters long';
    }
  }

  protected function validateWebsite()
  {
    if (!empty($this->website) && !preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i',
        $this->website)) {
      $this->errors['website'] = 'Invalid URL';
    }
  }

  protected function validateGender()
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

  public function getSurname()
  {
    return $this->surname;
  }

  public function getPhone()
  {
    return $this->phone;
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

  public function getConfirmPassword()
  {
    return $this->confirm_password;
  }
}

?>
