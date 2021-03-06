<?php 

    $errors = array();
    $success = array();
    if(!empty($_POST))
    {
        $data   = sanetize($_POST);
        $errors = check($data);

        // Add
        if(empty($errors))
        {
            $prepare = $pdo->prepare('INSERT INTO users (login,password,email,age) VALUES (:login,:password,:email,:age)');
            $prepare->bindValue(':login',$data['login']);
            $prepare->bindValue(':password',$data['password']);
            $prepare->bindValue(':email',$data['email']);
            $prepare->bindValue(':age',$data['age']);
            $prepare->execute();

            // Success message
            $success[] = 'User saved';

            // Set default
            $data = array(
                'login'    => '',
                'password' => '',
                'email'    => '',
                'age'      => 25
            );
        }
    }
    else
    {
        // Set default
        $data = array(
            'login'    => '',
            'password' => '',
            'email'    => '',
            'age'      => 25
        );
    }

    function sanetize($data)
    {
        $data['login']    = strip_tags(trim($data['login']));
        $data['password'] = strip_tags(trim($data['password']));
        $data['email']    = strip_tags(trim($data['email']));
        $data['age']      = (int)$data['age'];

        return $data;
    }

    function check($data)
    {
        $errors = array();

        // Login
        if(empty($data['login']))
            $errors['login'] = 'You should fill you login';
        else if(strlen($data['login']) < 3)
            $errors['login'] = 'Login should be 3 chars length minimum';
        else if(strlen($data['login']) > 30)
            $errors['login'] = 'Login should be 30 chars length maximum';

        // Password
        if(empty($data['password']))
            $errors['password'] = 'You should fill you password';
        else if(strlen($data['password']) < 3)
            $errors['password'] = 'Password should be 3 chars length minimum';
        else if(strlen($data['password']) > 30)
            $errors['password'] = 'Password should be 30 chars length maximum';

        // Email
        if(empty($data['email']))
            $errors['email'] = 'You should fill you email';
        else if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL))
            $errors['email'] = 'Wrong email';

        // Age
        if($data['age'] < 18)
            $errors['age'] = 'Too young';

        return $errors;
    }


















