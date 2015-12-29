<?php

    /*
     * The MIT License
     *
     * Copyright 2015 Li Yicheng, Sun Yudong, and Walter Kong.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */

    /**
     * Description of PasswordAuthenticate
     *
     * @author Li Yicheng <liyicheng340 [at] gmail [dot com]>
     */
    include_once("../UniversalConnect.php");
    include_once("./TimeAuthenticate.php");
    include_once("./PrivilegeAuthenticate.php");
    
    class PasswordAuthenticate
    {

        public function authenticatePassword()
        {
            session_start();
            if(!isset($_POST["username"]) || !isset($_POST["password"]))
                return 0;
            $db = UniversalConnect::doConnect();
            $usernameToCheck = $db->real_escape_string(trim($_POST["username"]));
            $passwordToCheck = $db->real_escape_string(trim($_POST["password"]));
            $query = "SELECT userkey, password, usertype FROM users WHERE username=$usernameToCheck LIMIT 1";
            $result = $db->query($query);
            if($result->num_rows < 1)
                return 0;
            while($row = $result->fetch_assoc())
            {
                if(password_verify($passwordToCheck, $row["password"]))
                {
                    if(password_needs_rehash($row["password"], PASSWORD_DEFAULT))
                    {
                        $newHash = password_hash($passwordToCheck, PASSWORD_DEFAULT);
                        $query = "UPDATE users SET password=$newHash WHERE userkey=".$row["userkey"];
                        $db->query($query);
                    }
                    $TimeAuthWorker = new TimeAuthenticate();
                    $PrivAuthWorker = new PrivilegeAuthenticate();
                    if(!$PrivAuthWorker->authenticatePrivilege($row["usertype"]) && !$TimeAuthWorker->authenticateTime())
                        return 2;
                    else
                    {
                        $_SESSION["userkey"] = $row["userkey"];
                        $_SESSION["usertype"] = $row["usertype"];
                        return 1;
                    }
                }
            }
        }

    }
    