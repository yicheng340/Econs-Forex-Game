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
     * Description of UniversalConnect
     *
     * @author Li Yicheng <liyicheng340 [at] gmail [dot com]>
     */
    include_once("IConnectInfo.php");

    class UniversalConnect implements IConnectInfo
    {

        private static $server = IConnectInfo::SERVER;
        private static $database = IConnectInfo::DATABASE;
        private static $password = IConnectInfo::PASSWORD;
        private static $username = IConnectInfo::USERNAME;
        private static $db_connection;

        public function doConnect()
        {
            self::$db_connection = new mysqli(self::$server, self::$username, self::$password, self::$database);
            return self::$db_connection;
        }

    }
    